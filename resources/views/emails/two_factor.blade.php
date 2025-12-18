<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Two-Factor Authentication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 10px #ccc;
        }
        .code {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            color: #2a9d8f;
        }
        .footer {
            font-size: 12px;
            text-align: center;
            color: #888;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Hello {{ $user->name }},</h2>
        <p>Your Two-Factor Authentication (2FA) code is:</p>
        <div class="code">{{ $code }}</div>
        <p>This code will expire in 10 minutes. Do not share it with anyone.</p>
        <p>Thank you,<br>The Team</p>
        <div class="footer">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </div>
    </div>
</body>
</html>
