<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login OTP</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333; max-width: 480px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #1e293b;">Login verification</h2>
    <p>Use the code below to complete your login to {{ config('app.name') }}:</p>
    <p style="font-size: 28px; font-weight: 700; letter-spacing: 6px; color: #3c50e0; margin: 24px 0;">{{ $otp }}</p>
    <p style="color: #64748b; font-size: 14px;">This code expires in 10 minutes. If you didn't request this, you can ignore this email.</p>
    <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 24px 0;">
    <p style="font-size: 12px; color: #94a3b8;">{{ config('app.name') }}</p>
</body>
</html>
