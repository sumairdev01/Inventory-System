<?php

namespace App\Observers;

use App\Mail\LowStockMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ProductObserver
{
    public function creating(Product $product)
    {
        $product->barcode = $product->barcode ?? 'PRD'.rand(100000, 999999);
        $product->qr_code = $product->qr_code ?? 'PRD'.rand(100000, 999999);
    }

    public function updated(Product $product)
    {

        if ($product->isDirty('quantity') && $product->quantity <= ($product->alert_threshold ?? 5)) {
            $admin = User::first();
            if ($admin && $admin->email) {
                Mail::to($admin->email)->send(new LowStockMail($product, $admin));
            }
        }
    }
}
