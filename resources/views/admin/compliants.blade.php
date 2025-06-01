<x-dashboard>
    <x-slot:role>{{$user->role}} Dashboard</x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $db])
    </x-slot:links>
    <section class="pb-16 pt-4 px-4 min-h-screen">
        <h2 class="text-2xl text-center font-bold pb-4">Compliants from system users</h2>
        <div class="mb-4 grid grid-cols-1 gap-5 z-0">
            @foreach ($complaints as $complaint )
            <div class="bg-[#f1eef6] overflow-hidden w-[85%] m-auto  border border-primary px-5 py-8 rounded flex flex-col  gap-2 mt-4 drop-shadow-lg">
                <p class="text-center text-3xl font-bold">{{$complaint->type}}</p>
                <p class="break-words whitespace-normal text-black min-w-0">Description: {{$complaint->description}}</p>
                <p>Status: <span class="font-bold">{{$complaint->status}}</span> </p>
                <p class="text-green-400 font-bold">Submitted By:{{$complaint->email}}</p>
                <button onclick="showResolveConfirmation('{{$complaint->id}}')" class="p-2 bg-green-500 w-1/2 m-auto text-white rounded cursor-pointer">Resolve</button>
            </div>
            @endforeach
        </div>

        {{$complaints->links()}}
        <script>
            function showResolveConfirmation(itemId) {
                Livewire.dispatch('showConfirm', ['Are you sure you want to resolve this?', 'resolveItem', itemId]);
            }
        </script>
        <livewire:modal />
    </section>
</x-dashboard>