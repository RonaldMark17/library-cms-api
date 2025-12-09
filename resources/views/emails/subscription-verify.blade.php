<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Verification</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; padding: 2rem; }
        .container { max-width: 500px; margin: auto; background: #fff; padding: 2rem; border-radius: 10px; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { margin-bottom: 1rem; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        a { display: inline-block; margin-top: 1rem; color: #007BFF; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="{{ $status }}">{{ ucfirst($status) }}</h1>
        <p>{{ $message }}</p>
        <a href="{{ url('/') }}">Go to Homepage</a>
    </div>
</body>
</html>
