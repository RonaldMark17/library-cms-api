<!-- resources/views/unsubscribe.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 450px;
        }
        h1 {
            margin-bottom: 1rem;
            font-size: 1.8rem;
        }
        .success { color: green; }
        .error { color: red; }
        .info { color: #007BFF; }
        a {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 0.5rem 1rem;
            background: #007BFF;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="{{ $status }}">{{ ucfirst($status) }}</h1>
        <p>{{ $message }}</p>

        @if($status === 'error')
            <a href="{{ url('/') }}">Go to Homepage</a>
        @elseif($status === 'success')
            <a href="{{ url('/') }}">Return to Homepage</a>
        @elseif($status === 'info')
            <a href="{{ url('/') }}">Go to Homepage</a>
        @endif
    </div>
</body>
</html>
