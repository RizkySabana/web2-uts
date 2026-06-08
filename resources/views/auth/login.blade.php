<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --safir: #1B6B5A;
            --safir-dark: #145247;
            --krem: #F5F0E8;
        }

        body {
            background: var(--krem);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .login-box {
            background: white;
            border-radius: 16px;
            padding: 40px 36px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .1);
            border: 1px solid #D4C9B0;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .login-logo .icon {
            width: 64px;
            height: 64px;
            background: var(--safir);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            margin-bottom: 12px;
        }

        .login-logo h1 {
            font-size: 20px;
            font-weight: 700;
            color: var(--safir-dark);
            margin: 0;
        }

        .login-logo p {
            font-size: 13px;
            color: #6B7280;
            margin: 4px 0 0 0;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #D4C9B0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color .2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--safir);
            box-shadow: 0 0 0 3px rgba(27, 107, 90, .1);
        }

        .btn-login {
            width: 100%;
            background: var(--safir);
            color: white;
            padding: 11px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
            margin-top: 8px;
        }

        .btn-login:hover {
            background: var(--safir-dark);
        }

        .field-error {
            color: #DC2626;
            font-size: 12px;
            margin-top: 4px;
        }

        .hint-box {
            background: #F5F0E8;
            border-radius: 8px;
            padding: 12px;
            margin-top: 20px;
            font-size: 12px;
            color: #6B7280;
            border: 1px solid #D4C9B0;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <div class="login-logo">
            <div class="icon"><i class="fas fa-book-open"></i></div>
            <h1>Perpustakaan Digital</h1>
            <p>Sistem Peminjaman Buku</p>
        </div>

        @if(session('success'))
            <div
                style="background:#D1FAE5;color:#065F46;padding:10px 14px;border-radius:7px;margin-bottom:16px;font-size:13px;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@perpus.test">
                @error('email') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="password123">
                @error('password') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <label
                style="display:flex;align-items:center;gap:6px;font-size:13px;color:#6B7280;margin-bottom:4px;font-weight:normal;">
                <input type="checkbox" name="remember" value="1" style="width:auto;"> Ingat saya
            </label>
            <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt"></i> Login</button>
        </form>
        <div class="hint-box">
            <strong>Akun Demo:</strong><br>
            Admin: admin@perpus.test / password123<br>
            Anggota : rizky.sabana@perpus.test / password123
        </div>
    </div>
</body>

</html>