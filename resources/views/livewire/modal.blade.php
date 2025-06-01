@php
use Illuminate\Support\Str;
@endphp
<div x-data="{ open: @entangle('show') }">
    <div wire:show="show" class="fixed inset-0 flex items-center justify-center bg-gray-900/10 bg-opacity-50 backdrop-blur-lg">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <p class="text-lg font-semibold text-black" x-text="$wire.message"></p>

            <div class="mt-4 flex justify-end space-x-2">
                <button @click="$wire.close()" class="px-4 py-2 bg-gray-400 rounded">Cancel</button>
                @if(!Str::contains($this->message,'success'))
                <button x-show="$wire.action" @click="$wire.confirm()" class="px-4 py-2 bg-blue-600 text-white rounded">
                    Confirm
                </button>
                @endif
            </div>
        </div>
    </div>
</div>