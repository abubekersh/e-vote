<x-layout>
    <div class="mt-[-5rem] bg-transparent flex items-center justify-center min-h-screen">
        <form method="POST" action="{{route('vote-submit')}}" class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-lg">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <h2 class="text-2xl font-semibold text-center mb-6 text-gray-800">Cast Your Vote {{$candidates[0]->constituency->name}} constituency</h2>

            <div class="space-y-4">
                @foreach($candidates as $candidate)
                <label class="flex items-center p-4 bg-gray-50 rounded-xl cursor-pointer border border-transparent hover:border-blue-500 transition duration-300">
                    <input type="radio" name="candidate_id" value="{{ $candidate->id }}" required class="hidden peer">

                    <img src="/storage/{{ $candidate->picture ?? 'https://via.placeholder.com/70' }}" alt="Candidate" class="w-16 h-16 rounded-full object-cover border-2 border-gray-300 peer-checked:border-blue-500">

                    <div class="ml-4">
                        <div class="text-lg font-medium text-gray-900">{{ $candidate->name }}</div>
                        <div class="text-sm text-gray-500">{{ $candidate->politicalParty->name ?? 'Individual candidate' }}</div>
                    </div>
                    <div class="ml-auto">
                        <img src="/storage/{{ $candidate->politicalParty->symbol ?? $candidate->symbol }}" alt="Candidate" class="w-16 h-16 rounded-full object-cover border-2 border-gray-300 peer-checked:border-blue-500" />
                    </div>
                </label>
                @endforeach
            </div>

            <button type="submit" class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200">
                Confirm Vote
            </button>
        </form>
    </div>
</x-layout>