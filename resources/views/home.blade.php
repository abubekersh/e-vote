<x-layout>
    <section>
        <div class="text-center">
            <h2 class="text-4xl md:text-7xl text-primary font-bold ">7<sup>th</sup> National Election</h2>
            <p class="text-sm">of the people by the people for the people</p>
        </div>
        <form action="/search/result" class="home-form">
            <div>
                <x-form-input autocomplete="off" name="q" type="text" size="md" id="search-input" class="text-black" placeholder="Search Parties, Constituencies and Candidates" />
            </div>
            <ul id="suggestions" class="list-none p-0"></ul>
        </form>
        <div class="flex text-sm w-full justify-center mt-5 text-white gap-3">
            <a href="{{route('show-timeline')}}" class="bg-primary p-2 rounded">View Election Timeline</a href="">
        </div>
    </section>
    <div class="text-md w-full  text-center   mt-25 md:mt-10">
        <h2 class="text-xl text-white capitalize font-bold ">what to do ?</h2>
        <div class="flex flex-col justify-center gap-7 items-center  p-4">
            <div class="w-full bg-[#6e54a596] p-2 md:w-[25%] rounded font-bold">Go to the nearest polling station</div>
            <div class="w-full bg-[#6e54a596] p-2 md:w-[25%]  rounded  font-bold">Register and recive a voting card</div>
            <div class="w-full bg-[#6e54a596] p-2 md:w-[25%] rounded  font-bold">Log into the system and vote</div>
        </div>
    </div>
</x-layout>