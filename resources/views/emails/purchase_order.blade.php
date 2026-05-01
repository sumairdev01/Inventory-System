<!DOCTYPE html>
<html>
<head>
    <title>New Purchase Order</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <div style="background-color: #007bff; padding: 20px; text-align: center; color: white;">
        <h2 style="margin: 0;">Purchase Order</h2>
    </div>
    <div style="padding: 20px; background-color: #ffffff; color: #333333;">
        <p>Dear {{ $purchase->supplier->name }},</p>
        <p>We are placing a new purchase order (<strong>{{ $purchase->invoice_number }}</strong>) with your company. Please find the details below:</p>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 10px; border: 1px solid #dddddd; text-align: left;">Product</th>
                    <th style="padding: 10px; border: 1px solid #dddddd; text-align: center;">Quantity</th>
                    <th style="padding: 10px; border: 1px solid #dddddd; text-align: right;">Unit Price</th>
                    <th style="padding: 10px; border: 1px solid #dddddd; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase->items as $item)
                <tr>
                    <td style="padding: 10px; border: 1px solid #dddddd;">{{ $item->product->name }}</td>
                    <td style="padding: 10px; border: 1px solid #dddddd; text-align: center;">{{ $item->quantity }}</td>
                    <td style="padding: 10px; border: 1px solid #dddddd; text-align: right;">${{ number_format($item->cost_price, 2) }}</td>
                    <td style="padding: 10px; border: 1px solid #dddddd; text-align: right;">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="padding: 10px; border: 1px solid #dddddd; text-align: right;">Total Amount:</th>
                    <th style="padding: 10px; border: 1px solid #dddddd; text-align: right;">${{ number_format($purchase->total_amount, 2) }}</th>
                </tr>
            </tfoot>
        </table>
        <p style="margin-top: 20px;">Please confirm the receipt of this email and proceed with the order as soon as possible.</p>
        <p style="margin-top: 30px; font-size: 12px; color: #777777;">
            Best Regards,<br>
            {{ config('app.name') }} Team
        </p>
    </div>
</body>
</html>