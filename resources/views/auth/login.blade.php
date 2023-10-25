<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles-dark.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #fff;
        }

        .container {
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .login-tabs {
            display: flex;
            justify-content: space-around;
            padding: 10px;
        }

        .tab {
            cursor: pointer;
            padding: 10px 20px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #444;
        }

        .tab.active {
            background-color: #007BFF;
            color: #fff;
        }

        .login-content {
            padding: 20px;
        }

        .form {
            display: none;
        }

        .form.active {
            display: block;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #222;
            color: #fff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .night-sky-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(to bottom, #0c1938, #0c0e17, #000005);
            animation: starAnimation 10s linear infinite, twinkleAnimation 3s infinite;
        }

        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .star {
            position: absolute;
            width: 4px;
            height: 4px;
            background-color: #FFF;
            border-radius: 50%;
            animation: twinkleAnimation 1.5s infinite;
            opacity: 0.9;
        }

        .star:nth-child(1) {
            top: 10%;
            left: 20%;
        }

        .star:nth-child(2) {
            top: 30%;
            left: 60%;
        }

        .star:nth-child(3) {
            top: 15%;
            left: 85%;
        }

        .star:nth-child(4) {
            top: 5%;
            left: 50%;
        }

        .star:nth-child(5) {
            top: 35%;
            left: 70%;
        }

        .star:nth-child(6) {
            top: 25%;
            left: 40%;
        }

        .star:nth-child(7) {
            top: 50%;
            left: 30%;
        }

        @keyframes starAnimation {
            0% {
                background: linear-gradient(to bottom, #0c1938, #0c0e17, #000005);
            }

            100% {
                background: linear-gradient(to bottom, #0c1938, #0c0e17, #000005);
            }
        }

        @keyframes twinkleAnimation {

            0%,
            100% {
                opacity: 0.9;
            }

            50% {
                opacity: 0.7;
            }
        }
    </style>
</head>

<body>
    <div class="night-sky-animation">
        <div class="stars">
            <!-- Add more stars as needed -->
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
        </div>
    </div>
    <div class="container">
        <div class="login-container">
            <div class="login-tabs">
                <div class="tab active" data-tab="login">Login</div>
                <div class="tab" data-tab="signup">Sign up</div>
            </div>
            <div class="login-content">
                <div class="form login-form @if (!Session::has('register_failed')) active @endif" data-tab="login">
                    <h2>Login</h2>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        @error('email')
                            <p>{{ $message }}</p>
                        @enderror
                        <input type="text" name="email" placeholder="Email" />
                        @error('password')
                            <p>{{ $message }}</p>
                        @enderror
                        <input type="password" name="password" placeholder="Password" />
                        <button type="submit">Login</button>
                    </form>
                </div>
                <div class="form signup-form @if (Session::has('register_failed')) active @endif" data-tab="signup">
                    <h2>Sign up</h2>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        @error('name')
                            <p>{{ $message }}</p>
                        @enderror
                        <input type="text" name="name" placeholder="Name">
                        @error('email')
                            <p>{{ $message }}</p>
                        @enderror
                        <input type="email" name="email" placeholder="Email Address" />
                        @error('password')
                            <p>{{ $message }}</p>
                        @enderror
                        <input type="password" name="password" placeholder="Password" />
                        <input type="password" name="password_confirmation" placeholder="Password" />
                        <button type="submit">Sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".tab").click(function() {
                $(".tab").removeClass("active");
                $(this).addClass("active");
                var tab = $(this).data("tab");
                $(".form").removeClass("active");
                $(".form[data-tab='" + tab + "']").addClass("active");
                $('p').remove();
            });
        });
    </script>
</body>

</html>
