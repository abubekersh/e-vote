<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css'])
</head>

<body class=" w-screen body  p-8">
    <form method="post" action="/reset-password" class=" w-[40%] text-white  flex flex-col gap-5 py-4 px-8 bg-[#00b7ba6e]  border-white border-2 m-auto mt-15 h-[450px] rounded">
        @csrf
        <!-- <div class=""> -->
        <div class="flex flex-col justify-between">
            <h2 class="text-3xl text-center">Reset Password</h2>
        </div>
        <div class="">
            Email
            <input type="email" name="email" id="email" autofocus class="  min-w-full rounded border p-2 border-white outline-0 ">
            @error('email')
            <p class="text-xs">{{$message}}</p>
            @enderror
        </div>
        <div>
            Password
            <input type="password" name="password" id="email" class="min-w-full rounded border p-2 border-white outline-0 block">
            @error('password')
            <p class="text-xs">{{$message}}</p>
            @enderror
        </div>
        <div>
            Confirm Password
            <input type="password" name="password_confirmation" id="password_confirmation" class="min-w-full rounded border p-2 border-white outline-0 block">
            <a href="{{route('login')}}" class=" text-right underline text-xs  font-bold  rounded text-white hover:text-black">Back to Login</a>
        </div>
        <input type="hidden" name="token" value="{{$token}}">
        <button class="border p-3 w-[100%] bg-white text-primary rounded">Reset</button>
        <!-- </div> -->
    </form>
    <!-- <div class="h-screen bg-black/40">
    </div> -->
</body>

</html>