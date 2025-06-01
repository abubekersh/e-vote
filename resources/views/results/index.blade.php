@extends('layout')

@section('content')
<div class="max-w-6xl mx-auto p-6 space-y-10">

    <h1 class="text-3xl font-bold text-center mb-8">Election Results by Constituency</h1>

    @foreach ($constituencyStats as $stat)
    <div class="bg-black/25 rounded-2xl shadow p-6 text-white">
        <h2 class="text-xl font-semibold mb-4 ">{{ $stat->constituency_name }} ({{ $stat->region }})</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
            <div>
                <div class="text-sm text-gray-300">Registered Voters</div>
                <div class="text-2xl font-bold">{{ $stat->registered_voters }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-300">Votes Cast</div>
                <div class="text-2xl font-bold">{{ $stat->votes_cast }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-300">Turnout</div>
                <div class="text-2xl font-bold">
                    {{ $stat->turnout_percentage }}%
                </div>
            </div>
        </div>

        <div class="mt-6">
            <canvas
                id="chart-{{ $stat->constituency_id }}"
                class="w-full h-45 bg-white rounded"
                data-labels="{{ implode(',', collect($stat->candidates)->pluck('candidate_name')->toArray()) }}"
                data-values="{{ implode(',', collect($stat->candidates)->pluck('votes_received')->toArray()) }}"></canvas>
        </div>
    </div>
    @endforeach

</div>
@endsection

@push('scripts')
@endpush