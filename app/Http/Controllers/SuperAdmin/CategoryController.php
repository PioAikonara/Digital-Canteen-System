<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = MenuCategory::orderBy('name')->get()->map(function ($cat) {
            $cat->menu_count = Menu::where('category', $cat->name)->count();
            return $cat;
        });

        return view('superadmin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:100', 'unique:menu_categories,name'],
            'icon'  => ['nullable', 'string', 'max:80'],
            'color' => ['nullable', 'string', 'max:20'],
        ]);

        MenuCategory::create([
            'name'  => $request->name,
            'icon'  => $request->input('icon', 'solar:dish-bold'),
            'color' => $request->input('color', '#7886C7'),
        ]);

        return redirect()->route('superadmin.categories.index')
            ->with('success', 'Kategori "' . $request->name . '" berhasil ditambahkan!');
    }

    public function update(Request $request, MenuCategory $category)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:100', 'unique:menu_categories,name,' . $category->id],
            'icon'  => ['nullable', 'string', 'max:80'],
            'color' => ['nullable', 'string', 'max:20'],
        ]);

        $category->update([
            'name'  => $request->name,
            'icon'  => $request->input('icon', $category->icon),
            'color' => $request->input('color', $category->color),
        ]);

        return redirect()->route('superadmin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(MenuCategory $category)
    {
        $category->delete();

        return redirect()->route('superadmin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
