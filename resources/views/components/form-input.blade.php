@props(['size' =>'sm'])
@php
$class = 'border outline-0 rounded';
if ($size ==='sm')
$class .= ' p-3 border-white w-full';
elseif ($size==='md')
$class .= ' flex justify-between rounded-xl bg-white border-primary px-4 py-3 md:py-4 block mt-10 m-auto w-[95%] md:w-[75%] lg:w-[45%]';
else
$class .= ' ';
@endphp
@if ($size === 'md')
<div class="{{$class}}">
    <input {{$attributes->merge(['class'=>'text-sm w-full h-full outline-0 px-1'])}}>
    <button class="pr-3" type="submit">
        <img
            src="images/search-button-svgrepo-com.svg"
            alt=""
            width="17px" />
    </button>
</div>
@else
<input {{$attributes->merge(['class'=>$class])}}>
@endif
@error($attributes->get('name'))
<p class="text-xs text-[#fd9595]">{{$message}}</p>
@enderror