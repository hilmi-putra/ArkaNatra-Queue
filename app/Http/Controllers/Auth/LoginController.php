<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string', // Ubah dari email ke string
            'password' => 'required',
        ]);

        // Cek apakah input adalah email atau username
        $field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        // Siapkan credentials dengan field yang sesuai
        $loginCredentials = [
            $field => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($loginCredentials)) {
            $request->session()->regenerate();

            // Log login activity
            ActivityLogger::logLogin(Auth::id());

            // SESSION SUCCESS
            return redirect()
                ->intended(route('dashboard.index'))
                ->with('success', 'Login berhasil! Selamat datang.');
        }

        // SESSION ERROR
        return back()
            ->with('error', 'Email/username atau password salah.')
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $userId = Auth::id();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Log logout activity
        if ($userId) {
            ActivityLogger::logLogout($userId);
        }

        // SESSION SUCCESS LOGOUT
        return redirect('/')
            ->with('success', 'Anda berhasil logout.');
    }
}
