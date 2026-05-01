<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'customer_id',
        'total_amount',
        'paid_amount',
        'status',
    ];

    // Relation: A sale has many items
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Relation: Sale belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}