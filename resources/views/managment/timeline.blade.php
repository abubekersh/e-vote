<x-dashboard>
    <x-slot:role>
        {{$user->role}} Dashboard
    </x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $links])
    </x-slot:links>
    <section class=" min-h-screen pb-8">
        <section class="grid grid-cols-1 md:grid-cols-2 p-10 flex-wrap w-full gap-6">
            @if ($timelines->isEmpty())
            <p class="text-2xl text-white text-center">No schedules set for now</p>
            @endif
            @foreach ($timelines as $timeline)
            <div class="bg-[#00b7bab4] rounded p-5  text-white font-bold">
                <h3 class="flex  gap-2  capitalize items-center text-lg justify-start ">
                    <img src="/images/calandar.svg" class="w-4 self-center" alt="">
                    {{$timeline->type}}
                </h3>
                <div class="p-2 flex flex-col gap-2">
                    <div>Starts: {{$timeline->starts}} LT</div>
                    <div>Ends: {{$timeline->ends}} LT </div>
                </div>
            </div>
            @endforeach
        </section>
        <form action="{{route('timeline')}}" method="post" class="bg-white w-[90%] md:w-1/2 p-10 rounded m-auto">
            @csrf
            <h2 class="text-primary text-xl font-bold text-center mb-4">Create Election TimeLine</h2>
            <div class="border-2 border-primary  rounded p-8 w-full">
                <span class="capitalize font-bold block">Schedule Name</span>
                <select name="timeline" id="timeline" class="border-2 border-primary rounded p-1 w-full mb-2">
                    <option value="party registration">Political party registration</option>
                    <option value="candidate registration">Candidate registartion</option>
                    <option value="voter registration">Voter Registration</option>
                    <option value="election day">Election Day</option>
                </select>
                @error('timeline')
                <p class="text-xs text-black">{{$message}}</p>
                @enderror
                <br>
                <span class="capitalize font-bold block">Start date</span>
                <input type="date" id="sdate" name="startdate" class="border-2 border-primary rounded p-1 w-1/2">
                <input type="time" name="starttime" value="00:00" class="border-2 border-primary rounded p-1">
                @error('startdate')
                <p class="text-xs text-black">Start date and time can not be empty</p>
                @enderror
                <span class="capitalize font-bold block mt-2">End date</span>
                <input type="date" id="edate" name="enddate" class="border-2 border-primary rounded p-1 w-1/2">
                <input type="time" name="endtime" value="12:00" class="border-2 border-primary rounded p-1">
                @error('enddate')
                <p class="text-xs text-black">End date and time can not be empty</p>
                @enderror
                <button class="bg-primary p-2 m-auto text-white w-full font-bold rounded block mt-4">Create</button>
            </div>
        </form>
    </section>
</x-dashboard>