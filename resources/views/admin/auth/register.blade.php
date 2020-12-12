<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FoodOrder Admin | Register</title>

    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    <meta property="og:image" content="https://cdn0.iconfinder.com/data/icons/social-media-2092/100/social-35-512.png"/>
	<meta property="og:image:secure_url" content="https://cdn0.iconfinder.com/data/icons/social-media-2092/100/social-35-512.png" />

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name" style="margin-left: -62px;">4Boys</h1>
            </div>
            <h3>Welcome to FoodOrder</h3>
            <p>Register</p>
            <form method="POST" class="m-t" role="form"  action="">
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" name="name" required="">
                </div>
                <div class="form-group">
                    @if(session('error'))
                        <p style="color: #ed5565;">
                            {{session('error')}}
                      </p>
                    @endif
                    <input type="email" class="form-control" placeholder="Email" name="email" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="/admin/login">Login</a>
            </form>
            <p class="m-t"> <small>Fanscom &copy; <a href="">vunquitk11@gmail.com</a> {{date('Y')}}</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('frontend/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('frontend/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>

</html>
