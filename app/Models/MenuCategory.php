<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    protected $fillable = ['name', 'icon', 'color'];

    /** Virtual: count menus that use this category name */
    public function getMenuCountAttribute(): int
    {
        return Menu::where('category', $this->name)->count();
    }
}
