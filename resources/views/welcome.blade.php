<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - StocKING</title>
    
    <!-- Import Font Montserrat dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    
    <!-- Menggunakan Bootstrap untuk memudahkan posisi rata tengah -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* 1. Background */
        body {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            background-color: #D9D9D9; 
            height: 100vh;
            display: flex;
            align-items: center; 
            justify-content: center; 
            margin: 0;
        }

        /* 2. Layout Kotak Login Utama (Width: 478px) */
        .login-card {
            width: 478px; 
            background: #FFFFFF;
            border-radius: 10.64px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* 3. Logo StocKING (Width: 199.27px) */
        .logo-img {
            width: 199.27px;
            height: 51.06px;
            margin-bottom: 10px;
            object-fit: contain;
        }

        /* 4. Subtitle (Silahkan Login...) */
        .login-subtitle {
            color: #A4A0A0;
            font-size: 16px;
            line-height: 30.84px;
            text-align: center;
            margin-bottom: 25px;
        }

        /* 5. Form Container agar lebar input pas */
        form {
            width: 100%;
        }

        /* 6. Teks Label (Username & Password) */
        .form-label {
            color: #737373;
            font-size: 18px;
            line-height: 30.84px;
            margin-bottom: 5px;
            display: block;
        }

        /* 7. Kotak Input (Height: 48.22px, Border: 2.13px) */
        .form-control {
            width: 100%;
            height: 48.22px;
            border-radius: 10.64px;
            border: 2.13px solid #D9D9D9;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            padding-left: 15px;
        }

        .form-control::placeholder {
            color: #A4A0A0;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #D97706; 
        }

        /* 8. Wrapper Password & Icon Eye */
        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .icon-eye {
            position: absolute;
            width: 24.7px; 
            height: 17.96px;
            right: 15px; 
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        /* 9. Tombol Login dengan Gradasi (Sudah Dibalik!) */
        .btn-login {
            width: 100%;
            height: 48px;
            border-radius: 10.64px;
            background: linear-gradient(to right, #F59E0B, #DBD400);
            border: none;
            color: white;
            font-size: 16px;
            font-weight: 700;
            margin-top: 35px;
            cursor: pointer;
        }

        /* 10. Teks Footer */
        .footer-text {
            color: #737373;
            font-size: 16px;
            line-height: 30.84px;
            text-align: center;
            margin-top: 20px;
        }

        .footer-text span {
            color: #D97706;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="login-card">
        
        <!-- Logo StocKING -->
        <img src="{{ asset('img/STOCKING.png') }}" alt="StocKING" class="logo-img">
        
        <div class="login-subtitle">Silahkan Login untuk Melanjutkan</div>

        <form>
            <!-- Input Username -->
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" placeholder="Masukkan username anda">
            </div>

            <!-- Input Password -->
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" class="form-control" placeholder="Masukkan password anda">
                    <img src="{{ asset('img/Icon-eye.png') }}" id="togglePassword" alt="Show" class="icon-eye">
                </div>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="footer-text">
    Tidak Punya Akun? <a href="/register" style="color: #D97706; text-decoration: none;">Daftar</a>
</div>
    </div>

    <!-- JavaScript untuk Show/Hide Password -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Tukar tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Ubah transparansi icon sebagai penanda interaksi
            this.style.opacity = type === 'password' ? '1' : '0.5';
        });
    </script>
</body>
</html>