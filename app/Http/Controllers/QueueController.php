<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\WorkOrderModel;
use App\Models\AccessCredentialModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QueueController extends Controller
{
    // Konstanta untuk pola regex yang disesuaikan
    const REF_ID_PATTERN = '/^WO-\d{8}-[A-Za-z0-9]{6}$/';
    const TOKEN_PATTERN = '/^[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?~]{8,50}$/';
    const MAX_REF_ID_LENGTH = 20; // WO-20251124-O7CGiK = 19 karakter
    const MAX_TOKEN_LENGTH = 50;

    /**
     * Display the queue page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('queue.index');
    }

    /**
     * Validasi dan sanitasi input ref_id berdasarkan format WO-YYYYMMDD-XXXXXX
     */
    private function validateRefId($refId)
    {
        // Sanitasi dasar - hapus whitespace berlebih
        $refId = trim($refId);
        
        // Validasi panjang
        if (strlen($refId) > self::MAX_REF_ID_LENGTH) {
            return false;
        }
        
        // Validasi format dengan regex - WO-20251124-O7CGiK
        if (!preg_match(self::REF_ID_PATTERN, $refId)) {
            return false;
        }
        
        // Validasi bagian tanggal (YYYYMMDD)
        $parts = explode('-', $refId);
        if (count($parts) !== 3) {
            return false;
        }
        
        $datePart = $parts[1];
        if (strlen($datePart) !== 8) {
            return false;
        }
        
        // Validasi apakah bagian tanggal valid
        $year = substr($datePart, 0, 4);
        $month = substr($datePart, 4, 2);
        $day = substr($datePart, 6, 2);
        
        if (!checkdate((int)$month, (int)$day, (int)$year)) {
            return false;
        }
        
        // Validasi bagian kode (6 karakter alfanumerik)
        $codePart = $parts[2];
        if (strlen($codePart) !== 6 || !ctype_alnum($codePart)) {
            return false;
        }
        
        return $refId;
    }

    /**
     * Validasi dan sanitasi input token dengan karakter kompleks
     */
    private function validateToken($token)
    {
        // Sanitasi dasar
        $token = trim($token);
        
        // Validasi panjang
        if (strlen($token) > self::MAX_TOKEN_LENGTH || strlen($token) < 8) {
            return false;
        }
        
        // Validasi format dengan regex - mendukung karakter khusus
        if (!preg_match(self::TOKEN_PATTERN, $token)) {
            return false;
        }
        
        // Validasi dengan filter_var untuk string yang aman
        if (!filter_var($token, FILTER_VALIDATE_REGEXP, [
            'options' => ['regexp' => self::TOKEN_PATTERN]
        ])) {
            return false;
        }
        
        // Additional security: cek karakter berbahaya SQL
        $sqlDangerousChars = ["'", '"', ';', '--', '/*', '*/', 'xp_', 'sp_'];
        foreach ($sqlDangerousChars as $char) {
            if (strpos($token, $char) !== false) {
                return false;
            }
        }
        
        return $token;
    }

    /**
     * Check the status of a work order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function checkStatus(Request $request)
    {
        // Validasi dan sanitasi input sebelum validasi Laravel
        $sanitizedRefId = $this->validateRefId($request->ref_id);
        $sanitizedToken = $this->validateToken($request->token);

        if (!$sanitizedRefId || !$sanitizedToken) {
            return redirect()->route('queue.index')
                ->with('error', 'Format Reference ID atau Token tidak valid.')
                ->withInput();
        }

        // Ganti input request dengan yang sudah disanitasi
        $request->merge([
            'ref_id' => $sanitizedRefId,
            'token' => $sanitizedToken
        ]);

        $validator = Validator::make($request->all(), [
            'ref_id' => [
                'required',
                'string',
                'max:' . self::MAX_REF_ID_LENGTH,
                function ($attribute, $value, $fail) {
                    if (!preg_match(self::REF_ID_PATTERN, $value)) {
                        $fail('Format Reference ID harus: WO-YYYYMMDD-XXXXXX (contoh: WO-20251124-O7CGiK)');
                    }
                }
            ],
            'token' => [
                'required', 
                'string',
                'max:' . self::MAX_TOKEN_LENGTH,
                'min:8',
                function ($attribute, $value, $fail) {
                    if (!preg_match(self::TOKEN_PATTERN, $value)) {
                        $fail('Token mengandung karakter yang tidak diizinkan.');
                    }
                    
                    // Additional security check
                    $sqlDangerousChars = ["'", '"', ';', '--', '/*', '*/'];
                    foreach ($sqlDangerousChars as $char) {
                        if (strpos($value, $char) !== false) {
                            $fail('Token mengandung karakter yang berbahaya.');
                        }
                    }
                }
            ],
        ], [
            'ref_id.required' => 'Reference ID wajib diisi.',
            'ref_id.max' => 'Reference ID maksimal 20 karakter.',
            'token.required' => 'Token wajib diisi.',
            'token.min' => 'Token harus memiliki panjang minimal 8 karakter.',
            'token.max' => 'Token maksimal 50 karakter.'
        ]);

        if ($validator->fails()) {
            return redirect()->route('queue.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Query dengan parameter binding (sudah aman dengan Eloquent)
        $customer = CustomerModel::where('token', $request->token)->first();

        if (!$customer) {
            return redirect()->route('queue.index')
                ->with('error', 'Invalid token or Reference ID.')
                ->withInput();
        }

        // Query dengan parameter binding
        $workOrder = WorkOrderModel::with(['customer', 'workType', 'accessCredential'])
            ->where('ref_id', $request->ref_id)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$workOrder) {
            return redirect()->route('queue.index')
                ->with('error', 'Invalid token or Reference ID.')
                ->withInput();
        }

        // Filter credentials - hanya tampilkan jika akses sudah dikirim
        if ($workOrder->send_access && $workOrder->accessCredential) {
            $accessCredential = $workOrder->accessCredential;
            $filteredCredential = [
                'web' => $accessCredential->web,
                'ojs' => $accessCredential->ojs,
                'cpanel' => $accessCredential->cpanel,
                'webmail' => $accessCredential->webmail,
                'access_web' => $accessCredential->web ? $accessCredential->access_web : null,
                'username_web' => $accessCredential->web ? $accessCredential->username_web : null,
                'password_web' => $accessCredential->web ? $accessCredential->password_web : null,
                'akses_ojs' => $accessCredential->ojs ? $accessCredential->akses_ojs : null,
                'username_ojs' => $accessCredential->ojs ? $accessCredential->username_ojs : null,
                'password_ojs' => $accessCredential->ojs ? $accessCredential->password_ojs : null,
                'akses_cpanel' => $accessCredential->cpanel ? $accessCredential->akses_cpanel : null,
                'username_cpanel' => $accessCredential->cpanel ? $accessCredential->username_cpanel : null,
                'password_cpanel' => $accessCredential->cpanel ? $accessCredential->password_cpanel : null,
                'akses_webmail' => $accessCredential->webmail ? $accessCredential->akses_webmail : null,
                'username_webmail' => $accessCredential->webmail ? $accessCredential->username_webmail : null,
                'password_webmail' => $accessCredential->webmail ? $accessCredential->password_webmail : null,
            ];
            
            $workOrder->filteredAccessCredential = (object) $filteredCredential;
        }

        return view('queue.index', compact('workOrder'));
    }

    /**
     * Provide API data for the queue page.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQueueData()
    {
        // Recalculate queue estimations first to ensure data is fresh.
        WorkOrderModel::recalculateQueueEstimations();

        // Fetch only work orders with 'queue' status for the queue list.
        $workOrders = WorkOrderModel::with(['customer', 'division', 'workType'])
            ->where('status', 'queue')
            ->orderBy('antrian_ke', 'asc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'ref_id' => $order->ref_id,
                    'antrian_ke' => $order->antrian_ke,
                    'customer_name' => $order->customer->name ?? '-',
                    'work_type_name' => $order->workType->work_type ?? '-',
                    'quantity' => $order->quantity,
                    'fast_track' => $order->fast_track,
                    'status' => $order->status,
                    'estimasi_date' => $order->estimasi_date ? \Carbon\Carbon::parse($order->estimasi_date)->format('Y-m-d') : '-',
                    'date_queue' => $order->date_queue ? \Carbon\Carbon::parse($order->date_queue)->format('Y-m-d') : '-',
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $workOrders,
            'message' => 'Queue data retrieved successfully.'
        ]);
    }

    /**
     * Helper method untuk generate ref_id (untuk reference)
     */
    public static function generateRefId()
    {
        $datePart = date('Ymd');
        $randomPart = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
        return "WO-{$datePart}-{$randomPart}";
    }

    /**
     * Helper method untuk generate token (untuk reference)
     */
    public static function generateToken()
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{};:\|,.<>?~';
        $length = rand(20, 30);
        $token = '';
        
        for ($i = 0; $i < $length; $i++) {
            $token .= $chars[rand(0, strlen($chars) - 1)];
        }
        
        return $token;
    }
}