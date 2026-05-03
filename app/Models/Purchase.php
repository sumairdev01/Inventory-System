<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Purchase extends Model
{
    protected $fillable = [
        'supplier_id',
        'invoice_number',
        'purchase_date',
        'total_amount',
        'paid_amount',
        'status',
        'notes',
    ];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
    public function returns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }
}