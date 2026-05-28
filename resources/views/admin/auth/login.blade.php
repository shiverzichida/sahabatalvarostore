<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sahabat Alvaro Store</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Sahabat Steroid flat transparent.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text-main);
            overflow: hidden;
            position: relative;
        }

        /* Subtle ambient glow elements */
        body::before, body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            opacity: 0.15;
        }

        body::before {
            background: var(--primary);
            top: -100px;
            left: -100px;
        }

        body::after {
            background: #3b82f6;
            bottom: -100px;
            right: -100px;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            z-index: 1;
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .login-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .logo-area {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-area img {
            height: 64px;
            width: auto;
            margin-bottom: 16px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .logo-area h1 {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-area p {
            font-size: 14px;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #cbd5e1;
            margin-bottom: 8px;
        }

        .input-control {
            width: 100%;
            padding: 14px 16px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            transition: all 0.25s ease;
            outline: none;
        }

        .input-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 254, 0.15);
            background: rgba(15, 23, 42, 0.8);
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(37, 99, 254, 0.25);
        }

        .submit-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 254, 0.35);
        }

        .submit-btn:active {
            transform: translateY(1px);
        }

        .error-banner {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            color: #f87171;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s ease-in-out;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #fff;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <div class="logo-area">
            <img src="{{ asset('images/Sahabat Steroid flat transparent.png') }}" alt="Sahabat Alvaro Logo">
            <h1>Admin Panel</h1>
            <p>Sahabat Alvaro Store</p>
        </div>

        @if($errors->has('login_error'))
            <div class="error-banner">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>{{ $errors->first('login_error') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input class="input-control" type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan username admin" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input class="input-control" type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="submit-btn">Masuk Ke Panel</button>
        </form>

        <a href="{{ url('/') }}" class="back-link">&larr; Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>
