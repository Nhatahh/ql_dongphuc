<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
        }

        .login-card h2 {
            margin-bottom: 30px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        .form-control {
            border-radius: 8px;
        }

        .signinBtn {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .signinBtn:hover {
            background-color: #0056b3;
        }

        .form-footer {
            margin-top: 15px;
            text-align: center;
        }

        .form-footer span {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-footer a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 18px;
            color: #fff;
        }

        .back-link:hover {
            color: #e0e0e0;
        }
    </style>
</head>
<body>

    <a href="{{ route('home.index') }}" class="back-link"><i class="fa-solid fa-chevron-left"></i> Trang chủ</a>

    <div class="login-card">
        <form action="" method="">
            <h2>ĐĂNG NHẬP</h2>

            <div class="form-group">
                <input class="form-control" type="text" placeholder="Nhập email hoặc số điện thoại" required>
            </div>

            <div class="form-group">
                <input class="form-control" type="password" placeholder="Mật khẩu" required>
            </div>

            <button type="submit" class="signinBtn mt-3">Đăng nhập</button>

            <div class="form-footer mt-4">
                <span>Quên mật khẩu?</span>
                <a href="#" class="signupLink">Đăng ký tài khoản mới</a>
            </div>
        </form>
    </div>

</body>
</html>
