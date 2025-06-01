<x-dashboard>
    <x-slot:role>{{$user->role}} Dashboard</x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $db])
    </x-slot:links>
    <section class="pb-16 pt-4 px-4 min-h-screen">
        <a href="{{route('create-user')}}">
            <div class="md:w-[90%] w-full bg-white text-center font-bold  m-auto text-xs md:text-xl md:p-1  rounded text-primary">
                <span class="text-2xl" title="add new user">+</span>
                <!-- <p>new user</p> -->
            </div>
        </a>
        <div class="mb-4">
            @foreach ($users as $suser )
            <div class="{{$suser->deleted_at?'bg-[#d9ceeb] text-black/25':'bg-[#f1eef6] text-black'}} overflow-hidden lg:hidden border border-primary px-4 py-2 rounded flex flex-col gap-2 mt-4 drop-shadow-lg">
                <p class="text-green-400 font-bold text-right">{{$suser->id}}</p>
                <p class="text-center text-3xl font-bold">{{$suser->name}}</p>
                <p>Email: <span class="font-bold">{{$suser->email}}</span> </p>
                <p>Role: <span class="font-bold">{{$suser->role}}</span> </p>
                <div class="flex gap-2">
                    @if (!$suser->deleted_at)
                    <a href="{{route('manage-users')}}/{{$suser->id}}/edit" class="p-2 bg-accent text-white rounded">
                        Edit
                    </a>
                    @endif
                    @if ($suser->deleted_at)
                    <button onclick="showActivateConfirmation('{{$suser->id}}')" class="p-2 bg-green-500 text-white rounded cursor-pointer">Activate</button>
                    @else
                    <button onclick='showDeleteConfirmation("{{$suser->id}}")' class="p-2 bg-red-500 text-white rounded cursor-pointer">Deactivate</button>
                    @endif

                </div>
            </div>
            @endforeach
        </div>
        <table class="bg-white mt-5 mb-4 min-w-[90%] max-w-full  m-auto  lg:table hidden text-center">
            <thead>
                <td>ID</td>
                <td>NAME</td>
                <td>EMAIL</td>
                <td>ROLE</td>
                <td>Action</td>
            </thead>
            <tbody>
                @foreach ($users as $suser )
                <tr class="{{$suser->deleted_at?'bg-[#d9ceeb] text-black/25':'bg-[#f1eef6] text-black'}}">
                    <td class="sm:p-3">{{$suser->id}}</td>
                    <td>{{$suser->name}}</td>
                    <td>{{$suser->email}}</td>
                    <td>{{$suser->role}}</td>
                    <td class="">
                        @if (!$suser->deleted_at)

                        <a href="{{route('manage-users')}}/{{$suser->id}}/edit">
                            <button class="px-5 cursor-pointer mr-4 py-2 bg-accent text-white rounded">
                                Edit
                            </button>
                        </a>
                        @endif
                        @if ($suser->deleted_at)
                        <button onclick="showActivateConfirmation('{{$suser->id}}')" class="p-2 bg-green-500 text-white rounded cursor-pointer">Activate</button>
                        @else
                        <button onclick='showDeleteConfirmation("{{$suser->id}}")' class="p-2 bg-red-500 text-white rounded cursor-pointer">Deactivate</button>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        {{$users->links()}}
        <script>
            function showDeleteConfirmation(itemId) {
                Livewire.dispatch('showConfirm', ['Are you sure you want to deactivate this account?', 'deleteItem', itemId]);
            }

            function showActivateConfirmation(itemId) {
                Livewire.dispatch('showConfirm', ['Are you sure you want to reactivate this account?', 'activateItem', itemId]);
            }
            window.addEventListener('force-refresh', () => {
                console.log('Browser event says reload!');
                window.location.reload();
            });
        </script>
        <livewire:modal />
    </section>
</x-dashboard>