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
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function returns()
    {
        return $this->hasMany(SaleReturn::class);
    }
}