<x-dashboard>
    <x-slot:role>
        {{$user->role}} Dashboard
    </x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $links])
    </x-slot:links>
    <section class="py-10">
        <form action="{{route('political-parties')}}" method="post" enctype="multipart/form-data" class="bg-white w-[95%] md:w-1/2 p-10 rounded m-auto">
            @csrf
            <h2 class="text-primary text-xl font-bold text-center mb-4">Add New Political Parties</h2>
            <div class="border-2 border-primary  rounded p-8 w-full">
                <span class="capitalize font-bold block">Party Name</span>
                <input type="text" id="name" name="name" class="border-2 border-primary rounded p-1 w-full mb-2">
                @error('name')
                <p class="text-xs text-black">{{$message}}</p>
                @enderror
                <span class="capitalize font-bold block mt-2">Party Symbol,perferable format '.PNG'</span>
                <input type="file" dropzone="true" name="symbol" class="text-primary border-2 border-primary rounded p-1 h-10 w-full mt-2">
                @error('symbol')
                <p class="text-xs text-black">{{$message}}</p>
                @enderror
                <button class="bg-primary p-2 m-auto text-white w-full font-bold rounded block mt-4">ADD</button>
            </div>
        </form>
        <div class="grid grid-cols-1  sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 p-6">
            @foreach ($parties as $party)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-4 flex flex-col items-center">
                <img src="/storage/{{ $party->symbol }}" alt="Party Symbol" class="w-20 object-cover rounded-lg mb-4">
                <h2 class="text-xl font-bold mb-2 text-center">{{ $party->name }}</h2>
                <div class="flex gap-3 mt-auto">
                    <a id=""
                        class="edit-btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition" data-name="{{$party->name}}">
                        Edit
                    </a>
                    <form action="/managment/political-parties" method="post" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{$party->id}}">
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
            <script>
                document.querySelectorAll('.edit-btn').forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault(); // Prevent default link behavior

                        const name = this.dataset.name;

                        // Now populate your form (adjust selector based on your form input)
                        document.getElementById('name').value = name;
                    });
                });
            </script>
        </div>

    </section>
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.dispatch('showSuccess', ["{{session('success')}}"]);
        });
    </script>
    <livewire:modal />
    @endif
</x-dashboard>