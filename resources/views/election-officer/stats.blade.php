<x-dashboard>
    <x-slot:role> Dashboard</x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => ['create-voter']])
    </x-slot:links>
    <!-- Embed data safely -->
    <div id="voting-chart-data"
        data-voted="{{ $voted }}"
        data-not-voted="{{ $notVoted }}">
    </div>

    <div class="bg-white shadow rounded-xl p-6 mb-6">
        <h2 class="text-xl font-semibold mb-1">Polling Station: {{ $station->name }}</h2>
        <p class="text-gray-500 mb-4">Detailed voter participation</p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
            <div class="bg-gray-100 p-4 rounded">
                <p class="text-sm text-gray-500">Total Registered</p>
                <p class="text-2xl font-bold text-blue-600">{{ $total }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded">
                <p class="text-sm text-gray-600">Voted</p>
                <p class="text-2xl font-bold text-green-600">{{ $voted }}</p>
            </div>
            <div class="bg-red-100 p-4 rounded">
                <p class="text-sm text-gray-600">Not Voted</p>
                <p class="text-2xl font-bold text-red-500">{{ $notVoted }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4">Voter Participation Chart</h2>
        <canvas id="votingChart" class="w-full max-w-md mx-auto"></canvas>
    </div>


</x-dashboard>