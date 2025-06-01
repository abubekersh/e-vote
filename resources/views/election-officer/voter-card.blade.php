<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Voter Token PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
        }

        .container {
            width: 350px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 20px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }

        .header {
            background-color: #00b6ba;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 12px;
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #6d54a5;
            color: white;
            font-size: 36px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 10px;
        }

        .name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 5px 0;
        }

        .info {
            font-size: 13px;
            color: #666;
            margin: 2px 0;
        }

        .qr {
            margin: 15px 0;
        }

        .token-box {
            border: 2px dashed #00b6ba;
            padding: 10px;
            margin: 15px 0;
            background-color: #f9f9f9;
        }

        .token-title {
            font-size: 10px;
            color: #999;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .token-value {
            font-family: monospace;
            font-size: 14px;
            font-weight: bold;
            color: #6d54a5;
            word-wrap: break-word;
        }

        .footer {
            font-size: 10px;
            color: #888;
            text-align: center;
            margin: 10px 0;
        }

        .btn {
            background-color: #00b6ba;
            color: white;
            padding: 10px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin: 5px 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    @if (request()->uri()->path() =="card/$voter->id")
    <a href="{{route('create-voter')}}" class="btn">back</a>
    @endif
    <div class="container">
        <div class="header">
            <h2>Voter Token</h2>
            <p>7<sup>th</sup> National Elections – Ethiopia</p>
        </div>
        <div class="content">
            <div class="avatar">
                {{ strtoupper(substr($voter->name, 0, 1))}}
            </div>
            <div class="name">{{ $voter->name }}</div>
            <div class="info">Voter ID: <strong>{{ $voter->id }}</strong></div>
            <div class="info">Constituency: <strong>{{ $voter->polling_station->constituency->name ?? 'N/A' }}</strong></div>

            <div class="qr">
                @if (request()->uri()->path() =="card/$voter->id")
                <img src="/storage/{{$qrcode}}" width="150px" alt="">
                @else
                <img src="{{ $qrcode }}" alt="QR Code" width="150">
                @endif

            </div>

            <div class="token-box">
                <div class="token-title">Secure Token</div>
                <div class="token-value">{{ $voter->token }}</div>
            </div>

            <div class="footer">
                Token expires: <strong>{{ $voter->token_expires_at ?? 'N/A' }}</strong>
            </div>

            @if (request()->uri()->path() =="card/$voter->id")
            <a href="/cardtopdf/{{$voter->id}}" class="p-2 bg-primary text-white">Download</a>
            @endif
        </div>
    </div>
</body>

</html>