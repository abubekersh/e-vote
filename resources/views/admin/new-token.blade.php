<x-dashboard>
    <x-slot:role>{{$user->role}} Dashboard</x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $db])
    </x-slot:links>
    <section class="pb-16 pt-4 px-4 min-h-screen">
        <h1 class="text-center text-3xl capitalize font-bold">New Token regenration requests</h1>
        <div class="mt-5 flex  flex-col gap-2 flex-wrap">
            @if ($token_requests->isEmpty())
            <h2 class="text-center text-lg capitalize font-bold">no new token regeneration request available</h2>
            @endif
            @foreach ($token_requests as $token_request )
            <div class="border-2 rounded md:text-[0.8rem] m-auto font-bold">
                <div class="flex gap-20 py-5 px-15  w-fit">
                    <div class="flex gap-3 flex-col">
                        <h2 class="text-center text-2xl">The original</h2>
                        <img width="200px" class="rounded-xl" src="/storage/id_photos/hgQPVWMONdLZotKcNyViU5qL48kyBVD6KXari7p5.jpg" alt="">
                        <p class="capitalize">name: abubeker shelemew</p>
                        <p>email: abakabrak@gmail.com</p>
                        <p class="capitalize">date of birth: 1992-01-25</p>
                    </div>
                    <div class="flex gap-3 flex-col">
                        <h2 class="text-center text-2xl">Sent By User</h2>
                        <img width="200px" class="rounded-xl" src="/storage/{{$token_request->id_photo}}" alt="">
                        <p class="capitalize">Name: {{$token_request->name}}</p>
                        <p>Email: {{$token_request->voter->email}}</p>
                        <p class="capitalize">date of birth: {{$token_request->date_of_birth}}</p>
                    </div>
                </div>
                <div class="m-2 text-center  inline-flex justify-center">
                    <button onclick="showApproveConfirmation('{{$token_request->id}}')" class="p-2 font-bold text-white bg-primary rounded">Approve</button>
                </div>
                <div class="m-2 text-center inline-flex justify-center">
                    <button onclick="showRejectConfirmation('{{$token_request->id}}')" class="p-2 font-bold text-white bg-accent rounded">Reject</button>
                </div>
            </div>
            @endforeach
        </div>
        {{$token_requests->links()}}
        <script>
            function showApproveConfirmation(itemId) {
                Livewire.dispatch('showConfirm', ['Are you sure you want to approve this?', 'approveItem', itemId]);
            }

            function showRejectConfirmation(itemId) {
                Livewire.dispatch('showConfirm', ['Are you sure you want to reject this?', 'rejectItem', itemId]);
            }
        </script>
        <livewire:modal />
    </section>
</x-dashboard>