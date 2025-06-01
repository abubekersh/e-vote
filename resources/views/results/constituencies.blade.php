<x-layout>
    <h1 class="text-center text-4xl mb-5">List of constituencies</h1>
    <section class="flex gap-5 p-4 h-screen">
        @foreach ($constituencies as $constituency)
        <div class="bg-[#00b6ba45] p-4 rounded text-center h-fit capitalize">
            <p>{{$constituency->id}}</p>
            <p>constituency name &rAarr; {{$constituency->name}}</p>
            <p>region &rAarr; {{$constituency->region}}</p>
            <p>woreda &rAarr; {{$constituency->woreda}}</p>
        </div>
        @endforeach
    </section>
</x-layout>