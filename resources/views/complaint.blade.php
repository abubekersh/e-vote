<x-layout>
    <section class="flex justify-center items-center mb-5">
        <div class="w-[95%] lg:w-[50%] xl:w-[40%] md:w-[60%]  bg-[#00b6ba45] h-[90%]  border-2 border-white p-10 rounded">
            <h2 class="text-white text-2xl md:text-4xl font-extrabold text-center">Submit a complaint</h2>
            <p class="text-xs text-center pt-4 font-bold capitalize">Hello, write any compliant regarding the system here</p>
            <form action="/complaint" method="post" class="flex flex-col mt-8 gap-5 text-white font-bold">
                @csrf
                <div class="flex flex-col gap-1">
                    <label for="email">Email <span class="text-xs">(you use on the system)</span></label>
                    <x-form-input type="text" name="email" id="email" required></x-form-input>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="type">problem type</label>
                    <div class="ml-3"><input type="radio" value="system problem" autofocus name="type" /> system problem</div>
                    <div class="ml-3"><input type="radio" value="voting process problem" autofocus name="type" /> voting proccess problem</div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="description">Description</label>
                    <textarea required name="description" id="desription" class="border border-white rounded outline-0 focus:border-[#00b6ba] p-2"></textarea>

                </div>


                <button class=" mt-5  border-white bg-white text-[#00b6ba] border-2 p-3 rounded">Submit</button>
            </form>
        </div>
    </section>

</x-layout>