<x-dashboard>
    <x-slot:role>{{$user->role}} Dashboard</x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $links])
    </x-slot:links>
    <h1 class="capitalize text-3xl md:text-5xl text-center p-4">{{$user->election_officer->polling_station->name}} Polling Station</h1>
    <form action="{{route('store-voter')}}" enctype="multipart/form-data" method="post" enctype="multipart/form-data" class="mb-15 font-bold md:w-[1/2] lg:w-[45%] w-[90%] bg-white  rounded flex flex-col gap-3 m-auto p-8">
        @csrf
        <h2 class="text-2xl text-center font-bold py-2 text-primary">Register a new Voter</h2>
        <hr>
        <h3 class="text-primary font-bold">personal information</h3>
        Name <x-form-input name="name" class="border-2 border-primary" value="{{old('name')}}"></x-form-input>
        email <x-form-input type="email" name="email" class="border-2 border-primary" value="{{old('email')}}"></x-form-input>
        Gender <div class="ml-5">
            <input type="radio" name="gender" id="" value="male"> Male <br>
            <input type="radio" name="gender" id="" value="female"> Female
        </div>
        @error('gender')
        <p class="text-xs text-red-200">{{$message}}</p>
        @enderror
        Date of Birth <x-form-input type="date" max="2007-09-01" name="dob" class="border-2 border-primary" value="{{old('dob')}}"></x-form-input>
        Disability <div class="ml-5">
            <input type="radio" name="disability" id="" value="blind"> blind <br>
            <input type="radio" name="disability" value="amputee"> amputee <br>
            <input type="radio" checked name="disability" value="none" id=""> none
        </div>
        @error('disability')
        <p class="text-xs text-red-200">{{$message}}</p>
        @enderror
        <hr>
        <h3 class="text-primary font-bold">Address</h3>
        <div>
            Region <x-form-input name="region" autocomplete="off" id="region-search" class="border-2 border-primary" value="{{old('region')}}"></x-form-input>
            <nav id="region-suggestions" class="p-0 list-none absolute"></nav>
        </div>
        Zone <x-form-input name="zone" class="border-2 border-primary" value="{{old('zone')}}"></x-form-input>
        Woreda <x-form-input name="woreda" class="border-2 border-primary" value="{{old('woreda')}}"></x-form-input>
        Kebele <x-form-input name="kebele" class="border-2 border-primary" value="{{old('kebele')}}"></x-form-input>
        House number <x-form-input name="housenumber" class="border-2 border-primary" value="{{old('housenumber')}}"></x-form-input>
        Residency duration (years) <x-form-input type="number" min="1" name="duration" class="border-2 border-primary" value="{{old('duration')}}"></x-form-input>
        kebele id<x-form-input type="file" name="kebeleid"
            class="border-2 border-primary" value="{{old('id')}}"></x-form-input>
        <button class="bg-primary text-white font-bold p-2 md:p-4 rounded mt-4">Create User</button>
    </form>
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.dispatch('showSuccess', ['voter registered successfully!']);
        });
    </script>
    <livewire:modal />
    @endif
</x-dashboard>