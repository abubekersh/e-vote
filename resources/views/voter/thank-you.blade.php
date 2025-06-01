<x-layout>
    <div class="bg-white shadow-xl rounded-2xl mb-10 p-8 max-w-xl w-1/2 m-auto text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-3">Thank You for Voting!</h1>
        <p class="text-gray-600 text-lg mb-6">
            Your vote has been <span class="font-semibold text-green-600">successfully recorded</span>.
            Thank you for participating in building a better democracy.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6">
            <a href="{{ url('/') }}"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition shadow">
                Go to Home
            </a>
            <a href="{{ url('/results') }}"
                class="border border-gray-300 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-100 transition">
                View Election Results
            </a>
        </div>
    </div>
    <!-- </div> -->

</x-layout>