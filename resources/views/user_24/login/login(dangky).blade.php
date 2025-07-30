<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style.css" /> -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>CTUT|Đăng nhập</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        :root {
            --background: #1634c9db;
            --text: #fff;
            --text2: #000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            font-size: medium;
        }

        body {
            background: url(img/ai.jpg);
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 0 20px;
        }

        .form-containet {
            display: flex;
            width: 400px;
            height: 600px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            backdrop-filter: blur(20px);
            overflow: hidden;
        }

        .col-1 {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 55%;
            background: rgba(255, 255, 255, 0.3);
            background-repeat: blur(30px);
            border-radius: 0 30% 20% 0;
            transition: border-radius .3s;
        }

        .image-layer {
            position: relative;
        }

        .form-image-main {
            width: 350px;
            animation: scale-up 2s ease-in-out alternate infinite;
        }

        .form-image {
            width: 400px;
            position: absolute;
            left: 0;
        }

        .fi-1 {
            animation: scale-down 2s ease-in-out alternate infinite;
        }

        .fi-2 {
            animation: up-down 2s ease-in-out alternate infinite;
        }

        @keyframes scale-down {
            to {
                transform: translateX(20px);
            }
        }

        @keyframes up-down {
            to {
                transform: translateY(20px);
            }
        }

        .form-image-1 {
            width: 200px;
            position: absolute;
        }

        .form-image-2 {
            width: 100px;
            margin-left: 35px;
        }

        .form-image-3 {
            width: 90px;
            left: 0;
            position: absolute;
        }

        .featured-words {
            color: var(--text);
            width: 300px;
            text-align: center;
        }

        .featured-words span {
            font-weight: 600;
            color: var(--text2);
        }

        .col-2 {
            position: relative;
            width: 45%;
            padding: 20px;
            overflow: hidden;

        }

        .btn-box {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn {
            font-weight: 500;
            padding: 5px 30px;
            border: none;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.2);
            color: var(--text);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: .2s
        }

        .btn-1 {
            background: var(--background);
        }

        .btn:hover {
            opacity: 0.85;
        }

        .login-form {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            flex-direction: column;
            width: 100%;
            padding: 0 4vw;
            transition: .3s;
            margin-top: 4.5em;
        }

        .register-form {
            position: absolute;
            left: -50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            flex-direction: column;
            width: 100%;
            padding: 0 4vw;
            transition: .3s;
        }

        .register-form .form-title {
            margin-block: 40px 20px;
        }

        .form-title {
            margin: 40px 0;
            color: var(--text);
            font-size: 28px;
            font-weight: 600;
        }

        .form-inputs {
            width: 100%;
        }

        .input-box {
            position: relative;
        }

        .input-field {
            width: 100%;
            height: 55px;
            padding: 0 15px;
            margin: 10px 0;
            color: var(--text);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 10px;
            outline: none;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        ::placeholder {
            color: var(--text);
            font-size: 15px;
        }

        .input-box .icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: var(--text);
        }

        .forget-pass {
            display: flex;
            justify-content: right;
            gap: 14px;
        }

        .forget-pass a {
            color: var(--text);
            text-decoration: none;
            font-size: 14px;
        }

        .forget-pass a:hover {
            text-decoration: underline;
        }

        .input-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            height: 55px;
            padding: 0 15px;
            margin: 10px 0;
            color: var(--text);
            background: var(--background);
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: .3s;
        }

        .input-submit:hover {
            gap: 15px;
        }

        .social-login {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .social-login i {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            width: 40px;
            color: var(--text);
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: .2s;
        }

        .social-login i:hover {
            transform: scale(0.8);
        }

        @media(max-width: 892px) {
            .form-containet {
                width: 80%;
            }

            .col-1 {
                display: none;
            }

            .col-2 {
                width: 100%;
            }
        }

        /* Thời tiết */

        .thoitiet {

            padding: 20px;
            color: #fff;
            border-radius: 10px;
            font-family: arial;
            font-size: 18px;
        }

        #otiet {
            background: #fff;
            padding: 10px;
            width: 100%;
            border: none;
        }

        #timtiet {
            background: #666;
            border: none;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="form-containet">
        <div class="col col-12">
            <div class="login-form">
                <div class="form-title" style="display: flex; justify-content: center;">
                    <img src="img/logo.png" class="" style="width:50%;">
                </div>
                <div class="form-inputs">
                    <div class="input-box">
                        <button disabled class="input-submit" onclick="window.location='{{ route('loginbygoogle') }}'">
                            <i class="bx bxl-google"></i>
                            <span>Đăng nhập</span>
                            <i class="bx bx-right-arrow-alt"></i>
                        </button>
                        <div style="color:white">Hệ thống tạm khóa để phục vụ công tác xét tuyển!</div>
                    </div>
                </div>
                <div class="social-login">
                </div>
            </div>
            <div class="register-form">
                <div class="form-title">
                    <span>Đăng nhập</span>
                </div>
                <div class="form-inputs">
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="User Name" required>
                        <i class='bx bx-user icon'></i>
                    </div>
                    <div class="input-box">
                        <input type="email" class="input-field" placeholder="Email" required>
                        <i class='bx bx-envelope icon'></i>
                    </div>
                    <div class="input-box">
                        <input type="password" class="input-field" placeholder="Password" required>
                        <i class='bx bx-lock-alt icon'></i>
                    </div>
                    <div class="input-box">
                        <button disabled class="input-submit">
                            <span>Đăng nhập</span>
                            <i class="bx bx-right-arrow-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="social-login">
                    <i class="bx bxl-google"></i>
                    <i class="bx bxl-facebook"></i>
                    <i class="bx bxl-twitter"></i>
                    <i class="bx bxl-github"></i>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        const loginBtn = document.querySelector("#login");
        const registerBtn = document.querySelector("#register");
        const loginForm = document.querySelector(".login-form");
        const registerForm = document.querySelector(".register-form");

        loginBtn.addEventListener('click', () => {
            loginBtn.style.backgroundColor = "#21264D";
            registerBtn.style.backgroundColor = "rgba(255, 255, 255, 0.2)";

            loginForm.style.left = "50%";
            registerForm.style.left = "-50%";

            loginForm.style.opacity = "1";
            registerForm.style.opacity = "0";

            document.querySelector(".col-1").style.borderRadius = "0 30% 20% 0";

        })

        registerBtn.addEventListener('click', () => {
            loginBtn.style.backgroundColor = "rgba(255, 255, 255, 0.2)";
            registerBtn.style.backgroundColor = "#21264D";

            loginForm.style.left = "150%";
            registerForm.style.left = "50%";

            loginForm.style.opacity = "0";
            registerForm.style.opacity = "1";

            document.querySelector(".col-1").style.borderRadius = "0 20% 30% 0";

        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js"
        integrity="sha512-PJa3oQSLWRB7wHZ7GQ/g+qyv6r4mbuhmiDb8BjSFZ8NZ2a42oTtAq5n0ucWAwcQDlikAtkub+tPVCw4np27WCg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        axios.get('http://ip-api.com/json/')
            .then(response => {
                const data = response.data;
                const lat = data.lat;
                const lon = data.lon;
                const weatherApiUrl = `http://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=57f7cb46976234929b19b0d685e6fd08&units=metric`;
                return axios.get(weatherApiUrl);
            })
            .then(response => {
                const weatherData = response.data;
                const location = weatherData.name;
                const weatherDescription = weatherData.weather[0].description;
                const temperature = weatherData.main.temp;
                const humidity = weatherData.main.humidity;
                const windSpeed = weatherData.wind.speed;
                document.querySelector(".thoitiet .city").innerText = `${location}`;
                document.querySelector(".thoitiet .description").innerText = weatherDescription;
                document.querySelector(".thoitiet .temp").innerText = `${temperature}°C`;
                document.querySelector(".thoitiet .humidity").innerText = `Độ ẩm: ${humidity}%`;
                document.querySelector(".thoitiet .wind").innerText = `Gió: ${windSpeed} km/h`;
            })
            .catch(error => {
                console.error("Có lỗi xảy ra:", error);
            });
    </script> --}}
</body>
<script src="/admin/admin_24/js/vendor/jquery-1.12.4.min.js"></script>
<script  src="/admin/admin_24/jsconfig/login.js"></script>
</html>
