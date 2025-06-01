<x-dashboard>
    <x-slot:role>{{$user->role}} Dashboard</x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $db])
    </x-slot:links>
    <section class="pb-16 pt-4 px-4 min-h-screen">
        <p class="text-center text-2xl mb-5">System Action Logs</p>
        <div class="mb-4">
            @foreach ($users as $suser )
            <div class="bg-[#f1eef6] overflow-hidden md:hidden border border-primary px-4 py-4 rounded flex flex-col gap-2 mt-4 drop-shadow-lg">
                <p class="text-green-400 font-bold text-right">{{$suser->id}}</p>
                <p class="text-center text-2xl font-bold">Action: {{$suser->name}}</p>
                <p>Action By: <span class="font-bold">{{$suser->role}}</span> </p>
                <p>Date: <span class="font-bold">{{$suser->email}}</span> </p>
            </div>
            @endforeach
        </div>
        <table class=" bg-white mt-5 mb-4 min-w-[90%] max-w-full  m-auto  md:table hidden text-center">
            <thead>
                <td>ID</td>
                <td>Action By</td>
                <td>Action</td>
                <td>date</td>
            </thead>
            <tbody>
                @foreach ($users as $suser )
                <tr>
                    <td class="p-3">{{$suser->id}}</td>
                    <td>{{$suser->name}}</td>
                    <td>{{$suser->email}}</td>
                    <td>{{$suser->role}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        {{$users->links()}}
        <script>
            function showDeleteConfirmation(itemId) {
                Livewire.dispatch('showConfirm', ['Are you sure you want to delete this?', 'deleteItem', itemId]);
            }
        </script>
        <livewire:modal />
    </section>
</x-dashboard>