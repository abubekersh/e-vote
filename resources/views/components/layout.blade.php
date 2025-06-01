<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Test</title>
    <link rel="stylesheet" href="{{asset('build/assets/app-BIItFjOq.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style src="{{@asset('build/assets/app-Ch8D-_oc.js')}}"></style>
    <!-- @assets('build/assets/app-Ch8D-_oc.js') -->
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>

<body class="body">
    <nav id="nav" class="hidden   h-screen bg-[#00b7bacb] z-auto fixed top-0 w-full text-center md:text-left py-16 px-10 md:py-15 md:px-32 md:text-4xl text-4xl">
        <ul class="flex flex-col gap-10 ">
            <a href="/">
                <li>Home</li>
            </a>
            @auth
            <a href="{{route('dashboard')}}">
                <li>Dashboard</li>
            </a>
            @endauth
            <a href="/vote">
                <li>Vote</li>
            </a>
            <a href="/results">
                <li>Results</li>
            </a>
            <a href="{{route('complaint')}}">
                <li>I have an issue</li>
            </a>
            @auth
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button>
                    {{'Logout'}}
                </button>
            </form>
            @endauth
            @guest
            <a href="{{route('login')}}">
                <li>Sign In</li>
            </a>
            @endguest
        </ul>
    </nav>
    <header class="flex flex-row-reverse md:flex-row  justify-between  items-center p-2 md:p-4 bg-gray-900/20">
        <script>
            let isOpen = false;
            nav = document.getElementById("nav");
            icon = document.getElementById('icon');

            function show() {
                if (!isOpen) {
                    nav.style.display = "block"
                    document.getElementById('icon').src = "/images/close.svg";

                    isOpen = true;
                } else {
                    nav.style.display = "none";
                    document.getElementById('icon').src = "/images/burger-menu.svg";
                    isOpen = false;

                }
            }
        </script>
        <button id="menu" onclick="show()" class="z-50 flex items-center gap-2 text-md">
            <img
                id="icon"
                src="/images/burger-menu.svg"
                alt=""
                class="w-8 md:w-10" />
        </button>
        <div class="mr-auto md:m-auto">
            <a href="{{route('home')}}">
                <h1 class="text-white text-lg md:text-2xl font-bold">ET-VOTE</h1>
            </a>
        </div>
        @guest
        <a class="btn" href="{{request()->is('vote') ?'/':'/vote'}}">
            {{request()->is('vote') ?'Back':'Vote'}}
        </a>
        @endguest
        @auth
        <form action="{{route('logout')}}" method="post">
            @csrf
            <button class="btn">
                {{'Logout'}}
            </button>
        </form>
        @endauth
    </header>
    <main class="mt-10">
        {{$slot}}
    </main>
    @if (request()->uri()->path()!=='login')
    <footer class="grid grid-cols-1 md:grid-cols-5 bg-black/25 text-white md:p-10 p-4">
        <div class="text-2xl font-bold text-center md:mt-10 capitalize">
            National election board of ethiopia
        </div>
        <div class="text-center">
            <p class="pt-5">This website is for the national election board of ethiopian election which is held every five years in the country</p>
            <p>This website got anything you want regarding this year election and voters can vote here</p>
        </div>
        <div class="text-center">
            <h3 class="font-bold text-2xl pt-4">Links</h3>
            <ul class="p-4 text-sm">
                <li><a href="/vote">Vote</a></li>
                <li><a href="/complaint">Complaint</a></li>
                <li><a href="/results">Results</a></li>
                <li><a href="/login">Sign In</a></li>
            </ul>
        </div>
        <div class="text-center">
            <h3 class="font-bold text-2xl pt-4">Contact Us</h3>
            <ul class="p-4 text-sm">
                <li><a href="https://www.facebook.com/National-Electoral-Board-of-Ethiopia-NEBE-%E1%8B%A8%E1%8A%A2%E1%89%B5%E1%8B%AE%E1%8C%B5%E1%8B%AB-%E1%89%A5%E1%88%94%E1%88%AB%E1%8B%8A-%E1%88%9D%E1%88%AD%E1%8C%AB-%E1%89%A6%E1%88%AD%E1%8B%B5-414693405979601/">Facebook</a></li>
                <li><a href="https://www.linkedin.com/company/nebe-et">LinkedIN</a></li>
                <li><a href="https://nebe.org.et/">Website</a></li>
                <li><a href="mailto:contact@nebe.org.et">Email</a></li>
            </ul>
        </div>
        <div class="text-center">
            <p class="pt-4 font-bold">Developed By</p>
            <ul class="text-sm flex gap-4 justify-center">
                <li>Abubeker</li>
                <li>Hussen</li>
                <li>Kedija</li>
                <li>jemila</li>
            </ul>
            <p class="mt-5">April 2025<sup>&copy;</sup></p>
        </div>
        @livewireScripts
    </footer>
    @endif
    @php
    $ms = session('success');
    @endphp
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.dispatch('showSuccess', [@json($ms)]);
        });
    </script>
    <livewire:modal />
    @endif
</body>

</html>