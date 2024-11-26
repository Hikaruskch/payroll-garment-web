<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hikaru Garment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f6f6f6;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .main-container {
            display: flex;
            height: 100vh;
        }

        .login-side {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .decoration-side {
            width: 50%;
            background-color: #ece8e5;
            position: relative;
            overflow: hidden;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(68, 63, 60, 0.12);
        }

        .form-title {
            color: #443f3c;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
        }

        .form-control {
            padding: 12px 15px;
            border: 2px solid #ece8e5;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #ec7d4b;
            box-shadow: 0 0 0 0.2rem rgba(236, 125, 75, 0.1);
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #443f3c;
            z-index: 10;
        }

        .input-with-icon {
            padding-left: 45px;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #ec7d4b;
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #d66a3b;
            transform: translateY(-2px);
        }

        .decoration-circle {
            position: absolute;
            border-radius: 50%;
            background-color: #ec7d4b;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            right: -50px;
            opacity: 0.1;
        }

        .circle-2 {
            width: 200px;
            height: 200px;
            bottom: 50px;
            right: 100px;
            opacity: 0.15;
        }

        .circle-3 {
            width: 150px;
            height: 150px;
            top: 50%;
            right: 250px;
            opacity: 0.2;
        }

        .welcome-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #443f3c;
            z-index: 2;
        }

        .welcome-text h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .welcome-text p {
            font-size: 1.1rem;
            opacity: 0.8;
        }

        .company-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            background-color: #ec7d4b;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Login Side -->
        <div class="login-side">
            <div class="login-form">
                <div class="company-logo">
                    <div class="logo-circle">HG</div>
                </div>
                <h2 class="form-title text-center">Welcome Back!</h2>
                <form method="POST" action="proses_login.php">
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="form-control input-with-icon" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control input-with-icon" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-login">Sign In</button>
                </form>
            </div>
        </div>

        <!-- Decoration Side -->
        <div class="decoration-side">
            <div class="welcome-text">
                <h1>Hikaru Garment</h1>
                <p>Management System</p>
            </div>
            <div class="decoration-circle circle-1"></div>
            <div class="decoration-circle circle-2"></div>
            <div class="decoration-circle circle-3"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>