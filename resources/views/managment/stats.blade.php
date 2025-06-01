<x-dashboard>
    <x-slot:role>
        Dashboard
    </x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $links])
    </x-slot:links>
    <div class="p-6">

        {{-- Top Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="text-lg font-bold">{{ $totalSchedules }}</div>
                <div class="text-gray-500">Schedules</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="text-lg font-bold">{{ $totalPollingStations }}</div>
                <div class="text-gray-500">Polling Stations</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="text-lg font-bold">{{ $totalConstituencies }}</div>
                <div class="text-gray-500">Constituencies</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="text-lg font-bold">{{ $totalPoliticalParties }}</div>
                <div class="text-gray-500">Political Parties</div>
            </div>
        </div>

        {{-- Charts --}}
        <div id="chart-data"
            data-schedules="{{ $totalSchedules }}"
            data-polling-stations="{{ $totalPollingStations }}"
            data-constituencies="{{ $totalConstituencies }}"
            data-political-parties="{{ $totalPoliticalParties }}">
        </div>

        <div class="md:w-[75%] m-auto rounded-xl shadow-md p-6 mb-8">
            <canvas id="overviewChart" class=" h-96"></canvas>
        </div>

        {{-- Recent Items --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Constituencies</h3>
                <ul class="space-y-2">
                    @foreach($recentConstituencies as $item)
                    <li class="text-gray-700">{{ $item->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Polling Stations</h3>
                <ul class="space-y-2">
                    @foreach($recentPollingStations as $item)
                    <li class="text-gray-700">{{ $item->name }} ({{$item->constituency->name}} constituency)</li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Political Parties</h3>
                <ul class="space-y-2">
                    @foreach($recentPoliticalParties as $item)
                    <li class="text-gray-700">{{ $item->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Schedules</h3>
                <ul class="space-y-2">
                    @foreach($recentSchedules as $item)
                    <li class="text-gray-700">{{ $item->type }}</li>
                    @endforeach
                </ul>
            </div>

        </div>

    </div>
</x-dashboard>