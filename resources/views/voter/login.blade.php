<x-layout>
    <section class="flex justify-center items-center mb-6">
        <div class="w-[95%] lg:w-[50%] xl:w-[40%] md:w-[60%]  bg-[#00b6ba45] h-[90%]  border-2 border-white p-10 rounded">
            <h2 class="text-white text-2xl md:text-4xl font-extrabold text-center">Sign In</h2>
            <p class="text-xs text-center pt-4 font-bold capitalize">Hello, voter insert your email and unique token you have to vote</p>
            <div id="scanner-loading" style="display: none; text-align: center; margin-top: 10px;">
                <div class="spinner" style="margin: auto;"></div>
                <p style="margin-top: 8px;">Processing... Please wait</p>
            </div>
            <form action="/vote" method="post" class="flex flex-col mt-8 gap-5 text-white font-bold">
                @csrf
                <div class="flex flex-col gap-1">
                    <label for="email">Email</label>
                    <x-form-input type="email" autofocus name="email" placeholder="abc@efg.com" id="email" />
                </div>
                <div class="flex flex-col gap-1">
                    <label for="token">Token</label>
                    <div class="flex items-center gap-2 ">
                        <!-- <div id="scanner-container"> -->
                        <x-form-input type="text" name="token" id="token" />
                        <!-- </div> -->
                        <div>
                            <img id="toggle-scanner-btn"
                                src="/images/qr-code (1).png"
                                width="30px" />
                        </div>
                    </div>
                </div>
                <div id="scanner-container" style="display: none;margin:auto;">
                    <div id="qr-reader" style="width: 250px; height: 200px;"></div>
                </div>

                <div class="flex justify-between ">

                    <a href="/vote/lost-token" class="text-xs md:text-xs text-white/85 capitalize  underline">i have lost my token?</a>
                </div>
                <button class=" mt-5  border-white bg-white text-[#00b6ba] border-2 p-3 rounded">Sign In</button>
            </form>
        </div>

    </section>
</x-layout>