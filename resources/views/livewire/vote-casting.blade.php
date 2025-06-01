@vite(['resources/css/app.css'])
<div class="p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">Cast Your Vote</h2>

    @if ($voted)
    <div class="text-green-500 text-center text-xl font-semibold">
        ✅ Your vote has been submitted. Thank you!
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($candidates as $candidate)
        <div class="bg-white rounded-2xl shadow-md overflow-hidden transition transform hover:scale-105 cursor-pointer"
            wire:click="selectCandidate({{ $candidate->id }})">
            <img src="/storage/{{$candidate->picture}}" alt="Candidate"
                class="w-full h-48 object-cover">
            <div class="p-4 text-center">
                <h3 class="text-lg font-bold">{{ $candidate->name }}</h3>
                <p class="text-sm text-gray-500">{{ $candidate->party->name ?? 'Independent' }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Confirmation Modal --}}
    @if ($confirming)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl shadow-xl text-center space-y-4">
            <h3 class="text-xl font-semibold">Confirm Your Vote</h3>
            <p>Are you sure you want to vote for
                <span class="font-bold">
                    {{ $candidates->firstWhere('id', $selectedCandidate)?->name }}
                </span>?
            </p>
            <div class="flex justify-center gap-4 mt-4">
                <button wire:click="castVote"
                    class="bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700">
                    Yes, Vote
                </button>
                <button wire:click="$set('confirming', false)"
                    class="bg-gray-300 px-4 py-2 rounded-xl hover:bg-gray-400">
                    Cancel
                </button>
            </div>
        </div>
    </div>
    @endif
</div>