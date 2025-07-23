<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Reset Password - LMS X</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('metch') }}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metch') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="https://preview.keenthemes.com/metronic/theme/html/demo1/dist/assets/media/logos/favicon.ico" />
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: 'Poppins', sans-serif;
        }
        .reset-container {
            background: rgba(255, 255, 255, 0.15);
            padding: 40px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: white;
            max-width: 400px;
            width: 100%;
        }
        .reset-container h3 {
            font-weight: 600;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .btn-primary {
            background-color: #ff9800;
            color: white;
            border-radius: 25px;
            padding: 10px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #e68900;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .text-link {
            color: #ffcc80;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s;
        }
        .text-link:hover {
            color: #ffb74d;
        }
    </style>
</head>
<body>
<div class="reset-container">
    <h3>Reset Password</h3>
    <p>Enter your new password to regain access</p>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
{{--        <input type="hidden" name="token" value="{{ $token }}">--}}
        <div class="form-group">
            <input id="email" type="email" class="form-control" placeholder="E-Mail Address" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
        </div>
        <div class="form-group">
            <input id="password" type="password" class="form-control" placeholder="New Password" name="password" required autocomplete="new-password">
        </div>
        <div class="form-group">
            <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </div>
        <div class="mt-3">
            <span>Remembered your password?</span>
            <a href="{{ route('login') }}" class="text-link">Sign In</a>
        </div>
    </form>
</div>
</body>
</html>
