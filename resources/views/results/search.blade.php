<x-layout>
    <div class="min-h-screen bg-white/25 py-10 px-4">
        <h2 class="text-2xl font-bold text-center mb-6">Search Results for: "{{ $query }}"</h2>

        @if ($candidates->count() || $parties->count() || $constituencies->count())
        <div class="grid gap-6 max-w-6xl mx-auto">

            {{-- Candidates --}}
            @if ($candidates->count())
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Candidates</h3>
                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($candidates as $candidate)
                    <div class="bg-white rounded-xl shadow-md p-4 flex flex-col items-center text-center">
                        <img src="/storage/{{$candidate->picture}}" class="w-24 h-24 object-cover rounded-full mb-3" alt="Photo">
                        <h4 class="font-bold text-gray-800">{{ $candidate->name }}</h4>
                        <p class="text-gray-600 text-sm mb-1">
                            @if($candidate->political_party_id)
                            Party: {{ $candidate->politicalParty->name }}
                            @else
                            Independent
                            @endif
                        </p>
                        <p class="text-gray-500 text-xs">Symbol: <img class="w-10" src="/storage/{{ $candidate->symbol }}" alt=""></p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Political Parties --}}
            @if ($parties->count())
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Political Parties</h3>
                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($parties as $party)
                    <div class="bg-white rounded-xl shadow-md p-4 text-center flex gap-4 items-center">
                        <img class="w-10" src="/storage/{{ $party->symbol }}" alt="">
                        <h4 class="text-lg font-bold text-gray-800">{{ $party->name }}</h4>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Constituencies --}}
            @if ($constituencies->count())
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Constituencies</h3>
                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($constituencies as $constituency)
                    <div class="bg-white rounded-xl shadow-md p-4 text-center">
                        <h4 class="text-lg font-bold text-gray-800">{{ $constituency->name }}</h4>
                        <p class="text-gray-500 text-sm">Region: {{ $constituency->region ?? 'N/A' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
        @else
        <div class="text-center text-gray-600 mt-12">
            <p>No results found.</p>
        </div>
        @endif
    </div>

</x-layout>