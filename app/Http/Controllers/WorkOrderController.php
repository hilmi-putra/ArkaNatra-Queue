<?php

namespace App\Http\Controllers;

use App\Models\WorkOrderModel;
use App\Models\CustomerModel;
use App\Models\AccessCredentialModel;
use App\Models\DivisionModel;
use App\Models\User;
use App\Models\WorkTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WorkOrderController extends Controller
{
    public function index()
    {
        // Ambil data work orders dengan relasi yang diperlukan
        $data = WorkOrderModel::with(['customer', 'division', 'workType'])
            ->get()
            ->map(function ($order) {
                // Hitung estimasi untuk setiap work order
                $order->calculated_estimation = $this->calculateEstimation($order);
                return $order;
            });

        return view('work-orders.index', compact('data'));
    }

    public function apiWorkOrders()
    {
        // API endpoint untuk frontend (JSON response)
        $workOrders = WorkOrderModel::with(['customer', 'division', 'workType'])
            ->where('status', 'queue') // Hanya yang status antrian
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'ref_id' => $order->ref_id,
                    'customer_name' => $order->customer->name ?? '-',
                    'work_type' => $order->workType->work_type ?? '-',
                    'quantity' => $order->quantity,
                    'fast_track' => $order->fast_track,
                    'status' => $order->status,
                    'calculated_estimation' => $this->calculateEstimation($order),
                    'calculated_estimation_days' => $this->calculateEstimationDays($order),
                    'date_queue' => $order->date_queue,
                    'estimasi_date' => $order->estimasi_date,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $workOrders,
            'message' => 'Work orders retrieved successfully'
        ]);
    }

    /**
     * Menghitung estimasi dalam hari
     */
    private function calculateEstimationDays($workOrder)
    {
        // Pastikan work type dan data estimasi tersedia
        if (!$workOrder->workType) {
            return 0;
        }

        $workType = $workOrder->workType;
        $quantity = $workOrder->quantity ?? 1;
        
        // Hitung estimasi dasar
        $baseEstimation = $workOrder->fast_track 
            ? $workType->fast_track_estimation_days 
            : $workType->regular_estimation_days;

        // Hitung tambahan untuk quantity
        $extraDays = ($quantity - 1) * ($workType->extra_days_per_quantity ?? 0);

        return $baseEstimation + $extraDays;
    }

    /**
     * Menghitung estimasi tanggal selesai
     */
    private function calculateEstimation($workOrder)
    {
        if ($workOrder->status !== 'queue' || !$workOrder->date_queue) {
            return $workOrder->estimasi_date;
        }

        $estimationDays = $this->calculateEstimationDays($workOrder);
        
        if ($estimationDays <= 0) {
            return $workOrder->estimasi_date;
        }

        // Hitung tanggal estimasi berdasarkan date_queue + estimasi hari
        try {
            $queueDate = \Carbon\Carbon::parse($workOrder->date_queue);
            $estimatedDate = $queueDate->addDays($estimationDays);
            
            return $estimatedDate->format('Y-m-d');
        } catch (\Exception $e) {
            return $workOrder->estimasi_date;
        }
    }

    /**
     * Untuk real-time update (bisa dipanggil via AJAX)
     */
    public function getQueueEstimations()
    {
        $queueOrders = WorkOrderModel::with(['workType'])
            ->where('status', 'queue')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'ref_id' => $order->ref_id,
                    'estimated_days' => $this->calculateEstimationDays($order),
                    'estimated_date' => $this->calculateEstimation($order),
                    'current_estimasi_date' => $order->estimasi_date,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $queueOrders
        ]);
    }

    public function create()
    {
        $divisions = DivisionModel::all();
        $workTypes = WorkTypeModel::all();
        $customers = CustomerModel::all();
        $salesUsers = User::role('sales')->get();
        $productionUsers = User::role('production')->get();
        
        return view('work-orders.form', compact('divisions', 'workTypes', 'customers', 'productionUsers', 'salesUsers'));
    }

    public function store(Request $request)
{
    return DB::transaction(function () use ($request) {
        // Validasi berdasarkan tipe customer
        $validationRules = [
            'sales_id' => 'required|exists:users,id',
            'production_id' => 'required|exists:users,id',
            // Work Order Data
            'division_id' => 'required|exists:table_division,id',
            'work_type_id' => 'required|exists:table_work_types,id',
            'domain' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            
            // File Uploads
            'file_mou' => 'nullable|file|mimes:doc,docx,pdf|max:5120',
            'file_work_form' => 'nullable|file|mimes:doc,docx,pdf|max:5120',
            'additional_file' => 'nullable|file|mimes:doc,docx,pdf|max:5120',
            
            // Access Types
            'access_types' => 'nullable|array',
            'access_types.*' => 'in:ojs,cpanel,webmail,website',
            'access_note' => 'nullable|string',
        ];

        // Tambahkan validasi berdasarkan tipe customer
        if ($request->customer_type === 'existing') {
            $validationRules['existing_customer_id'] = 'required|exists:table_customer,id';
        } else {
            $validationRules['customer_name'] = 'required|string|max:255';
            $validationRules['customer_email'] = 'required|email';
            $validationRules['customer_phone'] = 'required|string|max:20';
            $validationRules['customer_address'] = 'required|string';
        }

        $validated = $request->validate($validationRules, [
            'file_mou.mimes' => 'File MOU harus berupa dokumen Word (.doc, .docx) atau PDF (.pdf)',
            'file_work_form.mimes' => 'File Work Form harus berupa dokumen Word (.doc, .docx) atau PDF (.pdf)',
            'additional_file.mimes' => 'File Tambahan harus berupa dokumen Word (.doc, .docx) atau PDF (.pdf)',
            'file_mou.max' => 'File MOU maksimal 5MB',
            'file_work_form.max' => 'File Work Form maksimal 5MB',
            'additional_file.max' => 'File Tambahan maksimal 5MB',
        ]);

        // 1. Handle Customer Data
        if ($request->customer_type === 'existing') {
            // Gunakan customer existing
            $customer = CustomerModel::findOrFail($request->existing_customer_id);
        } else {
            // Buat customer baru
            $customer = CustomerModel::firstOrCreate(
                ['email' => $request->customer_email],
                [
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                    'address' => $request->customer_address,
                    'token' => $this->generateRandomToken(10),
                ]
            );
        }

        // 2. Generate ref_id and antrian_ke - PERBAIKAN
        $refId = 'WO-' . date('Ymd') . '-' . Str::random(6);
        

        // 3. Handle File Uploads
        $filePaths = [];
        $fileFields = ['file_mou', 'file_work_form', 'additional_file'];
        
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                
                // Validasi manual
                $allowedMimes = ['doc', 'docx', 'pdf'];
                $extension = $file->getClientOriginalExtension();
                
                if (!in_array(strtolower($extension), $allowedMimes)) {
                    throw ValidationException::withMessages([
                        $field => ['File harus berupa dokumen Word (.doc, .docx) atau PDF (.pdf)']
                    ]);
                }
                
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeName = Str::slug($originalName);
                $filename = $safeName . '_' . time() . '_' . Str::random(5) . '.' . $extension;
                
                $filePaths[$field] = $file->storeAs('work-orders', $filename, 'public');
            }
        }

        // 4. Create Work Order
        $workOrder = WorkOrderModel::create([
            'ref_id' => $refId,
            'customer_id' => $customer->id,
            'sales_id' => $request->sales_id,
            'production_id' => $request->production_id,
            'division_id' => $request->division_id,
            'work_type_id' => $request->work_type_id,
            'domain' => $request->domain,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'status' => 'validate',
            'fast_track' => $request->has('fast_track'),
            'date_received' => now(),
            'file_mou' => $filePaths['file_mou'] ?? null,
            'file_work_form' => $filePaths['file_work_form'] ?? null,
            'additional_file' => $filePaths['additional_file'] ?? null,
        ]);

        // 5. Create Access Credentials
        if ($request->has('access_types')) {
            foreach ($request->access_types as $accessType) {
                $credentialData = [
                    'customer_id' => $customer->id,
                    'work_order_id' => $workOrder->id,
                    'status' => 'active',
                    'note' => $request->input('access_note'),
                    'expiration_date' => null,
                ];
                
                switch ($accessType) {
                    case 'ojs':
                        $credentialData['akses_ojs'] = $request->input('access_credentials.ojs.url');
                        $credentialData['username_ojs'] = $request->input('access_credentials.ojs.username');
                        $credentialData['password_ojs'] = $request->input('access_credentials.ojs.password');
                        break;
                        
                    case 'cpanel':
                        $credentialData['akses_cpanel'] = $request->input('access_credentials.cpanel.url');
                        $credentialData['username_cpanel'] = $request->input('access_credentials.cpanel.username');
                        $credentialData['password_cpanel'] = $request->input('access_credentials.cpanel.password');
                        break;
                        
                    case 'webmail':
                        $credentialData['akses_webmail'] = $request->input('access_credentials.webmail.url');
                        $credentialData['username_webmail'] = $request->input('access_credentials.webmail.username');
                        $credentialData['password_webmail'] = $request->input('access_credentials.webmail.password');
                        break;
                        
                    case 'website':
                        $credentialData['access_web'] = $request->input('access_credentials.website.url');
                        $credentialData['username_web'] = $request->input('access_credentials.website.username');
                        $credentialData['password_web'] = $request->input('access_credentials.website.password');
                        break;
                }
                
                if ($this->hasAccessData($credentialData, $accessType)) {
                    AccessCredentialModel::create($credentialData);
                }
            }
        }

        return redirect()->route('asservice.work-orders.index')
            ->with('success', 'Work Order berhasil dibuat');
    });
}



    /**
     * Generate random token dengan kombinasi lengkap
     * 
     * @param int $length
     * @return string
     */
    private function generateRandomToken($length = 10)
    {
        // Karakter yang akan digunakan
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_-+=[]{}|;:,.<>?';
        
        $token = '';
        $max = strlen($characters) - 1;
        
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[random_int(0, $max)];
        }
        
        return $token;
    }

    // Helper method untuk mengecek apakah ada data akses yang diisi
    private function hasAccessData($credentialData, $accessType)
    {
        switch ($accessType) {
            case 'ojs':
                return !empty($credentialData['akses_ojs']) && 
                    !empty($credentialData['username_ojs']) && 
                    !empty($credentialData['password_ojs']);
            case 'cpanel':
                return !empty($credentialData['akses_cpanel']) && 
                    !empty($credentialData['username_cpanel']) && 
                    !empty($credentialData['password_cpanel']);
            case 'webmail':
                return !empty($credentialData['akses_webmail']) && 
                    !empty($credentialData['username_webmail']) && 
                    !empty($credentialData['password_webmail']);
            case 'website':
                return !empty($credentialData['access_web']) && 
                    !empty($credentialData['username_web']) && 
                    !empty($credentialData['password_web']);
            default:
                return false;
        }
    }  
    
    /**
 * Get users dengan role production (Spatie)
 */
    private function getProductionUsers()
    {
        return User::role('production')->get();
    }

    // Helper method untuk mengecek apakah ada data akses yang diisi

    public function edit($id)
    {
        $workOrder = WorkOrderModel::with(['customer', 'customer.accessCredentials'])->findOrFail($id);
        $divisions = DivisionModel::all();
        $workTypes = WorkTypeModel::all();
        $customers = CustomerModel::all();
        $salesUsers = User::role('sales')->get();
        $productionUsers = User::role('production')->get();
        
        return view('work-orders.form', compact('workOrder', 'divisions', 'workTypes', 'customers', 'productionUsers', 'salesUsers'));
    }

    public function update(Request $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $workOrder = WorkOrderModel::findOrFail($id);
            
            // Validasi berdasarkan tipe customer (sama seperti store)
            $validationRules = [
                'user_id' => 'required|exists:users,id', // Tambahkan validasi user_id
                // Work Order Data
                'division_id' => 'required|exists:table_division,id',
                'work_type_id' => 'required|exists:table_work_types,id',
                'domain' => 'nullable|string|max:255',
                'quantity' => 'required|integer|min:1',
                'description' => 'required|string',
                'estimasi_date' => 'required|date',
                
                // File Uploads
                'file_mou' => 'nullable|file|mimes:doc,docx,pdf|max:5120',
                'file_work_form' => 'nullable|file|mimes:doc,docx,pdf|max:5120',
                'additional_file' => 'nullable|file|mimes:doc,docx,pdf|max:5120',
                
                // Access Types
                'access_types' => 'nullable|array',
                'access_types.*' => 'in:ojs,cpanel,webmail,website',
                'access_note' => 'nullable|string',
            ];

            if ($request->customer_type === 'existing') {
                $validationRules['existing_customer_id'] = 'required|exists:table_customer,id';
            } else {
                $validationRules['customer_name'] = 'required|string|max:255';
                $validationRules['customer_email'] = 'required|email';
                $validationRules['customer_phone'] = 'required|string|max:20';
                $validationRules['customer_address'] = 'required|string';
            }

            $validated = $request->validate($validationRules, [
                // Custom error messages
            ]);

            // 1. Handle Customer Data
            if ($request->customer_type === 'existing') {
                $customer = CustomerModel::findOrFail($request->existing_customer_id);
            } else {
                $customer = $workOrder->customer;
                $customer->update([
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'phone' => $request->customer_phone,
                    'address' => $request->customer_address,
                ]);
            }

            // ... sisa kode update method tetap sama
            // 2. Handle File Uploads
            $filePaths = [];
            $fileFields = [
                'file_mou' => $workOrder->file_mou,
                'file_work_form' => $workOrder->file_work_form,
                'additional_file' => $workOrder->additional_file,
            ];
            
            foreach ($fileFields as $field => $currentPath) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    
                    // Validasi manual
                    $allowedMimes = ['doc', 'docx', 'pdf'];
                    $extension = $file->getClientOriginalExtension();
                    
                    if (!in_array(strtolower($extension), $allowedMimes)) {
                        throw ValidationException::withMessages([
                            $field => ['File harus berupa dokumen Word (.doc, .docx) atau PDF (.pdf)']
                        ]);
                    }
                    
                    // Delete old file
                    if ($currentPath) {
                        Storage::disk('public')->delete($currentPath);
                    }
                    
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeName = Str::slug($originalName);
                    $filename = $safeName . '_' . time() . '_' . Str::random(5) . '.' . $extension;
                    
                    $filePaths[$field] = $file->storeAs('work-orders', $filename, 'public');
                } else {
                    $filePaths[$field] = $currentPath;
                }
            }

            // 3. Update Work Order
            $workOrder->update([
                'user_id' => $request->user_id, // Dari select input
                'division_id' => $request->division_id,
                'work_type_id' => $request->work_type_id,
                'domain' => $request->domain,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'estimasi_date' => $request->estimasi_date,
                'fast_track' => $request->has('fast_track'),
                'file_mou' => $filePaths['file_mou'],
                'file_work_form' => $filePaths['file_work_form'],
                'additional_file' => $filePaths['additional_file'],
                'customer_id' => $customer->id, // Update customer_id jika berubah
            ]);

            // 4. Update Access Credentials
            $customer->accessCredentials()->delete();
            
            if ($request->has('access_types')) {
                foreach ($request->access_types as $accessType) {
                    $credentialData = [
                        'customer_id' => $customer->id,
                        'status' => true,
                        'note' => $request->input('access_note'),
                        'expiration_date' => null,
                    ];
                    
                    switch ($accessType) {
                        case 'ojs':
                            $credentialData['akses_ojs'] = $request->input('access_credentials.ojs.url');
                            $credentialData['username_ojs'] = $request->input('access_credentials.ojs.username');
                            $credentialData['password_ojs'] = $request->input('access_credentials.ojs.password');
                            break;
                            
                        case 'cpanel':
                            $credentialData['akses_cpanel'] = $request->input('access_credentials.cpanel.url');
                            $credentialData['username_cpanel'] = $request->input('access_credentials.cpanel.username');
                            $credentialData['password_cpanel'] = $request->input('access_credentials.cpanel.password');
                            break;
                            
                        case 'webmail':
                            $credentialData['akses_webmail'] = $request->input('access_credentials.webmail.url');
                            $credentialData['username_webmail'] = $request->input('access_credentials.webmail.username');
                            $credentialData['password_webmail'] = $request->input('access_credentials.webmail.password');
                            break;
                            
                        case 'website':
                            $credentialData['access_web'] = $request->input('access_credentials.website.url');
                            $credentialData['username_web'] = $request->input('access_credentials.website.username');
                            $credentialData['password_web'] = $request->input('access_credentials.website.password');
                            break;
                    }
                    
                    if ($this->hasAccessData($credentialData, $accessType)) {
                        AccessCredentialModel::create($credentialData);
                    }
                }
            }

            return redirect()->route('asservice.work-orders.index')
                ->with('success', 'Work Order berhasil diperbarui');
        });
    }

/**
 * Helper method untuk mengecek apakah ada data akses yang diisi
 */

/**
 * Generate random token dengan kombinasi lengkap
 */

    public function show($id)
    {
        $workOrder = WorkOrderModel::with(['customer', 'accessCredentials', 'division', 'workType'])->findOrFail($id);
        return view('work-orders.show', compact('workOrder'));
    }

    public function destroy($id)
    {
        $workOrder = WorkOrderModel::findOrFail($id);
        $workOrder->delete();

        return redirect()->route('asservice.work-orders.index')
            ->with('success', 'Work Order berhasil dihapus');
    }
}