<x-layout>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('showForgotPassword', {
                show: false
            });
        });
    </script>

    <section class="flex justify-center items-center">
        <div class="w-[95%] lg:w-[50%] xl:w-[40%] md:w-[60%]  bg-[#00b6ba45] h-[90%]  border-2 border-white p-10 rounded">
            <h2 class="text-white text-2xl md:text-4xl font-extrabold text-center">Sign In</h2>
            <form action="/login" method="post" class="flex flex-col mt-8 gap-5 text-white font-bold">
                @csrf
                <div class="flex flex-col gap-1">
                    <label for="email">Email</label>
                    <x-form-input required type="email" autofocus name="email" placeholder="abc@efg.com" id="email" />
                </div>

                <div class="flex flex-col gap-1">
                    <label for="password">Password</label>
                    <x-form-input required type="password" name="password" id="password" />
                    <button type="button" class="ml-auto text-xs" onclick="togglePassword('password',this)">Show</button>
                    <script>
                        function togglePassword(ab, btn) {
                            var x = document.getElementById(ab);
                            if (x.type === "password") {
                                x.type = "text";
                                btn.innerText = "hide"
                            } else {
                                x.type = "password";
                                btn.innerText = "show"
                            }

                        }
                    </script>
                </div>

                <div class="flex justify-between ">
                    <div class="text-xs md:text-sm flex justify-center items-center gap-1"><input type="checkbox" name="remember" id="remember"> <label for="remember">Remember Me</label></div>
                    <button type="button" x-data @click="$store.showForgotPassword.show = true" class="text-xs md:text-sm text-white/85  underline">Forgot Password?</button>
                </div>
                <button class=" mt-5  border-white bg-white text-[#00b6ba] border-2 p-3 rounded">Sign In</button>
            </form>
        </div>
        <div x-data>
            <template x-if="$store.showForgotPassword.show">
                <livewire:forgot-password />
            </template>
        </div>
    </section>
</x-layout>