<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $fillable = [
        'admin_id',
        'name',
        'category',
        'price',
        'description',
        'photo',
        'is_available',
        'stock',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'stock' => 'integer',
    ];

    public function isSoldOut(): bool
    {
        return $this->stock <= 0;
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'Sold Out';
        } elseif ($this->stock <= 5) {
            return 'Stok Terbatas';
        }
        return 'Tersedia';
    }
}
