<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bank Project</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-gradient-to-br from-orange-100 via-neutral-300 to-orange-200">
<div class="py-4" style="width: 50%; margin: auto; margin-top: 20px">
    <div class="content-center">
        <div
            class="rounded-md width-40 border-2 bg-white px-4 py-4 shadow-md transition transform duration-200 text-center content-center">
            <div class="flex-col justify-start">
                <div class="pb-2">
                    <div>
                        <div style="display: flex; justify-content: center;">
                            <img style="height: 16%;width: 16%; margin-bottom: -6%"
                                 src="https://raw.githubusercontent.com/nkuprevics/Screenshots/d2f78326ad8943c422b9170724679f950f2ce1c0/banking-bank-svgrepo-com.svg">
                        </div>
                        <br><br>
                        <div style="padding-bottom: 10px; font-size:25px ;display: flex; justify-content: center;">
                            <a> CryptoBank </a>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row mb-3 pt-2 pb-2">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                                <div class="col-md-6 pt-2 pb-2">
                                    <input id="email" type="email"
                                           class="text-center text-md align-content-center px-3 py-2 rounded-lg w-60 h-8 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md
        focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="text-center text-md align-content-center px-3 py-2 rounded-lg w-60 h-8 bg-white border-2 border-gray-300 placeholder-gray-600 shadow-md
        focus:placeholder-gray-500 focus:bg-white focus:border-gray-600 focus:outline-none form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit"
                                            class="mr-2 my-1 uppercase tracking-wider px-2 text-amber-600 border-amber-600 hover:bg-amber-600
                                             hover:text-white border text-sm font-semibold rounded py-1 transition transform duration-200 cursor-pointer">
                                        {{ __('Login') }}
                                    </button>
                                    <a href="{{ route('register') }}"
                                       class="mr-2 my-1 uppercase tracking-wider px-2 text-amber-600 border-amber-600 hover:bg-amber-600 hover:text-white border text-sm font-semibold rounded py-1 transition transform duration-200 cursor-pointer">
                                        Register</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
