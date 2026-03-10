<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menus = Menu::where('admin_id', auth()->id())
                     ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
                     ->latest()->paginate(10)->withQueryString();
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.menus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:makanan,minuman',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:0',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('menus', 'public');
        }

        // Auto-set is_available based on stock
        $validated['is_available'] = $validated['stock'] > 0 && $request->has('is_available');
        $validated['admin_id'] = auth()->id();

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return view('admin.menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:makanan,minuman',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:0',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($menu->photo) {
                Storage::disk('public')->delete($menu->photo);
            }
            $validated['photo'] = $request->file('photo')->store('menus', 'public');
        }

        // Auto-set is_available based on stock
        $validated['is_available'] = $validated['stock'] > 0 && $request->has('is_available');

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Hapus foto jika ada
        if ($menu->photo) {
            Storage::disk('public')->delete($menu->photo);
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}
