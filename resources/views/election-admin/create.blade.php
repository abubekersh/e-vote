<x-dashboard>
    <x-slot:role>{{$user->role}} Dashboard</x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $links])
    </x-slot:links>
    <h1 class="capitalize text-3xl md:text-5xl text-center p-4">{{$user->election_admin->constituency->name}} constituency</h1>
    <form action="{{route('store-candidate')}}" method="post" enctype="multipart/form-data" class="font-bold md:w-[1/2] lg:w-[45%] w-[90%] bg-white  rounded flex flex-col gap-3 m-auto p-8">
        @csrf
        <h2 onclick="showDn()" class="text-2xl text-center font-bold py-2 text-primary">Add a new Candidate</h2>
        Name <x-form-input name="name" class="border-2 border-primary" value="{{old('name')}}"></x-form-input>

        <div class="flex gap-5 items-center py-2">
            Candidate Type
            <select name="type" id="type" class="outline-0  border-2 border-primary rounded p-1 text-black bg-white">
                <!-- <option value="admin">System Adminstrator</option> -->
                <option value="individual" @selected(old('type')=='individual' )>Individual</option>
                <option value="party" @selected(old('type')=="party" )>Political Party</option>
            </select>
        </div>
        <div id="pname" class="">party name<x-form-input name="party" class="border-2 border-primary" id="party" value="{{old('constituency')}}" /></div>
        <div id="symbol">
            <span class="capitalize font-bold block mt-2">Symbol,perferable format '.PNG'</span>
            <input type="file" dropzone="true" name="symbol" class="text-primary border-2 border-primary rounded p-1 h-10 w-full mt-2">
            @error('symbol')
            <p class="text-xs text-black">{{$message}}</p>
            @enderror
        </div>
        <div id="picture">
            <span class="capitalize font-bold block mt-2">Picture of the candidate,perferable format '.jpg'</span>
            <input type="file" dropzone="true" name="picture" class="text-primary border-2 border-primary rounded p-1 h-10 w-full mt-2">
            @error('symbol')
            <p class="text-xs text-black">{{$message}}</p>
            @enderror
        </div>
        <script>
            const type = document.getElementById('type');
            const party = document.getElementById('pname');
            const symbol = document.getElementById('symbol');
            window.addEventListener('load', function() {
                party.style.display = "none"
                symbol.classList.remove('hidden');
                if (type.value == "party") {
                    party.style.display = "block";
                    symbol.classList.add("hidden");
                } else {
                    party.style.display = "none"
                    symbol.classList.remove('hidden');
                }
            });
            type.addEventListener('change', hidenshow);

            function hidenshow() {
                party.style.display = "none"
                symbol.classList.remove('hidden');
                if (this.value == "party") {
                    party.style.display = "block"
                    symbol.classList.add("hidden");
                } else {
                    symbol.classList.remove('hidden');
                    party.style.display = "none"
                }
            }
        </script>
        <button class="bg-primary text-white font-bold p-2 md:p-4 rounded mt-4">Create User</button>
    </form>
    <h2 class="text-2xl text-center font-bold m-10">Candidates in {{Auth::user()->election_admin->constituency->name}} constitiency</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 p-4">
        @foreach ($candidates as $candidate)
        <div class="bg-white shadow rounded-xl p-4 flex flex-col items-center text-center relative group">

            <img src="{{ asset('storage/' . $candidate->picture) }}"
                alt="Candidate Photo"
                class="w-24 h-24 rounded-full object-cover mb-3 border">

            <h3 class="text-lg font-semibold">{{ $candidate->name }}</h3>

            <p class="text-sm text-gray-500">
                {{ $candidate->political_party_id ? $candidate->politicalParty->name : 'Independent' }}
            </p>

            @if ($candidate->symbol)
            <img src="/storage/{{$candidate->symbol}}"
                alt="Candidate Symbol"
                class="w-12 h-12 mt-3 object-contain">
            @else
            <img src="/storage/{{$candidate->politicalParty->symbol}}"
                alt="Candidate Symbol"
                class="w-12 h-12 mt-3 object-contain">
            @endif

            <!-- Action Buttons -->
            <div class="mt-auto">
                <form action="" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this candidate?');">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{$candidate->id}}">
                    <button type="submit"
                        class="bg-red-500 mt-4 text-white text-sm px-3 py-1 rounded hover:bg-red-600 transition">
                        Remove
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @php
    $s = session('success');
    @endphp
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.dispatch('showSuccess', [@json($s)]);
        });
    </script>
    <livewire:modal />
    @endif
</x-dashboard>