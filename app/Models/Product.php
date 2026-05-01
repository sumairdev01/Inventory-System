<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'quantity',
        'description',
        'alert_threshold',
        'barcode',
        'qr_code'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function transactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
}