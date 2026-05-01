<?php

namespace App\Observers;

use App\Models\Product;
use App\Mail\LowStockMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ProductObserver
{
    /**
     * Handle the Product "creating" event.
     * Barcode & QR code generate karega.
     */
    public function creating(Product $product)
    {
        $product->barcode = $product->barcode ?? 'PRD' . rand(100000, 999999);
        $product->qr_code = $product->qr_code ?? 'PRD' . rand(100000, 999999);
    }

    /**
     * Handle the Product "updated" event.
     * Low stock email bhejne ke liye.
     */
    public function updated(Product $product)
    {
        // Quantity change hua AND low threshold se kam hai
        if ($product->isDirty('quantity') && $product->quantity <= ($product->alert_threshold ?? 5)) {
            $admin = User::first();
            if ($admin && $admin->email) {
                Mail::to($admin->email)->send(new LowStockMail($product, $admin));
            }
        }
    }
}
