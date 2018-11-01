
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>STIE</title>

    <link href="{{ asset('templates/inspinia_271/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('templates/inspinia_271/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('templates/inspinia_271/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('templates/inspinia_271/css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div style="" class="">
            <div class="b-r-xl">
                <img class="" style="width: 70%; height: 250px" src="{{ url('templates/img/logo.png') }}" alt="">
                
            </div>
            <form class="m-t" role="form" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                @csrf
                <div class="form-group">

                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Username" name="username" value="{{ old('username') }}" required autofocus>

                    @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert">
                        {{-- <strong>{{ $errors->first('username') }}</strong> --}}
                        <strong>{{ 'Username atau password salah' }}</strong>
                    </span>
                    @endif

                </div>
                <div class="form-group">

                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="password" name="password" required>

                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif

                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('templates/inspinia_271/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('templates/inspinia_271/js/bootstrap.min.js') }}"></script>

</body>

</html>
