<?php

namespace App\Http\Controllers;

use App\Models\AccessCredentialModel;
use App\Models\WorkOrderModel;
use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccessCredentialController extends Controller
{
    public function index()
    {
        $data = AccessCredentialModel::with('customer')->get();

        return view('access-credentials.index', compact('data'));
    }

    public function create()
    {
        $customers = CustomerModel::all();
        return view('access-credentials.form', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:table_customer,id',
            'access_web' => 'nullable|string|max:255',
            'username_web' => 'nullable|string|max:255',
            'password_web' => 'nullable|string|max:255',
            'akses_ojs' => 'nullable|string|max:255',
            'username_ojs' => 'nullable|string|max:255',
            'password_ojs' => 'nullable|string|max:255',
            'akses_cpanel' => 'nullable|string|max:255',
            'username_cpanel' => 'nullable|string|max:255',
            'password_cpanel' => 'nullable|string|max:255',
            'akses_webmail' => 'nullable|string|max:255',
            'username_webmail' => 'nullable|string|max:255',
            'password_webmail' => 'nullable|string|max:255',
            'server' => 'nullable|string|in:rumahweb,webhostingallinone,niaga,nohosting',
            'note' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
            'expiration_date' => 'nullable|date'
        ]);

        AccessCredentialModel::create($request->all());

        return $this->redirectByRole('Access Credential berhasil dibuat.');
    }

    public function edit(AccessCredentialModel $accessCredential)
    {
        $customers = CustomerModel::all();
        return view('access-credentials.form', compact('accessCredential', 'customers'));
    }

    public function update(Request $request, AccessCredentialModel $accessCredential)
    {
        $request->validate([
            'customer_id' => 'required|exists:table_customer,id',
            'access_web' => 'nullable|string|max:255',
            'username_web' => 'nullable|string|max:255',
            'password_web' => 'nullable|string|max:255',
            'akses_ojs' => 'nullable|string|max:255',
            'username_ojs' => 'nullable|string|max:255',
            'password_ojs' => 'nullable|string|max:255',
            'akses_cpanel' => 'nullable|string|max:255',
            'username_cpanel' => 'nullable|string|max:255',
            'password_cpanel' => 'nullable|string|max:255',
            'akses_webmail' => 'nullable|string|max:255',
            'username_webmail' => 'nullable|string|max:255',
            'password_webmail' => 'nullable|string|max:255',
            'server' => 'nullable|string|in:rumahweb,webhostingallinone,niaga,nohosting',
            'note' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
            'expiration_date' => 'nullable|date'
        ]);

        $accessCredential->update($request->all());

         return $this->redirectByRole('Access Credential berhasil diupdate.');
    }

    public function destroy(AccessCredentialModel $accessCredential)
    {
        $accessCredential->delete();

        return $this->redirectByRole('Access Credential berhasil dihapus.');
    }

    /**
     * Update send access credentials
     */
    public function updateSendAccess(Request $request, $workOrderId)
{
    $validator = Validator::make($request->all(), [
        'password' => 'required|string',
        'credentials' => 'required|array|min:1',
        'credentials.*' => 'in:web,ojs,cpanel,webmail'
    ], [
        'password.required' => 'Password wajib diisi.',
        'credentials.required' => 'Pilih minimal satu jenis credential.',
        'credentials.min' => 'Pilih minimal satu jenis credential.',
        'credentials.*.in' => 'Jenis credential tidak valid.'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()
        ], 422);
    }

    // Verify user password
    if (!Hash::check($request->password, Auth::user()->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Password salah!'
        ], 401);
    }

    try {
        $workOrder = WorkOrderModel::findOrFail($workOrderId);

        // Check if access has already been sent for this work order
        if ($workOrder->send_access) {
            return response()->json([
                'success' => false,
                'message' => 'Akses untuk work order ini sudah pernah dikirim.'
            ], 409); // 409 Conflict
        }

        $accessCredential = AccessCredentialModel::where('customer_id', $workOrder->customer_id)->first();

        if (!$accessCredential) {
            return response()->json([
                'success' => false,
                'message' => 'Data credentials tidak ditemukan untuk customer ini.'
            ], 404);
        }

        // Update selected credentials flags on the credential model
        $updateData = [
            'web' => in_array('web', $request->credentials),
            'ojs' => in_array('ojs', $request->credentials),
            'cpanel' => in_array('cpanel', $request->credentials),
            'webmail' => in_array('webmail', $request->credentials),
        ];

        $accessCredential->update($updateData);

        // Mark this specific work order as access sent
        $workOrder->send_access = true;
        $workOrder->save();

        // Log the activity
        \Log::info('Access credentials sent', [
            'work_order_id' => $workOrderId,
            'user_id' => Auth::id(),
            'credentials' => $request->credentials
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Access credentials berhasil dikirim dan diaktifkan!'
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Work order tidak ditemukan.'
        ], 404);
    } catch (\Exception $e) {
        \Log::error('Failed to send access credentials: ' . $e->getMessage(), [
            'work_order_id' => $workOrderId,
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
        ], 500);
    }
}
    /**
     * Get email data for Gmail compose
     */
    public function getEmailData(Request $request, $workOrderId)
    {
        // If it's a POST request, verify the password first
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (!Hash::check($request->password, Auth::user()->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password salah!'
                ], 401);
            }
        }

        try {
            $workOrder = WorkOrderModel::with(['customer', 'accessCredential'])->findOrFail($workOrderId);
            $customer = $workOrder->customer;
            $accessCredential = $workOrder->accessCredential;

            if (!$accessCredential) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data credentials tidak ditemukan'
                ], 404);
            }
            
            // Check if access has even been sent/defined yet
            if (!$workOrder->send_access) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kredensial akses belum dikirim. Kirim akses terlebih dahulu sebelum mengirim email.'
                ], 412); // Precondition Failed
            }

            // Generate dynamic subject based on what credentials are enabled
            $subject = $this->generateEmailSubject($accessCredential);

            $emailData = [
                'to' => $customer->email,
                'subject' => $subject,
                'body' => $this->generateEmailBody($customer, $accessCredential)
            ];

            return response()->json([
                'success' => true,
                'data' => $emailData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate dynamic email subject based on enabled credentials
     */
    private function generateEmailSubject($accessCredential)
    {
        $enabledServices = [];
        
        if ($accessCredential->cpanel) {
            $enabledServices[] = 'Cpanel';
        }
        if ($accessCredential->ojs) {
            $enabledServices[] = 'OJS';
        }
        if ($accessCredential->webmail) {
            $enabledServices[] = 'Email';
        }
        if ($accessCredential->web) {
            $enabledServices[] = 'Website';
        }

        if (empty($enabledServices)) {
            return 'Penyerahan Akses dan Tutorial OJS';
        }

        $servicesString = implode(', ', $enabledServices);
        return "Penyerahan Akses {$servicesString} dan Tutorial OJS";
    }

    /**
     * Generate email body template sesuai format yang diinginkan
     */
    private function generateEmailBody($customer, $accessCredential)
    {
        $enabledServices = [];
        
        // Cek apakah credential memiliki nilai yang lengkap
        if (!empty($accessCredential->cpanel) && !empty($accessCredential->akses_cpanel) && !empty($accessCredential->username_cpanel) && !empty($accessCredential->password_cpanel)) {
            $enabledServices[] = 'cPanel';
        }
        if (!empty($accessCredential->ojs) && !empty($accessCredential->akses_ojs) && !empty($accessCredential->username_ojs) && !empty($accessCredential->password_ojs)) {
            $enabledServices[] = 'OJS';
        }
        if (!empty($accessCredential->webmail) && !empty($accessCredential->akses_webmail) && !empty($accessCredential->username_webmail) && !empty($accessCredential->password_webmail)) {
            $enabledServices[] = 'Email';
        }
        if (!empty($accessCredential->web) && !empty($accessCredential->access_web) && !empty($accessCredential->username_web) && !empty($accessCredential->password_web)) {
            $enabledServices[] = 'Website';
        }

        if (empty($enabledServices)) {
            return 'Penyerahan Akses dan Tutorial OJS';
        }

        $servicesString = implode(', ', $enabledServices);

        $body = "Yth. Bapak / Ibu {$customer->name},\n\n";
        $body .= "Kami berharap Anda dalam keadaan sehat dan baik. Dengan ini, kami ingin memberikan Anda akses untuk akun {$servicesString}. Berikut adalah detail akun yang dapat Anda gunakan:\n\n";

        // OJS Section - hanya ditampilkan jika semua field OJS terisi
        if (!empty($accessCredential->ojs) && !empty($accessCredential->akses_ojs) && !empty($accessCredential->username_ojs) && !empty($accessCredential->password_ojs)) {
            $body .= "OJS :\n\n";
            $body .= "- Link Akses = {$accessCredential->akses_ojs}\n";
            $body .= "- Username = {$accessCredential->username_ojs}\n";
            $body .= "- Password = {$accessCredential->password_ojs}\n\n";
        }

        // Email Section - hanya ditampilkan jika semua field Email terisi
        if (!empty($accessCredential->webmail) && !empty($accessCredential->akses_webmail) && !empty($accessCredential->username_webmail) && !empty($accessCredential->password_webmail)) {
            $body .= "Email :\n\n";
            $body .= "- Link Akses = {$accessCredential->akses_webmail}\n";
            $body .= "- Email = {$accessCredential->username_webmail}\n";
            $body .= "- Password = {$accessCredential->password_webmail} (Note : Password Email tidak boleh di ubah)\n\n";
        }

        // cPanel Section - hanya ditampilkan jika semua field cPanel terisi
        if (!empty($accessCredential->cpanel) && !empty($accessCredential->akses_cpanel) && !empty($accessCredential->username_cpanel) && !empty($accessCredential->password_cpanel)) {
            $body .= "cPanel :\n\n";
            $body .= "- Link Akses = {$accessCredential->akses_cpanel}\n";
            $body .= "- Username = {$accessCredential->username_cpanel}\n";
            $body .= "- Password = {$accessCredential->password_cpanel}\n\n";
        }

        // Website Section - hanya ditampilkan jika semua field Website terisi
        if (!empty($accessCredential->web) && !empty($accessCredential->access_web) && !empty($accessCredential->username_web) && !empty($accessCredential->password_web)) {
            $body .= "Website :\n\n";
            $body .= "- Link Akses = {$accessCredential->access_web}\n";
            $body .= "- Username = {$accessCredential->username_web}\n";
            $body .= "- Password = {$accessCredential->password_web}\n\n";
        }

        $body .= "Untuk memudahkan Anda dalam menggunakan OJS, kami telah menyediakan panduan lengkap. Silakan mengikuti langkah-langkah yang dijelaskan dalam tutorial pada tautan berikut:\n\n";

        // Tutorial Links
        $body .= "- Tutorial OJS = https://drive.google.com/file/d/1_rUWjnaULedcE9JRaaD_VzSZfWEb9gY/view?usp=sharing\n";
        $body .= "- Tutorial OJS Youtube = https://www.youtube.com/watch?v=kVOAxUK9nkc&t\n";
        $body .= "- Panduan OJS = https://drive.google.com/file/d/1xZAIIGiOZOUTLw-U7F0RJknVMPFQ6VJO/view?usp=sharing\n";
        $body .= "- Zoom Record = https://drive.google.com/file/d/1e4dpROoTv9r5zn9-jxKq15eWxeVMG_09/view?usp=sharing\n\n";

        $body .= "Kami harap panduan ini dapat membantu Anda. Jika ada pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami.\n\n";
        $body .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
        $body .= "Hormat kami,\n";
        $body .= "Tim Layanan Kami";

        return $body;
    }

    private function redirectByRole($message)
    {
        $role = auth()->user()->role; // Sesuaikan dengan cara Anda mendapatkan role
        
        if ($role === 'admin') {
            return redirect()->route('admin.access-credentials.index')
                ->with('success', $message);
        } elseif ($role === 'production') {
            return redirect()->route('production.access-credentials.index')
                ->with('success', $message);
        } elseif ($role === 'sales') {
            return redirect()->route('sales.access-credentials.index')
                ->with('success', $message);
        } elseif ($role === 'asservice') {
            return redirect()->route('asservice.access-credentials.index')
                ->with('success', $message);
        } else {
            // Fallback jika role tidak dikenali
            return redirect()->route('asservice.access-credentials.index')
                ->with('success', $message);
        }
    }
}