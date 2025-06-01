<a href="{{'stats'}}" class="{{request()->is('*/stats') ? 'bg-black/50 text-white':''}}">
    <li>Home</li>
</a>
@foreach ($db as $link )
<a href="{{route($link)}}" class="{{request()->is('*/'.$link.'*') ? 'bg-black/50 text-white':''}}">
    <li>{{Str::of($link)->replace('-', ' '); }}</li>
</a>
@endforeach
<a href="/">
    <li>Back to Main</li>
</a>
<form action="{{route('logout')}}" method="post">
    @csrf
    <button>logout</button>
</form>