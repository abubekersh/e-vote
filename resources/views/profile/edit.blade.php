<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile {{$user->name}}</title>
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>

<body class="bg-[#f1eef6] p-4 mb-10">
    <div class="m-auto flex flex-row-reverse items-center justify-between border-b border-black/50 py-2">
        <a href="{{route('dashboard')}}" class="bg-primary p-2 text-white self-center rounded">Dashboard</a>
        <h1 class="font-bold">ET-VOTE</h1>
    </div>
    <div class="grid grid-cols-1  mt-5">
        @if ($user->role !== "admin")

        <form action="/profile/edit/{{$user->id}}" method="post" class="w-[90%] md:w-[70%] lg:w-[100%] m-auto bg-white p-6 mt-5 flex flex-col text-sm gap-2 rounded drop-shadow-sm">
            @csrf
            <div class="lg:w-1/2">
                <h2 class="text-left text-xl text-primary mb-3">Edit your Information</h2>
                Name <x-form-input type="text" name="name" id="name" class="border-2 border-primary" value="{{$user->name}}" />
                Email <x-form-input type="email" name="email" id="email" class="border-2 border-primary" value="{{$user->email}}" />
                <button class="font-bold p-3 bg-primary rounded text-white mt-2 cursor-pointer">Save</button>
            </div>
        </form>
        @endif
        <form action="/profile/changep/{{$user->id}}" method="post" class=" font-bold w-[90%] md:w-[70%] lg:w-[100%] m-auto   bg-white p-6 mt-5 flex flex-col text-sm gap-2 rounded drop-shadow-sm">
            @csrf
            <div class="lg:w-1/2">
                <h2 class="text-left mb-3 text-xl text-primary font-bold">Change password</h2>
                <div class="flex flex-col">Current password <x-form-input type=" password" name="cpass" id="cpass" class="text-black border-primary border-2" value="" /> <button type="button" class="self-end" onclick="togglePassword('cpass',this)">show</button></div>
                <div class="flex flex-col">New Password <x-form-input type="password" name="newpass" id="newpass" class="border-primary border-2" /> <button type="button" class="self-end" onclick="togglePassword('newpass',this)">show</button></div>
                <div class="flex flex-col">Confirm New password <x-form-input type="password" name="newpass_confirmation" id="passcon" class="border-primary border-2" /> <button type="button" class="self-end" onclick="togglePassword('passcon',this)">show</button></div>
                <button class="font-bold p-3 bg-primary rounded text-white mt-2  cursor-pointer">Save</button>
            </div>
        </form>
    </div>
    <script>
        function togglePassword(ab, btn) {
            var x = document.getElementById(ab);
            if (x.type === "password") {
                x.type = "text";
                btn.innerText = "hide"
            } else {
                x.type = "password";
                btn.innerText = "show"
            }

        }
    </script>
    @livewireScripts
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.dispatch('showSuccess', ['data updated successfully!']);
        });
    </script>
    <livewire:modal />
    @endif
</body>

</html>