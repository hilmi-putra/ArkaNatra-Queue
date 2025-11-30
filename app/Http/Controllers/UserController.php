<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\DivisionModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = User::with(['division', 'roles'])->paginate(10);
        return view('users.index', compact('data'));
    }

    public function create()
    {
        $roles = Role::all();
        $divisions = DivisionModel::all();
        return view('users.form', compact('roles', 'divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|exists:roles,name',
            'id_divisi' => 'nullable|exists:table_division,id'
        ]);

        // Generate password otomatis
        $password = 'password123';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'id_divisi' => $request->id_divisi
            // Hapus 'role' dari sini
        ]);

        // Assign role menggunakan Spatie
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat. Password default: ' . $password);
    }

    public function show(User $user)
    {
        $user->load(['division', 'workOrders', 'roles']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $divisions = DivisionModel::all();
        
        // Get the first role name for pre-selection
        $userRole = $user->roles->first()->name ?? '';
        
        return view('users.form', compact('user', 'roles', 'divisions', 'userRole'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|exists:roles,name',
            'id_divisi' => 'nullable|exists:table_division,id'
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'id_divisi' => $request->id_divisi
            // Hapus 'role' dari sini
        ];

        $user->update($updateData);

        // Sync role menggunakan Spatie
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}