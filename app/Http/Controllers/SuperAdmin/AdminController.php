<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $admins = User::where('role', 'admin')
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%"))
            ->withCount('menus')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        // Attach revenue per admin
        $admins->getCollection()->transform(function ($admin) {
            $admin->total_revenue = Order::whereHas('menu', fn($q) => $q->where('admin_id', $admin->id))
                ->where('status', 'completed')->sum('total_price');
            $admin->total_orders  = Order::whereHas('menu', fn($q) => $q->where('admin_id', $admin->id))->count();
            return $admin;
        });

        return view('superadmin.admins.index', compact('admins', 'search'));
    }

    public function create()
    {
        return view('superadmin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Akun petugas kantin berhasil ditambahkan!');
    }

    public function edit(User $admin)
    {
        abort_if($admin->role !== 'admin', 404);
        return view('superadmin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        abort_if($admin->role !== 'admin', 404);

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $admin->id],
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

        $admin->update($data);

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Data petugas kantin berhasil diperbarui!');
    }

    public function destroy(User $admin)
    {
        abort_if($admin->role !== 'admin', 404);
        abort_if($admin->id === auth()->id(), 403, 'Tidak bisa menghapus akun sendiri.');
        $admin->delete();

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Akun petugas kantin berhasil dihapus!');
    }
}
