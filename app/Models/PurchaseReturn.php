<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PurchaseReturn extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'refund_amount',
        'reason',
        'return_date',
    ];
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
