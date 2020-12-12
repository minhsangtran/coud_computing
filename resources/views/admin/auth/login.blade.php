<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FoodOrder Admin | Login</title>

    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    <meta property="og:image" content="https://cdn0.iconfinder.com/data/icons/social-media-2092/100/social-35-512.png"/>
	<meta property="og:image:secure_url" content="https://cdn0.iconfinder.com/data/icons/social-media-2092/100/social-35-512.png" />

    <link rel="icon" href="{{ asset('homepage/img/sln_logo.png') }}"/>

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name" style="margin-left: -62px;">4Boys</h1>

            </div>
            <h3>Welcome to FoodOrder</h3>
            <p>Login</p>
            @if(session('error'))
                <p style="color: #ed5565;">
                    {{session('error')}}
              </p>
            @endif
            <form method="POST" class="m-t" role="form" action="">
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            </form>
            <a href="">Quên mật khẩu</a>
            <a href="/admin/register">Đăng kí</a>
            <p class="m-t"> <small>FoodOrder &copy; <a href="">vunquitk11@gmail.com</a> {{date('Y')}}</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('frontend/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>

</body>

</html>
