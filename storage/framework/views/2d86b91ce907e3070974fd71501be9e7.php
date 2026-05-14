<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - StocKING</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

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

        .login-card {
            width: 478px;
            background: #FFFFFF;
            border-radius: 10.64px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-img {
            width: 199.27px;
            height: 51.06px;
            margin-bottom: 10px;
            object-fit: contain;
        }

        .login-subtitle {
            color: #A4A0A0;
            font-size: 16px;
            line-height: 30.84px;
            text-align: center;
            margin-bottom: 25px;
        }

        form {
            width: 100%;
        }

        .form-label {
            color: #737373;
            font-size: 18px;
            line-height: 30.84px;
            margin-bottom: 5px;
            display: block;
        }

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

        .footer-text {
            color: #737373;
            font-size: 16px;
            line-height: 30.84px;
            text-align: center;
            margin-top: 20px;
        }

    </style>
</head>

<body>

<div class="login-card">

    
    <img src="<?php echo e(asset('img/STOCKING.png')); ?>"
         alt="StocKING"
         class="logo-img">

    
    <div class="login-subtitle">
        Silahkan Login untuk Melanjutkan
    </div>

    
    <?php if(session('error')): ?>

        <div class="alert alert-danger w-100 text-center">
            <?php echo e(session('error')); ?>

        </div>

    <?php endif; ?>

    
    <form action="<?php echo e(url('login')); ?>" method="POST">

        <?php echo csrf_field(); ?>

        
        <div class="mb-3">

            <label class="form-label">
                Username
            </label>

            <input
                type="text"
                name="username"
                class="form-control"
                placeholder="Masukkan username anda"
                required>

        </div>

        
        <div class="mb-3">

            <label class="form-label">
                Password
            </label>

            <div class="password-wrapper">

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan password anda"
                    required>

                <img
                    src="<?php echo e(asset('img/Icon-eye.png')); ?>"
                    id="togglePassword"
                    alt="Show"
                    class="icon-eye">

            </div>

        </div>

        
        <button type="submit" class="btn-login">
            Masuk
        </button>

    </form>

    
    <div class="footer-text">

        Tidak Punya Akun?

        <a href="/register"
           style="color: #D97706; text-decoration: none;">

            Daftar

        </a>

    </div>

</div>

<script>

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {

        const type =
            password.getAttribute('type') === 'password'
            ? 'text'
            : 'password';

        password.setAttribute('type', type);

        this.style.opacity =
            type === 'password'
            ? '1'
            : '0.5';
    });

</script>

</body>
</html><?php /**PATH C:\xampp\htdocs\stocking\resources\views/user/welcome.blade.php ENDPATH**/ ?>