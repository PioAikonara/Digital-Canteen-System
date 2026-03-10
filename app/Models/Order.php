<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'menu_id',
        'quantity',
        'total_price',
        'pickup_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'preparing' => 'Sedang Disiapkan',
            'ready' => 'Siap Diambil',
            'completed' => 'Selesai',
            default => 'Unknown',
        };
    }

    public function getPickupTimeLabelAttribute(): string
    {
        return match($this->pickup_time) {
            'istirahat_1' => 'Istirahat 1',
            'istirahat_2' => 'Istirahat 2',
            default => 'Unknown',
        };
    }
}
