<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CTUET|ADMIN</title>
    <link rel="icon" href="img/CTUT_logo_nen.png" type="image/x-icon">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <style>
        @import url(https://fonts.googleapis.com/css?family=Po ppins: 100, 100italic, 200, 200italic, 300, 300italic, regula r, italic, 500, 500italic, 600, 600italic, 700, 700italic, 80 0,800italic, 900, 900italic);

        * {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
        }

        section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            background: url("img/background_loginadmin.jpeg");
            background-position: center;
            background-size: cover;
        }

        .form-box {
            position: relative;
            width: 400px;
            height: 450px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #0000008f;
            border: 2px solid #fff;
            border-radius: 10px;
        }

        h2 {
            font-size: 2rem;
            color: #fff;
            text-align: center;
        }

        .input-box {
            position: relative;
            margin-top: 30px;
            width: 320px;
            border-bottom: 2px solid #fff;
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 5px;
            color: #fff;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 1rem;
            transition: 0.5s;
        }

        .input-box input {
            width: 100%;
            height: 25px;
            background: transparent;
            outline: none;
            border: none;
            font-size: 1em;
            padding: 0 35px 0 5px;
            color: #fff;
        }

        input:focus~label,
        input:valid~label {
            top: -10px;
        }

        .input-box ion-icon {
            position: absolute;
            right: 8px;
            color: #fff;
            font-size: 1.2em;
        }

        .f-password {
            margin: 15px 0 15px;
            font-size: 0.9em;
            color: #fff;
            display: flex;
            justify-content: space-between;
        }

        .f-password label input {
            margin-right: 3px;
        }

        .f-password a:hover {
            color: #fff;
        }

        button {
            width: 100%;
            height: 50px;
            border-radius: 0px 10px 0px 10px;
            font-size: 1.2rem;
            font-weight: 700;
            margin-top: 20px;
            background: #fff;
            color: #000;
        }

        button:hover {
            background: transparent;
            color: #fff;
        }

        .signup {
            font-size: 0.8rem;
            color: #fff;
            margin-top: 20px;
        }

        .signup a:hover {
            color: #fff;
        }

        .validate_loginadmin {
            font-size: 13px;
            color: red;
            text-align: right;
            padding-top: 5px;

        }
    </style>
</head>

<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <div class="input-box" style="border:none; display:flex; justify-content:center; align-items: center;" >
                    <img src="img/CTUT_logo_nen.png" class="" style="width:40%;">
                </div>
                <div class="input-box">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="text" id = "email_admin" required>
                    <label for="#">Email</label>
                </div>
                <div class="col-md-12 col-12 validate_loginadmin" id="error_email"></div>
                <div class="input-box">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" id="password_admin" required>
                    <label for="#">Password</label>
                </div>
                <div class="col-md-12 col-12 validate_loginadmin" id="error_password"></div>
                <div class="f-password">
                    <label for="#">
                        <input type="checkbox" id="remember_account">
                        Remember Me
                    </label>
                </div>
                <button onclick="login()">Đăng nhập</button>

                <div class="col-md-12 col-12 validate_loginadmin" id="error_login"></div>

            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</body>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/admin/admin24/js/login.js"></script>

</html>
