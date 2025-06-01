<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="{{asset('build/assets/app-qeP0oCGw.css')}}"> -->
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>

<body>
    @livewireScripts
    <main class="min-h-screen flex  bg-[#f1eef6] text-black/10">
        <section id="dashboard" class=" absolute md:relative top-0 left-0 overflow-hidden bg-[#f1eef6] border-r w-0 transition-display duration-1500 min-h-screen z-50">
            <div class="flex justify-end p-3">
                <img onclick="viewdash(false)" src=" /images/close.svg" class="text-right" alt="" width="20px">
            </div>
            <nav class="dashboard  text-black text-4xl px-4">
                <ul class="flex flex-col gap-8 text-center  w-full capitalize">
                    {{$links}}
                </ul>
            </nav>
        </section>
        <script>
            const dashb = document.getElementById('dashboard');

            function viewdash(value) {
                if (!value) {
                    dashb.classList.remove("w-full", "md:w-1/4");
                    dashb.classList.add("w-0");
                } else {
                    dashb.classList.remove("w-0");
                    dashb.classList.add("w-full", "md:w-1/4");
                }
            }
        </script>
        <section class="grow max-w-screen min-h-screen text-black">
            <header class="flex justify-between text-xs w-full md:text-sm font-bold p-3 bg-black/90 text-white">
                <h1 onclick="viewdash(true)" class=" px-4 py-2 rounded flex gap-1 items-center"><img src="/images/burger-menu.svg" width="25px" alt="">Dashboard</h1>
                @php
                $name = explode(" ",Auth::user()->name)
                @endphp
                <a href="/edit-profile" class="font-bold bg-primary  p-3 border-2 border-white  self-center rounded-4xl capitalize bg-purple-600">{{strtoupper(substr($name[0], 0, 1))}}{{strtoupper(substr($name[1], 0, 1))}}</a>
            </header>
            {{$slot}}
        </section>
    </main>
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.dispatch('showSuccess', ['data updated successfully!']);
        });
    </script>
    @endif
</body>

</html>