<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SaleReturn extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'refund_amount',
        'reason',
        'return_date',
    ];
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
