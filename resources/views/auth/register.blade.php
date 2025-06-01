<x-layout>

    <section class="flex justify-center items-center">
        <div class="w-[40%] bg-[#00b6ba45] h-[80%]  border-2 border-white p-10 rounded">
            <h2 class="text-white text-4xl font-extrabold text-center">Sign Up</h2>
            <form action="/login" method="post" class="flex flex-col mt-8 gap-5 text-white font-bold">
                @csrf
                <div class="flex flex-col gap-1">
                    <label for="name">Full Name</label> <input type="name" name="name" placeholder="Abebe Kebede" id="name" class="outline-0 rounded  p-3 border fill-transparent border-white ">
                    @error('name')
                    <p class="text-xs text-[#ffc2c2]">{{$message}}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label for="email">Email</label> <input type="email" name="email" placeholder="abc@efg.com" id="email" class="outline-0 rounded  p-3 border fill-transparent border-white ">
                    @error('email')
                    <p class="text-xs text-[#ffc2c2]">{{$message}}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label for="password">Password</label> <input type="password" name="password" id="password" class="outline-0 rounded p-3 border border-white ">
                    @error('password')
                    <p class="text-xs text-[#ffc2c2]">{{$message}}</p>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <div class="text-sm"><input type="checkbox" name="remember" id="remember"> <label for="remember">Remember Me</label></div>
                    <button type="button" @click="console.log('clicked');showForgotPassword = true;" class="text-sm text-white/85  underline">Forgot Password?</button>
                </div>
                <button class=" mt-5  border-white bg-white text-[#00b6ba] border-2 p-3 rounded">Sign In</button>
            </form>
        </div>
    </section>
    <div x-data="{showForgotPassword: false}">
    <template x-if="showForgotPassword">
        <livewire:forgot-password @close-modal="showForgotPassword = false" />
    </template>
    </div>
</x-layout>