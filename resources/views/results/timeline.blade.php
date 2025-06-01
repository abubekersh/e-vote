<x-layout>
    <section class="h-screen">
        <h1 class="text-center text-4xl capitalize font-bold text-white mb-2">Schedules for 7<sup>th</sup> national election </h1>
        <section class="grid grid-cols-1 md:grid-cols-2 p-5 flex-wrap w-full gap-6">
            @if ($timelines->isEmpty())
            <p class="text-2xl text-white text-center">No schedules set for now</p>
            @endif
            @foreach ($timelines as $timeline)
            @php
            $stm = explode(" ",$timeline->starts);
            $etm = explode(" ",$timeline->ends);
            @endphp
            <div class="bg-[#00b7bab4] rounded p-5  text-white font-bold">
                <h3 class="flex  gap-2  capitalize items-center text-lg justify-start ">
                    <img src="/images/calandar.svg" class="w-4 self-center" alt="">
                    {{$timeline->type}}
                </h3>
                <div class="grid grid-cols-2">
                    <div class="p-2 flex flex-col gap-2">
                        Start Date
                        <div class="border p-2 rounded mb-1"> {{$stm[0]}}</div>
                        Time
                        <div class="border p-2 rounded"> {{$stm[1]}} LT</div>
                    </div>
                    <div class="p-2 flex flex-col gap-2">
                        End Date
                        <div class="border p-2 rounded mb-1">{{$etm[0]}}</div>
                        Time
                        <div class="border p-2 rounded"> {{$etm[1]}} LT</div>
                    </div>
                </div>
            </div>
            @endforeach
        </section>
    </section>
</x-layout>