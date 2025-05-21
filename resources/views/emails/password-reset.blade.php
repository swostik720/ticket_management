<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8em;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Password Reset Request</h1>
    </div>
    <div class="content">
        <p>Hello,</p>

        <p>You are receiving this email because we received a password reset request for your account.</p>

        <p>Please click the button below to reset your password:</p>

        <p style="text-align: center;">
            <a href="{{ $resetUrl }}" class="button">Reset Password</a>
        </p>

        <p>This password reset link will expire in 60 minutes.</p>

        <p>If you did not request a password reset, no further action is required.</p>

        <p>Thank you,<br>
        Ticket Management System Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Ticket Management System. All rights reserved.</p>
    </div>
</body>
</html>
