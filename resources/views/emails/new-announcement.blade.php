<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Announcement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 15px;
        }
        p {
            color: #555555;
            font-size: 16px;
            line-height: 1.5;
        }
        .button {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            font-size: 16px;
            color: #ffffff;
            background-color: #1a73e8;
            border-radius: 5px;
            text-decoration: none;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #aaaaaa;
            text-align: center;
        }
        .image {
            max-width: 100%;
            margin: 20px 0;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>{{ $announcement->title['en'] }}</h1>

        @if($announcement->image_path)
            <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="Announcement Image" class="image">
        @endif

        <p>{{ $announcement->content['en'] }}</p>

        <a href="{{ $unsubscribeUrl }}" class="button">Unsubscribe</a>

        <p class="footer">You are receiving this email because you subscribed to our announcements.</p>
    </div>
</body>
</html>
