<x-layout>
    <section class="flex justify-center items-center mb-6">
        <div class="w-[95%] lg:w-[50%] xl:w-[40%] md:w-[60%]  bg-[#00b6ba45] h-[90%]  border-2 border-white p-10 rounded">
            <h2 class="text-white text-2xl md:text-4xl font-extrabold text-center">Token Regeneration</h2>
            <p class="text-xs text-center pt-4 font-bold capitalize">Hello, voter insert the following information correctly to get approved for new tokens</p>
            <form action="/vote/lost-token" method="post" enctype="multipart/form-data" class="flex flex-col mt-8 gap-5 text-white font-bold">
                @csrf
                <div class="flex flex-col gap-1">
                    <label for="email">Email</label>
                    <x-form-input required autocomplete="off" type="email" autofocus name="email" id="email" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="name">name</label>
                    <x-form-input required type="text" autofocus name="name" id="name" />
                </div>

                <div class="flex flex-col gap-1">
                    <label for="dob">Date of birth</label>
                    <x-form-input required type="date" name="date_of_birth" id="date" max="2007-01-01" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="kebeleid">kebele id photo <span class="text-xs"><sup>*</sup>(make sure to capture the whole id. the information and your photograph should be visible)</span></label>
                    <x-form-input required type="file" name="id_photo" id="id_photo" />
                </div>
                <button class=" mt-5  border-white bg-white text-[#00b6ba] border-2 p-3 rounded">Send a Request</button>
            </form>
        </div>
    </section>
</x-layout>