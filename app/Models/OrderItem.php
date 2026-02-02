<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_price_option_id', // Added
        'specifications',
        'quantity',
        'size',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'specifications' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productPriceOption(): BelongsTo // Added
    {
        return $this->belongsTo(ProductPriceOption::class);
    }

    public function designFiles(): HasMany
    {
        return $this->hasMany(DesignFile::class);
    }
}