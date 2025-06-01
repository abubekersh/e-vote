<x-dashboard>
    <x-slot:role> Dashboard</x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => ['candidates']])
    </x-slot:links>
    <!-- Chart Data as Safe Attributes -->
    <div id="candidate-chart-data"
        data-independent="{{ $independentCount }}"
        data-party="{{ $partyAffiliatedCount }}">
    </div>

    <!-- Beautiful Card with Chart -->
    <div class="bg-white rounded-xl shadow p-6 mb-10">
        <h2 class="text-xl font-semibold mb-4">Candidate Distribution</h2>
        <div class="w-1/4 m-auto">
            <canvas id="candidateChart"></canvas>
        </div>
    </div>

    <!-- Candidate List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10 p-4">
        @foreach ($candidates as $candidate)
        <div class="bg-white shadow rounded-xl p-4 flex flex-col items-center text-center">
            <img src="/storage/{{$candidate->picture}}"
                alt="Candidate Photo"
                class="w-24 h-24 rounded-full object-cover mb-3 border">
            <h3 class="text-lg font-semibold">{{ $candidate->name }}</h3>
            <p class="text-sm text-gray-500">
                {{ $candidate->political_party_id ? $candidate->politicalParty->name : 'Independent' }}
            </p>
            @if ($candidate->symbol)
            <img src="{{ asset('storage/' . $candidate->symbol) }}"
                alt="Candidate Symbol"
                class="w-12 h-12 mt-3 object-contain">
            @else
            <img src="/storage/{{$candidate->politicalParty->symbol}}"
                alt="Candidate Symbol"
                class="w-12 h-12 mt-3 object-contain">
            @endif
        </div>
        @endforeach
    </div>

</x-dashboard>