<x-dashboard>
    <x-slot:role>
        {{$user->role}} Dashboard
    </x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $links])
    </x-slot:links>
    <section class="py-10">
        <form action="{{route('polling-station')}}" method="post" enctype="multipart/form-data" class="bg-white w-[95%] md:w-1/2 p-10 rounded m-auto">
            @csrf
            <h2 class="text-primary text-xl font-bold text-center mb-4">Add New Polling Stations</h2>
            <div class="border-2 border-primary  rounded p-8 w-full">
                <span class="capitalize font-bold block">Polling Station Name</span>
                <input type="text" autocomplete="off" name="pollingstation" id="polling-search" class="border-2 border-primary rounded p-1 w-full mb-2" />
                <nav id="polling-suggestions" class="p-0 list-none absolute"></nav>
                @error('pollingstation')
                <p class="text-xs text-black">{{$message}}</p>
                @enderror
                <span class="capitalize font-bold block">Constituency Name</span>
                <input type="text" autocomplete="off" name="constituency" id="constituency-search" class="border-2 border-primary rounded p-1 w-full mb-2">
                <nav id="constituency-suggestions" class="p-0 list-none absolute"></nav>
                @error('constituency')
                <p class="text-xs text-black">{{$message}}</p>
                @enderror
                <div class="flex items-center mt-2">
                    <div class="h-0.5 bg-[#00b6ba] text-center rounded-2xl grow"></div>
                    <p class="bg-white font-bold px-2">or</p>
                    <div class="h-0.5 bg-[#00b6ba] text-center rounded-2xl grow"></div>
                </div>
                <span class="capitalize font-bold block mt-2">Upload CSV file,containing all the data</span>
                <input type="file" dropzone="true" name="csvfile" class="text-primary border-2 border-primary rounded p-1 h-10 w-full mt-2">
                @error('csvfile')
                <p class="text-xs text-black">{{$message}}</p>
                @enderror
                <button class="bg-primary p-2 m-auto text-white w-full font-bold rounded block mt-4">ADD</button>
            </div>
        </form>
        <table id="dataTable" class="w-[75%] m-auto mt-5 text-center p-5 rounded">
            <thead>
                <tr class="bg-primary text-white">
                    <th class="py-2 px-4">Id</th>
                    <th class="py-2 px-4">Name</th>
                    <th class="py-2 px-4">Constituency Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stations as $station )
                <tr>
                    <td class="py-2 px-4">{{$station->id}}</td>
                    <td class="py-2 px-4">{{$station->name}}</td>
                    <td class="py-2 px-4">{{$station->constituency->name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            // Get references
            const table = document.getElementById('dataTable');
            const form = document.getElementById('editForm');

            // Click a table row to populate form
            table.addEventListener('click', function(e) {
                const targetRow = e.target.closest('tr');
                if (!targetRow || targetRow.parentNode.tagName === 'THEAD') return; // Ignore header row

                const cells = targetRow.children;
                document.getElementById('id').value = cells[0].textContent;
                document.getElementById('name').value = cells[1].textContent;
                document.getElementById('constituency').value = cells[2].textContent;
            });
        </script>
        <form action="{{route('polling-station')}}" id="editForm" method="post" enctype="multipart/form-data" class="bg-white w-[95%] md:w-1/2 mt-10 p-10 rounded m-auto">
            @csrf
            @method('put')
            <h2 class="text-primary text-xl font-bold text-center mb-4">Edit Polling Stations</h2>
            <div class="border-2 border-primary  rounded p-8 w-full">
                <input type="hidden" name="id" id="id">
                <span class="capitalize font-bold block">Polling Station Name</span>
                <input type="text" autocomplete="off" name="name" id="name" class="border-2 border-primary rounded p-1 w-full mb-2" />
                <nav id="polling-suggestions" class="p-0 list-none absolute"></nav>
                @error('name')
                <p class="text-xs text-black">{{$message}}</p>
                @enderror
                <span class="capitalize font-bold block">Constituency Name</span>
                <input type="text" autocomplete="off" name="constituency" id="constituency" class="border-2 border-primary rounded p-1 w-full mb-2">
                <nav id="constituency-suggestions" class="p-0 list-none absolute"></nav>
                @error('constituency')
                <p class="text-xs text-black">{{$message}}</p>
                @enderror
                <button class="bg-primary p-2 m-auto text-white w-full font-bold rounded block mt-4">Update</button>
            </div>
        </form>
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