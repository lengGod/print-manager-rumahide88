<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExternalPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'source_shop',
        'price',
        'purchase_date',
        'payment_status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'purchase_date' => 'datetime',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
