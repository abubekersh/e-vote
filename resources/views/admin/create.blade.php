<x-dashboard>
    <x-slot:role>{{$user->role}} DashBoard</x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $db])
    </x-slot:links>
    <section class="bg-[#f1eef6] py-5 min-h-screen">
        <form action="{{route('create-user')}}" method="post" class="font-bold md:w-[1/2] lg:w-[45%] w-[90%] bg-white  rounded flex flex-col gap-3 m-auto p-8">
            @csrf
            <a href="{{route('manage-users')}}" class="text-white text-sm font-bold bg-primary inline w-fit py-1 px-4 rounded">back</a>
            <h2 onclick="showDn()" class="text-2xl text-center font-bold py-2 text-primary">Create a new User</h2>
            Name <x-form-input name="name" class="border-2 border-primary" value="{{old('name')}}"></x-form-input>
            Email <x-form-input name="email" class="border-2 border-primary" value="{{old('email')}}"></x-form-input>
            Password Generator
            <div class="flex flex-col">
                <x-form-input name="password" class="border-2 border-primary" id="pinput" value="{{old('password')}}"></x-form-input>
                <script>
                    function random() {
                        let randomStr = (Math.random() + 1).toString(36).substring(4);

                        // Generate a random uppercase letter (A-Z)
                        let uppercaseLetter = String.fromCharCode(65 + Math.floor(Math.random() * 26));

                        // Define a set of special characters
                        let specialChars = "!@#$%^&*()_+-=[]{}|;:'\",.<>?/";
                        let specialChar = specialChars[Math.floor(Math.random() * specialChars.length)];

                        // Insert the uppercase letter at a random position
                        let positionUpper = Math.floor(Math.random() * (randomStr.length + 1));
                        randomStr = randomStr.slice(0, positionUpper) + uppercaseLetter + randomStr.slice(positionUpper);

                        // Insert the special character at a different random position
                        let positionSpecial = Math.floor(Math.random() * (randomStr.length + 1));
                        r = randomStr.slice(0, positionSpecial) + specialChar + randomStr.slice(positionSpecial);
                        document.getElementById('pinput').value = r;
                    }
                </script>
                <button type="button" class="p-2 mt-1 text-left self-end bg-primary text-white px-2 rounded" onclick="random()">Generate</button>
            </div>
            <div class="flex gap-5 items-center py-2">
                Role
                <select name="role" id="role" class="outline-0  border-2 border-primary rounded p-1 text-black bg-white">
                    <!-- <option value="admin">System Adminstrator</option> -->
                    <option value="managment" @selected(old('role')=='managment' )>Managment Board Member</option>
                    <option value="election admin" @selected(old('role')=="election admin" )>Election Adminstrator</option>
                    <option value="election officer" @selected(old('role')=='election officer' )>Election Officer</option>
                </select>
            </div>
            <div id="eadmin" class="hidden">constituency <x-form-input name="constituency" autocomplete="off" class="border-2 border-primary" id="constituency-search" value="{{old('constituency')}}" />
                <nav id="constituency-suggestions" class="p-0 list-none absolute"></nav>
            </div>
            <div id="eofficer" class="hidden">Polling station <x-form-input name="polling_station" autocomplete="off" class="border-2 border-primary" id="polling-search" value="{{old('polling station')}}" />
                <nav id="polling-suggestions" class="p-0 list-none absolute"></nav>
            </div>
            <script>
                const role = document.getElementById('role');
                const admin = document.getElementById('eadmin');
                const officer = document.getElementById('eofficer');
                window.addEventListener('load', function() {
                    admin.style.display = "none"
                    officer.style.display = "none"
                    if (role.value == "election admin") {
                        admin.style.display = "block"
                    } else if (role.value == "election officer") {
                        officer.style.display = "block"
                    } else {
                        officer.style.display = "none"
                        admin.style.display = "none"
                    }
                });
                role.addEventListener('change', hidenshow);

                function hidenshow() {
                    admin.style.display = "none"
                    officer.style.display = "none"
                    if (this.value == "election admin") {
                        admin.style.display = "block"
                    } else if (this.value == "election officer") {
                        officer.style.display = "block"
                    } else {
                        officer.style.display = "none"
                        admin.style.display = "none"
                    }
                }
            </script>
            <button class="bg-primary text-white font-bold p-2 md:p-4 rounded mt-4">Create User</button>
        </form>
        @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Livewire.dispatch('showSuccess', ['user created successfully!']);
            });
            window.addEventListener('force-refresh', () => {
                console.log('Browser event says reload!');
                window.location.reload();
            });
        </script>
        <livewire:modal />
        @endif
    </section>
</x-dashboard>