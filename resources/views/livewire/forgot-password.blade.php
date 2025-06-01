    <div class="fixed inset-0 bg-grey-900/50 flex justify-center items-center backdrop-blur-lg">
        <form wire:submit="sendEmail" class="bg-[#6e54a5ab] w-[90%] md:w-[45%]  lg:w-[30%] p-8 h-[50%] absolute top-30  z-50 flex flex-col gap-5 text-white rounded">
            <div class="flex" x-data @click="$store.showForgotPassword.show = false">

                <p wire:show="success" class="text-green-400 text-2xl p-2 bg-[rgb(215,247,215)] w-[95%] rounded">{{$successMessage}} <span class="block text-xs">do not forget to check your spam folder</span></p>
                @if ($failed)
                <p class="text-red-400 text-2xl p-4 bg-[rgb(247,215,215)] w-[95%] rounded">{{$failedMessage}}</p>
                @endif
                <img class="ml-auto" src="/images/close.svg" alt="" width="30px">
            </div>
            <p class="text-xl text-center">Enter your email</p>
            <div>
                <input type="text" wire:model="email" name="email-reset" id="email-reset" class="w-full block border p-4 outline-0 rounded border-white"> <span class="text-xs text-green-400" wire:loading>sending reset link ...</span>
                @error('email')
                <p wire:loading.remove class="mt-1 text-xs text-white">{{$message}}</p>
                @enderror
            </div>
            <button type="submit" {{$disabled?'disabled':''}} class="{{$disabled?'bg-gray-400':'bg-white hover:bg-white/90'}}  p-4 text-[#6e54a5ab] font-bold rounded ">Send Reset Link</button>
        </form>
    </div>