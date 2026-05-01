<!DOCTYPE html>
<html>
<head>
    <title>Urgent: Low Stock Alert</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e1e4e8;">
        <div style="background-color: #dc3545; color: #ffffff; padding: 25px; text-align: center;">
            <p style="text-transform: uppercase; font-size: 14px; margin: 0; font-weight: 600;">System Notification</p>
            <h1 style="margin: 10px 0 0; font-size: 24px;">Low Stock Alert Detected</h1>
        </div>
        <div style="padding: 30px; color: #333333;">
            <p style="font-size: 16px; margin-bottom: 20px;">
                Hello <strong>{{ $admin->name ?? 'Administrator' }}</strong>,
            </p>
            <p style="line-height: 1.6; margin-bottom: 20px;">
                We have detected that the inventory for one of your products has reached its critical threshold level. To ensure continued availability for your customers, please consider contacting your <strong>Supplier</strong> and placing a <strong>Purchase Order</strong> immediately.
            </p>
            <div style="background-color: #fff8f8; border: 1px solid #f5c6cb; border-radius: 6px; padding: 20px; margin-bottom: 25px;">
                <h3 style="margin-top: 0; color: #721c24; font-size: 18px; border-bottom: 1px solid #f5c6cb; padding-bottom: 10px;">Product Summary</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Product Name:</td>
                        <td style="padding: 8px 0; font-weight: bold;">{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Identifier (ID):</td>
                        <td style="padding: 8px 0; font-weight: bold;">#{{ $product->id }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Current Stock Level:</td>
                        <td style="padding: 8px 0; color: #dc3545; font-weight: bold;">{{ $product->quantity }} units remaining</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Alert Threshold Set:</td>
                        <td style="padding: 8px 0; font-style: italic;">{{ $product->alert_threshold ?? 5 }} units</td>
                    </tr>
                </table>
            </div>
            <div style="margin-bottom: 30px;">
                <p style="font-weight: bold; margin-bottom: 15px;">Recommended Actions:</p>
                <ul style="padding-left: 20px; line-height: 1.8;">
                    <li>Review recent sales performance for this item.</li>
                    <li>Verify existing pending purchase orders.</li>
                    <li>Contact assigned supplier to replenish current stock.</li>
                </ul>
            </div>
            <div style="text-align: center;">
                <a href="{{ url('/') }}" style="background-color: #007bff; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Login to Inventory Module</a>
            </div>
        </div>
        <div style="padding: 20px; background-color: #f8f9fa; border-top: 1px solid #e1e4e8; text-align: center; color: #777777; font-size: 12px;">
            <p style="margin: 0;">This is an automated report from the <strong>{{ config('app.name') }}</strong> Management System.</p>
            <p style="margin: 5px 0 0;">Please do not reply directly to this email.</p>
        </div>
    </div>
</body>
</html>