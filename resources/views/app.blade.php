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
    <!-- Styles -->

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        #view {
            min-height: 100vh;
        }

        .h-full {
            min-height: 100%;
            height: 100%;
        }
    </style>
</head>
<!-- component -->
<body class="font-poppins">
<div id="view" class="w-screen h-screen h-full flex flex-row bg-gradient-to-br from-orange-100 via-neutral-300 to-orange-200">
    <div id="sidebar"
         class="bg-white md:block shadow-xl px-3 w-30 md:w-60 lg:w-60transition-transform duration-300 ease-in-out"
         x-show="sidenav" @click.away="sidenav = false">
        <div style="width: 80%; margin: auto;">
            <div id="menu" class="flex flex-col space-y-2">
                <br>
                <a href="/accounts">
                <div style="display: flex; justify-content: center;">
                    <img style="height: 55%;width: 55%; margin-bottom: -20%"
                         src="https://raw.githubusercontent.com/nkuprevics/Screenshots/d2f78326ad8943c422b9170724679f950f2ce1c0/banking-bank-svgrepo-com.svg">
                </div>
                </a>

                <br><br>
                <div style="padding-bottom: 10px; font-size:25px ;display: flex; justify-content: center;">
                    <a href="/accounts"> CryptoBank </a>
                </div>
                <div>
                    <p class="text-xs text-gray-500 text-center">Logged in as</p>
                    <h2 class="font-medium text-xs md:text-sm text-center text-amber-600">
                        {{ Auth::user()->name }} {{ Auth::user()->lname }}
                    </h2>
                </div>
                <br><br>

                <a href="/accounts"
                   class="text-sm font-medium text-gray-700 py-2 px-2
   {{ (Request::routeIs('accounts') || Request::routeIs('editCard', 'editCard/*'))  ? 'bg-amber-600 text-white text-base' : 'hover:bg-amber-600 hover:text-white hover:text-base' }}
   rounded-md transition duration-150 ease-in-out">
                    <img src="https://icons.iconarchive.com/icons/iconsmind/outline/128/ID-Card-icon.png" class="inline-block w-5 h-5 mr-2"/>
                    <span class="">Accounts</span>
                </a>


                <a href="/transfer"
                   class="text-sm font-medium text-gray-700 py-2 px-2 {{ Request::is('transfer') ? 'bg-amber-600 text-white text-base' : 'hover:bg-amber-600 hover:text-white hover:text-base' }} rounded-md transition duration-150 ease-in-out">
                    <img src="https://icons.iconarchive.com/icons/iconsmind/outline/128/Left-Right-3-icon.png" class="inline-block w-5 h-5 mr-2"/>
                    <span class="">Transfer Money</span>
                </a>
                <a href="/history"
                   class="text-sm font-medium text-gray-700 py-2 px-2 {{ Request::is('history') ? 'bg-amber-600 text-white text-base' : 'hover:bg-amber-600 hover:text-white hover:text-base' }} rounded-md transition duration-150 ease-in-out">
                    <img src="https://icons.iconarchive.com/icons/icons8/ios7/128/Cinema-History-icon.png" class="inline-block w-5 h-5 mr-2"/>
                    <span class="">Transfer history</span>
                </a>

                <br>


                <a href="/cryptoHome"
                   class="text-sm font-medium text-gray-700 py-2 px-2 {{ Request::is('cryptoHome') ? 'bg-amber-600 text-white text-base' : 'hover:bg-amber-600 hover:text-white hover:text-base' }} rounded-md transition duration-150 ease-in-out">
                    <img src="https://icons.iconarchive.com/icons/iconsmind/outline/128/Coin-icon.png" class="inline-block w-5 h-5 mr-2"/>
                    <span class="">Crypto Home</span>
                </a>
                <a href="/cryptoHistory"
                   class="text-sm font-medium text-gray-700 py-2 px-2 {{ Request::is('cryptoHistory') ? 'bg-amber-600 text-white text-base' : 'hover:bg-amber-600 hover:text-white hover:text-base' }} rounded-md transition duration-150 ease-in-out">
                    <img src="https://icons.iconarchive.com/icons/icons8/ios7/128/Cinema-History-icon.png" class="inline-block w-5 h-5 mr-2"/>
                    <span class="">Crypto History</span>
                </a>
                <br>
                <a class="text-sm font-medium text-gray-700 py-2 px-2 hover:bg-amber-600 hover:text-white hover:text-base rounded-md transition duration-150 ease-in-out"
                   href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <img src="https://icons.iconarchive.com/icons/iconsmind/outline/128/Delete-Window-icon.png" class="inline-block w-5 h-5 mr-2"/>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <main class="py-4" style="width: 50%; margin: auto; margin-top: 20px">
        @yield('content')
    </main>

</div>
</body>

<script>
    const container = document.getElementById("view");
    if (container.scrollHeight > container.clientHeight) {
        container.classList.add("h-full");
    }
</script>

</html>
