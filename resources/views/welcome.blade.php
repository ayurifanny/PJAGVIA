<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Open Sans', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .top-left {
                position: absolute;
                left: 12%;
                top: 7%;
            }

            .top-right {
                position: absolute;
                right: 10%;
                top: 7%;
            }

            .links > a {
                color: rgba(255, 255, 255, 0.75);
                padding: 0 25px;
                font-size: 15px;
                font-weight: 500;
                letter-spacing: .1rem;
                text-decoration: none;
            }

            .links > a:hover,
            .links > a:focus {
                color: rgba(255, 255, 255, 0.9);
            }
        </style>
    </head>
    <body>
        <div class="view" style="background-image:url('http://www.pjagroup.com/wp-content/uploads/2019/06/large-bg-plumbing.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">     
            <div class="content flex-center full-height">
                @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif

                <div class="top-left links">
                    <a class="mr-4" href="/">
                        <img width="110" height="45" class="d-inline-block align-top"  src = "http://www.pjagroup.com/wp-content/uploads/2019/06/PJA-logo.png" alt="">
                    </a>
                </div>  

                <div class="row w-75 mt-5 pt-5">
                    <div class="col">  
                        <h1 class="text-white font-weight-bolder"><strong>
                            PJA Group Virtual Inspection App</strong>
                        </h1>
                    </div>

                    <div class="mx-auto col-6">
                        <div class="card px-3 py-3">
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group justify-content-center">
                                        <label for="email"><strong>{{ __('E-Mail Address') }}</strong></label>

                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">{{ __('Password') }}</label>
                                        
                                        <span class="float-right">
                                            @if (Route::has('password.request'))
                                                <a class="label-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </span>
                                            
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row mb-5">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <button type="submit" class="btn btn-lg btn-block btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
