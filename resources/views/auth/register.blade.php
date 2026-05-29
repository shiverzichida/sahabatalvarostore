<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Client - Sahabat Alvaro Store</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Sahabat Steroid flat transparent.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --primary: #10b981;
            --primary-hover: #059669;
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
            overflow-y: auto;
            position: relative;
        }

        body::before, body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            opacity: 0.12;
        }

        body::before {
            background: var(--primary);
            top: -100px;
            left: -100px;
        }

        body::after {
            background: #2563eb;
            bottom: -100px;
            right: -100px;
        }

        .login-container {
            width: 100%;
            max-width: 460px;
            z-index: 1;
            margin: 20px 0;
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
            margin-bottom: 28px;
        }

        .logo-area img {
            height: 56px;
            width: auto;
            margin-bottom: 12px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .logo-area h1 {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-area p {
            font-size: 14px;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #cbd5e1;
            margin-bottom: 6px;
        }

        .input-control {
            width: 100%;
            padding: 12px 16px;
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
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
            background: rgba(15, 23, 42, 0.8);
        }

        .submit-btn {
            width: 100%;
            padding: 13px;
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
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }

        .submit-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
        }

        .submit-btn:active {
            transform: translateY(1px);
        }

        .error-message {
            color: #f87171;
            font-size: 13px;
            margin-top: 5px;
            font-weight: 500;
        }

        .footer-text {
            display: block;
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .footer-text a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text a:hover {
            text-decoration: underline;
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
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <div class="logo-area">
            <img src="{{ asset('images/Sahabat Steroid flat transparent.png') }}" alt="Sahabat Alvaro Logo">
            <h1>Daftar Client</h1>
            <p>Mulai kelola rencana suplemen & vitamin Anda</p>
        </div>

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input class="input-control" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required autofocus>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <input class="input-control" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Contoh: nama@domain.com" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="whatsapp">Nomor WhatsApp</label>
                <input class="input-control" type="tel" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="Contoh: 081234567890" required>
                @error('whatsapp')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input class="input-control" type="password" id="password" name="password" placeholder="Minimal 6 karakter" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <input class="input-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password Anda" required>
            </div>

            <button type="submit" class="submit-btn">Daftar Sekarang</button>
        </form>

        <span class="footer-text">Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a></span>
    </div>
</div>

</body>
</html>
