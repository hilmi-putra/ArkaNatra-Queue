<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        $data = CustomerModel::with(['workOrders', 'accessCredentials'])->paginate(10);

        return view('customers.index', compact('data'));
    }

    public function create()
    {
        // Generate token otomatis
        $autoToken = $this->generateRandomToken(12);
        return view('customers.form', compact('autoToken'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255'
        ]);

        // Generate token otomatis jika tidak diisi
        $token = $request->token ?: $this->generateRandomToken(12);

        // Validasi unique token
        if (CustomerModel::where('token', $token)->exists()) {
            // Jika token sudah ada, generate yang baru
            $token = $this->generateRandomToken(12);
        }

        CustomerModel::create([
            'token' => $token,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        return $this->redirectByRole('Customer berhasil ditambahkan.');
    }

    public function edit(CustomerModel $customer)
    {
        return view('customers.form', compact('customer'));
    }

    public function update(Request $request, CustomerModel $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255'
        ]);

        $customer->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        return $this->redirectByRole('Customer berhasil diupdate.');
    }

    public function destroy(CustomerModel $customer)
    {
        $customer->delete();

        return $this->redirectByRole('Customer berhasil dihapus.');
    }

    /**
     * Generate random token dengan kombinasi aman
     * 
     * @param int $length
     * @return string
     */
    private function generateRandomToken($length = 12)
    {
        // Karakter yang akan digunakan (tanpa karakter khusus yang bermasalah)
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $token = '';
        $max = strlen($characters) - 1;
        
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[random_int(0, $max)];
        }
        
        return $token;
    }

    /**
     * Redirect berdasarkan role user
     * 
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectByRole($message)
    {
        $role = auth()->user()->role; // Sesuaikan dengan cara Anda mendapatkan role
        
        if ($role === 'admin') {
            return redirect()->route('admin.customers.index')
                ->with('success', $message);
        } elseif ($role === 'production') {
            return redirect()->route('production.customers.index')
                ->with('success', $message);
        } elseif ($role === 'sales') {
            return redirect()->route('sales.customers.index')
                ->with('success', $message);
        } elseif ($role === 'asservice') {
            return redirect()->route('asservice.customers.index')
                ->with('success', $message);
        } else {
            // Fallback jika role tidak dikenali
            return redirect()->route('asservice.customers.index')
                ->with('success', $message);
        }
    }

    /**
     * API untuk generate token baru (optional)
     */
    public function generateToken(Request $request)
    {
        $length = $request->input('length', 12);
        $token = $this->generateRandomToken($length);

        return response()->json([
            'token' => $token,
            'length' => $length
        ]);
    }
}