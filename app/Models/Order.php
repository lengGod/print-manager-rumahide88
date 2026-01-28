<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'order_date',
        'deadline',
        'notes',
        'status',
        'total_amount',
        'discount',
        'final_amount',
        'payment_status',
        'paid_amount',
        'created_by',
    ];

    protected $casts = [
        'order_number' => 'string',
        'status' => 'string',
        'payment_status' => 'string',
        'order_date' => 'date',
        'deadline' => 'date',
        'total_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    // HAPUS SEMUA INI - INI PENYEBAB ERROR
    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($order) {
    //         $order->final_amount = $order->total_amount - $order->discount;
    //     });
    //     static::updating(function ($order) {
    //         $order->final_amount = $order->total_amount - $order->discount;
    //     });
    // }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function productionLogs(): HasMany
    {
        return $this->hasMany(ProductionLog::class);
    }

    public function designFiles()
    {
        return $this->hasManyThrough(DesignFile::class, OrderItem::class);
    }
}
