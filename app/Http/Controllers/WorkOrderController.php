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
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = WorkOrderModel::with(['customer', 'division', 'workType', 'salesUser', 'productionUser']);
        
        // Filter berdasarkan role
        if ($user->hasRole('production')) {
            $query->where('production_id', $user->id);
        } elseif ($user->hasRole('sales')) {
            $query->where('sales_id', $user->id);
        }

        // Apply filters from request
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('fast_track')) {
            $query->where('fast_track', $request->fast_track);
        }
        
        // Urutkan berdasarkan status sesuai urutan yang diinginkan
        $statusOrder = ['queue', 'pending', 'progress', 'revision', 'migration', 'finish'];
        
        // Buat CASE statement untuk ordering
        $statusOrderCase = "CASE ";
        foreach ($statusOrder as $index => $status) {
            $statusOrderCase .= "WHEN status = '{$status}' THEN {$index} ";
        }
        $statusOrderCase .= "ELSE " . count($statusOrder) . " END";
        
        // Ambil semua data dengan urutan: status sesuai urutan, lalu antrian_ke ASC dengan null di bawah
        $data = $query->orderByRaw($statusOrderCase)
                    ->orderByRaw('CASE WHEN antrian_ke IS NULL THEN 1 ELSE 0 END')
                    ->orderBy('antrian_ke', 'asc')
                    ->get();

        if ($request->ajax()) {
            $html = view('work-orders.partials.table-rows', compact('data'))->render();
            return response()->json(['html' => $html]);
        }
        
        // Query terpisah untuk mendapatkan antrian pertama (bukan null)
        $firstQueueQuery = WorkOrderModel::with(['customer', 'division', 'workType'])
            ->where('status', 'queue')
            ->whereNotNull('antrian_ke'); // Pastikan antrian_ke tidak null
        
        // Apply role filter yang sama untuk firstQueue
        if ($user->hasRole('production')) {
            $firstQueueQuery->where('production_id', $user->id);
        } elseif ($user->hasRole('sales')) {
            $firstQueueQuery->where('sales_id', $user->id);
        }
        
        $firstQueue = $firstQueueQuery->orderBy('antrian_ke', 'asc')->first();
        
        return view('work-orders.index', compact('data', 'firstQueue'));
    }

    public function create()
    {
        $divisions = DivisionModel::all();
        $workTypes = WorkTypeModel::with('division')->get();
        $customers = CustomerModel::all();
        $salesUsers = User::role('sales')->get();
        $productionUsers = User::role('production')->get();
        
        // Build work type to division mapping
        $workTypeDivisionMap = $workTypes->mapWithKeys(function ($workType) {
            return [
                $workType->id => [
                    'division_id' => $workType->division_id,
                    'division_name' => $workType->division?->name ?? 'N/A'
                ]
            ];
        })->toArray();
        
        return view('work-orders.form', compact('divisions', 'workTypes', 'customers', 'productionUsers', 'salesUsers', 'workTypeDivisionMap'));
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

            // Tambahkan validasi untuk access credentials jika ada access_types
            if ($request->has('access_types')) {
                if (in_array('website', $request->access_types)) {
                    $validationRules['access_credentials.website.url'] = 'nullable|string|max:1000';
                    $validationRules['access_credentials.website.username'] = 'nullable|string|max:255';
                    $validationRules['access_credentials.website.password'] = 'nullable|string|max:255';
                }
                if (in_array('ojs', $request->access_types)) {
                    $validationRules['access_credentials.ojs.url'] = 'nullable|string|max:1000';
                    $validationRules['access_credentials.ojs.username'] = 'nullable|string|max:255';
                    $validationRules['access_credentials.ojs.password'] = 'nullable|string|max:255';
                }
                if (in_array('cpanel', $request->access_types)) {
                    $validationRules['access_credentials.cpanel.url'] = 'nullable|string|max:1000';
                    $validationRules['access_credentials.cpanel.username'] = 'nullable|string|max:255';
                    $validationRules['access_credentials.cpanel.password'] = 'nullable|string|max:255';
                }
                if (in_array('webmail', $request->access_types)) {
                    $validationRules['access_credentials.webmail.url'] = 'nullable|string|max:1000';
                    $validationRules['access_credentials.webmail.username'] = 'nullable|string|max:255';
                    $validationRules['access_credentials.webmail.password'] = 'nullable|string|max:255';
                }
            }

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
                'fast_track' => $request->input('fast_track') == '1',
                'date_received' => now(),
                'file_mou' => $filePaths['file_mou'] ?? null,
                'file_work_form' => $filePaths['file_work_form'] ?? null,
                'additional_file' => $filePaths['additional_file'] ?? null,
            ]);

            // 5. Create atau Update Access Credentials (HANYA SATU RECORD PER CUSTOMER)
            if ($request->has('access_types')) {
                // Cek apakah sudah ada access credential untuk customer ini
                $accessCredential = AccessCredentialModel::where('customer_id', $customer->id)->first();
                
                if (!$accessCredential) {
                    // Jika belum ada, buat baru
                    $accessCredential = new AccessCredentialModel();
                    $accessCredential->customer_id = $customer->id;
                    $accessCredential->status = 'active';
                    $accessCredential->note = $request->input('access_note');
                    $accessCredential->expiration_date = null;
                } else {
                    // Jika sudah ada, update note jika ada
                    if ($request->input('access_note')) {
                        $accessCredential->note = $request->input('access_note');
                    }
                }

                // Set boolean flags dan credentials berdasarkan access_types
                foreach ($request->access_types as $accessType) {
                    switch ($accessType) {
                        case 'website':
                            $accessCredential->web = true;
                            $accessCredential->access_web = $request->input('access_credentials.website.url');
                            $accessCredential->username_web = $request->input('access_credentials.website.username');
                            $accessCredential->password_web = $request->input('access_credentials.website.password');
                            break;
                            
                        case 'ojs':
                            $accessCredential->ojs = true;
                            $accessCredential->akses_ojs = $request->input('access_credentials.ojs.url');
                            $accessCredential->username_ojs = $request->input('access_credentials.ojs.username');
                            $accessCredential->password_ojs = $request->input('access_credentials.ojs.password');
                            break;
                            
                        case 'cpanel':
                            $accessCredential->cpanel = true;
                            $accessCredential->akses_cpanel = $request->input('access_credentials.cpanel.url');
                            $accessCredential->username_cpanel = $request->input('access_credentials.cpanel.username');
                            $accessCredential->password_cpanel = $request->input('access_credentials.cpanel.password');
                            break;
                            
                        case 'webmail':
                            $accessCredential->webmail = true;
                            $accessCredential->akses_webmail = $request->input('access_credentials.webmail.url');
                            $accessCredential->username_webmail = $request->input('access_credentials.webmail.username');
                            $accessCredential->password_webmail = $request->input('access_credentials.webmail.password');
                            break;
                    }
                }

                $accessCredential->save();
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
    // Helper method untuk mengecek apakah ada data access
    private function hasAccessData($data, $accessType)
    {
        switch ($accessType) {
            case 'website':
                return !empty($data['access_web']) || !empty($data['username_web']) || !empty($data['password_web']);
            case 'ojs':
                return !empty($data['akses_ojs']) || !empty($data['username_ojs']) || !empty($data['password_ojs']);
            case 'cpanel':
                return !empty($data['akses_cpanel']) || !empty($data['username_cpanel']) || !empty($data['password_cpanel']);
            case 'webmail':
                return !empty($data['akses_webmail']) || !empty($data['username_webmail']) || !empty($data['password_webmail']);
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
        $user = auth()->user();
        
        // Authorization: Allow edit if user is asservice OR if user is production and assigned to this work order
        if (!$user->hasRole('asservice') && !($user->hasRole('production') && $workOrder->production_id === $user->id)) {
            abort(403, 'Unauthorized. You can only edit work orders assigned to you.');
        }
        
        $divisions = DivisionModel::all();
        $workTypes = WorkTypeModel::with('division')->get();
        $customers = CustomerModel::all();
        $salesUsers = User::role('sales')->get();
        $productionUsers = User::role('production')->get();
        
        // Build work type to division mapping
        $workTypeDivisionMap = $workTypes->mapWithKeys(function ($workType) {
            return [
                $workType->id => [
                    'division_id' => $workType->division_id,
                    'division_name' => $workType->division?->name ?? 'N/A'
                ]
            ];
        })->toArray();
        
        // Pass user role to view for conditional rendering
        $isProduction = $user->hasRole('production');
        
        return view('work-orders.form', compact('workOrder', 'divisions', 'workTypes', 'customers', 'productionUsers', 'salesUsers', 'isProduction', 'workTypeDivisionMap'));
    }

    public function update(Request $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $workOrder = WorkOrderModel::findOrFail($id);
            $user = auth()->user();
            
            // Authorization: Allow update if user is asservice OR if user is production and assigned to this work order
            if (!$user->hasRole('asservice') && !($user->hasRole('production') && $workOrder->production_id === $user->id)) {
                abort(403, 'Unauthorized. You can only update work orders assigned to you.');
            }
            
            // Determine which fields are allowed to be updated based on role
            $isProduction = $user->hasRole('production');
            $isAsservice = $user->hasRole('asservice');
            
            // For production: restrict updates to certain fields only
            if ($isProduction) {
                // Production can only update: description, access credentials, and some status-related fields
                // They CANNOT change: customer, division, work_type, sales_id, production_id, domain, quantity
                
                // Validate only allowed fields for production
                $productionValidationRules = [
                    'description' => 'required|string',
                    'access_types' => 'nullable|array',
                    'access_types.*' => 'in:ojs,cpanel,webmail,website',
                    'access_note' => 'nullable|string',
                ];

                // Add access credentials validation if present
                if ($request->has('access_types')) {
                    if (in_array('website', $request->access_types)) {
                        $productionValidationRules['access_credentials.website.url'] = 'nullable|string|max:1000';
                        $productionValidationRules['access_credentials.website.username'] = 'nullable|string|max:255';
                        $productionValidationRules['access_credentials.website.password'] = 'nullable|string|max:255';
                    }
                    if (in_array('ojs', $request->access_types)) {
                        $productionValidationRules['access_credentials.ojs.url'] = 'nullable|string|max:1000';
                        $productionValidationRules['access_credentials.ojs.username'] = 'nullable|string|max:255';
                        $productionValidationRules['access_credentials.ojs.password'] = 'nullable|string|max:255';
                    }
                    if (in_array('cpanel', $request->access_types)) {
                        $productionValidationRules['access_credentials.cpanel.url'] = 'nullable|string|max:1000';
                        $productionValidationRules['access_credentials.cpanel.username'] = 'nullable|string|max:255';
                        $productionValidationRules['access_credentials.cpanel.password'] = 'nullable|string|max:255';
                    }
                    if (in_array('webmail', $request->access_types)) {
                        $productionValidationRules['access_credentials.webmail.url'] = 'nullable|string|max:1000';
                        $productionValidationRules['access_credentials.webmail.username'] = 'nullable|string|max:255';
                        $productionValidationRules['access_credentials.webmail.password'] = 'nullable|string|max:255';
                    }
                }
                
                $validationRules = $productionValidationRules;
            } else {
                // AsService can update all fields (original validation)
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

                // Tambahkan validasi untuk access credentials jika ada access_types
                if ($request->has('access_types')) {
                    if (in_array('website', $request->access_types)) {
                        $validationRules['access_credentials.website.url'] = 'nullable|string|max:1000';
                        $validationRules['access_credentials.website.username'] = 'nullable|string|max:255';
                        $validationRules['access_credentials.website.password'] = 'nullable|string|max:255';
                    }
                    if (in_array('ojs', $request->access_types)) {
                        $validationRules['access_credentials.ojs.url'] = 'nullable|string|max:1000';
                        $validationRules['access_credentials.ojs.username'] = 'nullable|string|max:255';
                        $validationRules['access_credentials.ojs.password'] = 'nullable|string|max:255';
                    }
                    if (in_array('cpanel', $request->access_types)) {
                        $validationRules['access_credentials.cpanel.url'] = 'nullable|string|max:1000';
                        $validationRules['access_credentials.cpanel.username'] = 'nullable|string|max:255';
                        $validationRules['access_credentials.cpanel.password'] = 'nullable|string|max:255';
                    }
                    if (in_array('webmail', $request->access_types)) {
                        $validationRules['access_credentials.webmail.url'] = 'nullable|string|max:1000';
                        $validationRules['access_credentials.webmail.username'] = 'nullable|string|max:255';
                        $validationRules['access_credentials.webmail.password'] = 'nullable|string|max:255';
                    }
                }

                if ($request->customer_type === 'existing') {
                    $validationRules['existing_customer_id'] = 'required|exists:table_customer,id';
                } else {
                    $validationRules['customer_name'] = 'required|string|max:255';
                    $validationRules['customer_email'] = 'required|email';
                    $validationRules['customer_phone'] = 'required|string|max:20';
                    $validationRules['customer_address'] = 'required|string';
                }
            }

            $validated = $request->validate($validationRules, [
                'file_mou.mimes' => 'File MOU harus berupa dokumen Word (.doc, .docx) atau PDF (.pdf)',
                'file_work_form.mimes' => 'File Work Form harus berupa dokumen Word (.doc, .docx) atau PDF (.pdf)',
                'additional_file.mimes' => 'File Tambahan harus berupa dokumen Word (.doc, .docx) atau PDF (.pdf)',
                'file_mou.max' => 'File MOU maksimal 5MB',
                'file_work_form.max' => 'File Work Form maksimal 5MB',
                'additional_file.max' => 'File Tambahan maksimal 5MB',
            ]);

            // Only allow production to update specific fields
            if ($isProduction) {
                // Production: Update only description and access credentials
                
                // 1. Update only description
                $workOrder->description = $request->description;
                
                // 2. Handle file uploads (only if asservice)
                // Production cannot upload files
                
                // 3. Update Access Credentials
                if ($request->has('access_types')) {
                    $customer = $workOrder->customer;
                    
                    // Cari atau buat access credential untuk customer
                    $accessCredential = AccessCredentialModel::where('customer_id', $customer->id)->first();
                    
                    if (!$accessCredential) {
                        $accessCredential = new AccessCredentialModel();
                        $accessCredential->customer_id = $customer->id;
                        $accessCredential->status = 'active';
                        $accessCredential->note = $request->input('access_note');
                        $accessCredential->expiration_date = null;
                    } else {
                        if ($request->input('access_note')) {
                            $accessCredential->note = $request->input('access_note');
                        }
                    }

                    // Reset semua boolean flags terlebih dahulu
                    $accessCredential->web = false;
                    $accessCredential->ojs = false;
                    $accessCredential->cpanel = false;
                    $accessCredential->webmail = false;

                    // Reset credential fields yang tidak dipilih
                    if (!in_array('website', $request->access_types)) {
                        $accessCredential->access_web = null;
                        $accessCredential->username_web = null;
                        $accessCredential->password_web = null;
                    }
                    if (!in_array('ojs', $request->access_types)) {
                        $accessCredential->akses_ojs = null;
                        $accessCredential->username_ojs = null;
                        $accessCredential->password_ojs = null;
                    }
                    if (!in_array('cpanel', $request->access_types)) {
                        $accessCredential->akses_cpanel = null;
                        $accessCredential->username_cpanel = null;
                        $accessCredential->password_cpanel = null;
                    }
                    if (!in_array('webmail', $request->access_types)) {
                        $accessCredential->akses_webmail = null;
                        $accessCredential->username_webmail = null;
                        $accessCredential->password_webmail = null;
                    }

                    // Set boolean flags dan credentials berdasarkan access_types yang dipilih
                    foreach ($request->access_types as $accessType) {
                        switch ($accessType) {
                            case 'website':
                                $accessCredential->web = true;
                                $accessCredential->access_web = $request->input('access_credentials.website.url');
                                $accessCredential->username_web = $request->input('access_credentials.website.username');
                                $accessCredential->password_web = $request->input('access_credentials.website.password');
                                break;
                                
                            case 'ojs':
                                $accessCredential->ojs = true;
                                $accessCredential->akses_ojs = $request->input('access_credentials.ojs.url');
                                $accessCredential->username_ojs = $request->input('access_credentials.ojs.username');
                                $accessCredential->password_ojs = $request->input('access_credentials.ojs.password');
                                break;
                                
                            case 'cpanel':
                                $accessCredential->cpanel = true;
                                $accessCredential->akses_cpanel = $request->input('access_credentials.cpanel.url');
                                $accessCredential->username_cpanel = $request->input('access_credentials.cpanel.username');
                                $accessCredential->password_cpanel = $request->input('access_credentials.cpanel.password');
                                break;
                                
                            case 'webmail':
                                $accessCredential->webmail = true;
                                $accessCredential->akses_webmail = $request->input('access_credentials.webmail.url');
                                $accessCredential->username_webmail = $request->input('access_credentials.webmail.username');
                                $accessCredential->password_webmail = $request->input('access_credentials.webmail.password');
                                break;
                        }
                    }

                    $accessCredential->save();
                } else {
                    // Production tidak memilih access types, hapus semua untuk customer ini
                    AccessCredentialModel::where('customer_id', $workOrder->customer_id)->delete();
                }
                
                $workOrder->save();
                
            } else {
                // AsService: Full update with all fields (original logic)
                
                // 1. Handle Customer Data
                if ($request->customer_type === 'existing') {
                    $customer = CustomerModel::findOrFail($request->existing_customer_id);
                } else {
                    $currentCustomer = $workOrder->customer;
                    
                    if ($currentCustomer->email === $request->customer_email) {
                        $currentCustomer->update([
                            'name' => $request->customer_name,
                            'email' => $request->customer_email,
                            'phone' => $request->customer_phone,
                            'address' => $request->customer_address,
                        ]);
                        $customer = $currentCustomer;
                    } else {
                        $existingCustomer = CustomerModel::where('email', $request->customer_email)->first();
                        
                        if ($existingCustomer) {
                            $customer = $existingCustomer;
                        } else {
                            $customer = CustomerModel::create([
                                'name' => $request->customer_name,
                                'email' => $request->customer_email,
                                'phone' => $request->customer_phone,
                                'address' => $request->customer_address,
                                'token' => $this->generateRandomToken(10),
                            ]);
                        }
                    }
                }

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
                        
                        $allowedMimes = ['doc', 'docx', 'pdf'];
                        $extension = $file->getClientOriginalExtension();
                        
                        if (!in_array(strtolower($extension), $allowedMimes)) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                $field => ['File harus berupa dokumen Word (.doc, .docx) atau PDF (.pdf)']
                            ]);
                        }
                        
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
                    'sales_id' => $request->sales_id,
                    'production_id' => $request->production_id,
                    'division_id' => $request->division_id,
                    'work_type_id' => $request->work_type_id,
                    'domain' => $request->domain,
                    'quantity' => $request->quantity,
                    'description' => $request->description,
                    'estimasi_date' => $request->estimasi_date,
                    'fast_track' => $request->input('fast_track') == '1',
                    'file_mou' => $filePaths['file_mou'],
                    'file_work_form' => $filePaths['file_work_form'],
                    'additional_file' => $filePaths['additional_file'],
                    'customer_id' => $customer->id,
                ]);

                // 4. Update Access Credentials
                if ($request->has('access_types')) {
                    $accessCredential = AccessCredentialModel::where('customer_id', $customer->id)->first();
                    
                    if (!$accessCredential) {
                        $accessCredential = new AccessCredentialModel();
                        $accessCredential->customer_id = $customer->id;
                        $accessCredential->status = 'active';
                        $accessCredential->note = $request->input('access_note');
                        $accessCredential->expiration_date = null;
                    } else {
                        if ($request->input('access_note')) {
                            $accessCredential->note = $request->input('access_note');
                        }
                    }

                    $accessCredential->web = false;
                    $accessCredential->ojs = false;
                    $accessCredential->cpanel = false;
                    $accessCredential->webmail = false;

                    if (!in_array('website', $request->access_types)) {
                        $accessCredential->access_web = null;
                        $accessCredential->username_web = null;
                        $accessCredential->password_web = null;
                    }
                    if (!in_array('ojs', $request->access_types)) {
                        $accessCredential->akses_ojs = null;
                        $accessCredential->username_ojs = null;
                        $accessCredential->password_ojs = null;
                    }
                    if (!in_array('cpanel', $request->access_types)) {
                        $accessCredential->akses_cpanel = null;
                        $accessCredential->username_cpanel = null;
                        $accessCredential->password_cpanel = null;
                    }
                    if (!in_array('webmail', $request->access_types)) {
                        $accessCredential->akses_webmail = null;
                        $accessCredential->username_webmail = null;
                        $accessCredential->password_webmail = null;
                    }

                    foreach ($request->access_types as $accessType) {
                        switch ($accessType) {
                            case 'website':
                                $accessCredential->web = true;
                                $accessCredential->access_web = $request->input('access_credentials.website.url');
                                $accessCredential->username_web = $request->input('access_credentials.website.username');
                                $accessCredential->password_web = $request->input('access_credentials.website.password');
                                break;
                                
                            case 'ojs':
                                $accessCredential->ojs = true;
                                $accessCredential->akses_ojs = $request->input('access_credentials.ojs.url');
                                $accessCredential->username_ojs = $request->input('access_credentials.ojs.username');
                                $accessCredential->password_ojs = $request->input('access_credentials.ojs.password');
                                break;
                                
                            case 'cpanel':
                                $accessCredential->cpanel = true;
                                $accessCredential->akses_cpanel = $request->input('access_credentials.cpanel.url');
                                $accessCredential->username_cpanel = $request->input('access_credentials.cpanel.username');
                                $accessCredential->password_cpanel = $request->input('access_credentials.cpanel.password');
                                break;
                                
                            case 'webmail':
                                $accessCredential->webmail = true;
                                $accessCredential->akses_webmail = $request->input('access_credentials.webmail.url');
                                $accessCredential->username_webmail = $request->input('access_credentials.webmail.username');
                                $accessCredential->password_webmail = $request->input('access_credentials.webmail.password');
                                break;
                        }
                    }

                    $accessCredential->save();
                } else {
                    AccessCredentialModel::where('customer_id', $customer->id)->delete();
                }
            }

            $role = auth()->user()->getRoleNames()->first();

            if ($role === 'admin') {
                return redirect()->route('admin.work-orders.index')
                    ->with('success', 'Work Order berhasil diperbarui');
            } elseif ($role === 'production') {
                return redirect()->route('production.work-orders.index')
                    ->with('success', 'Work Order berhasil diperbarui');
            } elseif ($role === 'sales') {
                return redirect()->route('sales.work-orders.index')
                    ->with('success', 'Work Order berhasil diperbarui');
            } elseif ($role === 'asservice') {
                return redirect()->route('asservice.work-orders.index')
                    ->with('success', 'Work Order berhasil diperbarui');
            } else {
                // Fallback jika role tidak dikenali
                return redirect()->route('asservice.work-orders.index')
                    ->with('success', 'Work Order berhasil diperbarui');
            }
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


    public function updateStatus(Request $request, WorkOrderModel $workOrder)
{
    $validated = $request->validate([
        'status' => [
            'required',
            \Illuminate\Validation\Rule::in(['validate', 'queue', 'pending', 'progress', 'revision', 'migration', 'finish']),
        ],
    ]);

    $newStatus = $validated['status'];
    
    // Status names for better messages
    $statusNames = [
        'validate' => 'Validate',
        'queue' => 'Queue',
        'pending' => 'Pending', 
        'progress' => 'In Progress',
        'revision' => 'Revision',
        'migration' => 'Migration',
        'finish' => 'Finished'
    ];

    // Do nothing if the status has not changed
    if ($workOrder->status === $newStatus) {
        return response()->json([
            'success' => true, 
            'message' => 'Status is already ' . ($statusNames[$newStatus] ?? $newStatus)
        ]);
    }

    try {
        // Jika berpindah ke status queue, pastikan production_id ada
        if ($newStatus === 'queue' && !$workOrder->production_id) {
            return response()->json([
                'success' => false, 
                'message' => 'Cannot move to queue without production assignment'
            ], 422);
        }

        // Set the new status
        $workOrder->status = $newStatus;

        // Jika status diupdate ke 'finish', set date_completed ke waktu sekarang
        if ($newStatus === 'finish') {
            $workOrder->date_completed = now();
        }

        // Jika status diupdate ke 'revision', set date_revision ke waktu sekarang
        if ($newStatus === 'revision') {
            $workOrder->date_revision = now();
        }

        // Jika status diupdate ke 'migration', set date_migration ke waktu sekarang
        if ($newStatus === 'migration') {
            $workOrder->date_migration = now();
        }

        $workOrder->save();

        return response()->json([
            'success' => true, 
            'message' => 'Status successfully updated to ' . ($statusNames[$newStatus] ?? $newStatus),
            'queue_info' => $newStatus === 'queue' ? [
                'production_id' => $workOrder->production_id,
                'antrian_ke' => $workOrder->antrian_ke,
                'total_in_queue' => WorkOrderModel::getQueueCount($workOrder->production_id)
            ] : null
        ]);

    } catch (\Exception $e) {
        // Log the exception for debugging
        \Illuminate\Support\Facades\Log::error('Failed to update status: ' . $e->getMessage());
        
        return response()->json([
            'success' => false, 
            'message' => 'Failed to update status: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Mendapatkan daftar antrian berdasarkan production_id
 */
public function getQueueByProduction(Request $request, $productionId = null)
{
    $productionId = $productionId ?? $request->input('production_id');
    
    if (!$productionId) {
        return response()->json([
            'success' => false,
            'message' => 'Production ID is required'
        ], 422);
    }

    try {
        $queueList = WorkOrderModel::getQueueList($productionId);
        $totalQueue = WorkOrderModel::getQueueCount($productionId);

        return response()->json([
            'success' => true,
            'data' => [
                'production_id' => $productionId,
                'total_queue' => $totalQueue,
                'queue_list' => $queueList
            ]
        ]);

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Failed to get queue: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to get queue: ' . $e->getMessage()
        ], 500);
    }
}
}