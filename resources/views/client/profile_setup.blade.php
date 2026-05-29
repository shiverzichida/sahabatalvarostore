<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil Awal - Sahabat Alvaro Store</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Sahabat Steroid flat transparent.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #0b0f19;
            --card-bg: rgba(17, 24, 39, 0.8);
            --card-border: rgba(255, 255, 255, 0.08);
            --primary: #10b981;
            --primary-hover: #059669;
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --accent-blue: #3b82f6;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.12) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.1) 0, transparent 50%);
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .container {
            width: 100%;
            max-width: 550px;
        }

        .glass-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 30px;
        }

        .header-logo img {
            height: 60px;
            margin-bottom: 12px;
        }

        .header-logo h2 {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-logo p {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 6px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .input-control {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            transition: all 0.3s;
        }

        .input-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
            background: rgba(15, 23, 42, 0.8);
        }

        select.input-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, #059669 100%);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .error-alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .logout-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--text-muted);
            font-size: 13px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .logout-link:hover {
            color: #ef4444;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="glass-card">
        <div class="header-logo">
            <img src="{{ asset('images/Sahabat Steroid flat transparent.png') }}" alt="Logo">
            <h2>Lengkapi Profil Fisik Anda</h2>
            <p>Silakan isi informasi awal tubuh Anda untuk mulai mencatat dan melihat progres latihan Anda.</p>
        </div>

        @if ($errors->any())
            <div class="error-alert">
                <ul style="list-style-position: inside;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('client.profile.store') }}" method="POST">
            @csrf
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="birth_date">Tanggal Lahir</label>
                    <input type="date" id="birth_date" name="birth_date" class="input-control" value="{{ old('birth_date') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="gender">Jenis Kelamin</label>
                    <select id="gender" name="gender" class="input-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="initial_height">Tinggi Badan (cm)</label>
                    <input type="number" step="0.1" id="initial_height" name="initial_height" class="input-control" placeholder="Contoh: 175" value="{{ old('initial_height') }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="initial_weight">Berat Badan (kg)</label>
                    <input type="number" step="0.1" id="initial_weight" name="initial_weight" class="input-control" placeholder="Contoh: 72.5" value="{{ old('initial_weight') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="initial_body_fat">Body Fat % (Optional)</label>
                    <input type="number" step="0.1" id="initial_body_fat" name="initial_body_fat" class="input-control" placeholder="Contoh: 15.4" value="{{ old('initial_body_fat') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="goal">Target Utama Gym (Optional)</label>
                    <select id="goal" name="goal" class="input-control">
                        <option value="">-- Pilih Target --</option>
                        <option value="Menurunkan Berat Badan" {{ old('goal') === 'Menurunkan Berat Badan' ? 'selected' : '' }}>Menurunkan Berat Badan (Fat Loss)</option>
                        <option value="Membentuk Otot" {{ old('goal') === 'Membentuk Otot' ? 'selected' : '' }}>Membentuk Otot (Bulking)</option>
                        <option value="Meningkatkan Stamina/Kebugaran" {{ old('goal') === 'Meningkatkan Stamina/Kebugaran' ? 'selected' : '' }}>Meningkatkan Stamina / Kebugaran</option>
                        <option value="Menjaga Berat Badan" {{ old('goal') === 'Menjaga Berat Badan' ? 'selected' : '' }}>Menjaga Berat Badan (Maintenance)</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="submit-btn">Simpan & Masuk Dasbor</button>
        </form>

        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">
                Keluar / Logout
            </a>
        </form>
    </div>
</div>

</body>
</html>
