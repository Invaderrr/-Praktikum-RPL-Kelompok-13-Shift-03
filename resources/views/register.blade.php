<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - StocKING</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #D9D9D9; 
            min-height: 100vh;
            display: flex;
            align-items: center; 
            justify-content: center; 
            margin: 0;
        }

        .login-card {
            width: 478px; 
            background: #FFFFFF;
            border-radius: 10.64px;
            padding: 40px 22px; /* Disesuaikan agar total lebar dan ruang dalam seimbang */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-img {
            width: 199.27px;
            height: 65px;
            object-fit: contain;
            margin-bottom: 5px;
        }

        .login-subtitle {
            color: #A4A0A0;
            font-size: 16px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
            line-height: 30.84px;
        }

        /* Sesuaikan judul Sign Up */
        .signup-title {
            align-self: flex-start;
            color: #333333;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 0px; /* Jarak dari tulisan 'Sign Up' ke label 'Username' */
            line-height: 1.2px; /* Sesuai height di Figma */
        }

        .form-group {
            width: 433.99px;
            margin-bottom: 20px; /* Jarak antar kolom input (misal dari Username ke Email) */
        }

        .form-label {
            color: #737373;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            margin-top: 5px;
            line-height: 1.2px;
            display: block;
        }

        .form-control {
            width: 100%;
            height: 48.22px;
            border-radius: 10.64px;
            border: 2.13px solid #D9D9D9;
            background: #FFFFFF;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            padding-left: 15px;
            color: #333;
        }

        .form-control::placeholder {
            color: #A4A0A0;
            font-size: 16px;
            font-weight: 700;
            line-height: 30.84px;
        }

        .form-control:focus {
            border-color: #F59E0B;
            box-shadow: none;
            outline: none;
        }

        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .icon-eye {
            position: absolute;
            width: 22px; 
            right: 15px; 
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .btn-register {
            width: 433.99px;
            height: 48.22px;
            border-radius: 10.64px;
            background: linear-gradient(269.3deg, #F59E0B 100.01%, #DBD400 0.01%);
            border: none;
            color: #FFFFFF;
            font-size: 18px;
            font-weight: 700;
            line-height: 30.84px;
            margin-top: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-text {
            color: #737373;
            font-size: 16px;
            font-weight: 700;
            line-height: 30.84px;
            margin-top: 20px;
        }

        .footer-text a {
            color: #D97706; /* Menyesuaikan warna "Masuk" dengan gradasi tombol */
            text-decoration: none;
        }

        /* Definisikan animasinya dulu */
        @keyframes fadeInUp {
                from {
                opacity: 0;
                transform: translateY(20px); /* Mulai dari 20px di bawah posisi asli */
            }
                to {
                opacity: 1;
                transform: translateY(0);    /* Berakhir di posisi asli */
            }
        }

/* Terapkan animasi ke kartu login/register */
        .login-card {
    /* ... kode yang sudah ada ... */
            animation: fadeInUp 1s ease-out; /* Durasi 0.6 detik, gerakan halus */
        }
        </style>
    </head>
    <body>

    <div class="login-card">
        <img src="{{ asset('img/STOCKING.png') }}" alt="StocKING" class="logo-img">
        <div class="login-subtitle">Isi Data Untuk Melanjutkan</div>

        <div class="form-group">
            <div class="signup-title">Sign Up</div>
        </div>

        <form action="/register" method="POST">
            @csrf
            
            <!-- Username -->
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Buat username anda">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email anda">
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Buat password anda">
                    <img src="{{ asset('img/Icon-eye.png') }}" class="icon-eye toggle-pass" data-target="password">
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Ulangi password">
                    <img src="{{ asset('img/Icon-eye.png') }}" class="icon-eye toggle-pass" data-target="confirm_password">
                </div>
            </div>

            <button type="submit" class="btn-register">Buat Akun</button>
        </form>

        <div class="footer-text">
    Sudah Punya Akun? <a href="/" style="color: #D97706; text-decoration: none;">Masuk</a>
</div>
    </div>

    <script>
        const toggles = document.querySelectorAll('.toggle-pass');
        toggles.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.style.opacity = type === 'password' ? '1' : '0.5';
            });
        });
    </script>
</body>
</html>