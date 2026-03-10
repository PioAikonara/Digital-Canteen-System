<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $users  = User::where('role', 'customer')
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%"))
            ->withCount('orders')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('superadmin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('superadmin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
            'balance'  => 0,
            'is_active' => true,
        ]);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Akun siswa berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        abort_if($user->role !== 'customer', 404);
        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->role !== 'customer', 404);

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        abort_if($user->role !== 'customer', 404);
        $user->delete();

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Akun siswa berhasil dihapus!');
    }
}
