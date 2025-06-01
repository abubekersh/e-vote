<x-dashboard>
    <x-slot:role>{{$user->role}} DashBoard</x-slot:role>
    <x-slot:links>
        <a href="{{route('home')}}">
            <li>home</li>
        </a>
        @foreach ($db as $link )
        <a href="{{route($link)}}" class="{{request()->is('*/'.$link) ? 'bg-[#6b54a5]':''}}">
            <li>{{$link}}</li>
        </a>
        @endforeach
        <form action="{{route('logout')}}" method="post">
            @csrf
            <button>logout</button>
        </form>
    </x-slot:links>
    <section class="py-5 bg-[#f1eef6]">
        <form action="{{route('update-user')}}" method="post" class="font-bold md:w-[1/2] lg:w-[45%] w-[90%] bg-white text-black rounded flex flex-col gap-3 m-auto p-8">
            @method('put')
            @csrf
            <a href="{{route('manage-users')}}" class="text-white text-sm font-bold bg-primary inline w-fit py-1 px-4 rounded">back</a>
            <h2 class="text-2xl text-center text-primary font-bold py-2">Edit User Data</h2>
            <input type="hidden" name="id" value="{{$user->id}}">
            Name <x-form-input name="name" class="border-2 border-primary" value="{{$user->name}}"></x-form-input>
            Email <x-form-input name="email" class="border-2 border-primary" value="{{$user->email}}"></x-form-input>
            <div class="flex gap-5 items-center py-2">
                Role
                <select name="role" id="role" class=" rounded p-1 text-black bg-white border-2 border-primary outline-0">
                    <option value="managment" {{$user->role==='managment'?'selected':''}}>Managment Board Member</option>
                    <option value="election admin" {{$user->role==='election admin'?'selected':''}}>Election Adminstrator</option>
                    <option value="election officer" {{$user->role==='election officer'?'selected':''}}>Election Officer</option>
                </select>
            </div>

            <div id="eadmin" class="{{$user->role ==='election admin'?'':'hidden'}}">constituency <x-form-input name="constituency" autocomplete="off" class="border-2 border-primary" id="constituency-search" value="{{$user->role == 'election admin'?$user->election_admin->constituency->name:''}}" />
                <nav id="constituency-suggestions" class="p-0 list-none absolute"></nav>
            </div>
            <div id="eofficer" class="{{$user->role ==='election officer'?'':'hidden'}}">Polling station <x-form-input name="polling_station" autocomplete="off" class="border-2 border-primary" id="polling-search" value="{{$user->role == 'election officer'?$user->election_officer->polling_station->name:''}}" />
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
            <button class="bg-primary text-white font-bold p-2 md:p-4 rounded mt-4">Update</button>
        </form>
        @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Livewire.dispatch('showSuccess', ['data updated successfully!']);
            });
        </script>
        <livewire:modal />
        @endif
    </section>
</x-dashboard>