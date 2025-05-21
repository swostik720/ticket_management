<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your New Account Credentials</title>
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
        .credentials {
            background-color: #f8f9fa;
            padding: 15px;
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
        <h1>Welcome to Ticket Management System</h1>
    </div>
    <div class="content">
        <p>Hello {{ $user->name }},</p>

        <p>Your account has been created in the Ticket Management System. Below are your login credentials:</p>

        <div class="credentials">
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
            <p><strong>Role:</strong> {{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
        </div>

        {{-- <p>Please login at <a href="{{ url('/login') }}">{{ url('/login') }}</a> and change your password as soon as possible for security reasons.</p> --}}

        <p>If you have any questions or need assistance, please contact the system administrator.</p>

        <p>Thank you,<br>
        Ticket Management System Team</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Ticket Management System. All rights reserved.</p>
    </div>
</body>
</html>
