<x-dashboard>
    <x-slot:role>{{$user->role}} Dashboard</x-slot:role>
    <x-slot:links>
        @include('components.dashboard-link', ['db' => $links])
    </x-slot:links>
    <section>
        <div class="grid md:grid-cols-4 grid-cols-2">
            @foreach ($st as $name=>$value )
            <div class="flex justify-between max-w-72 p-4 gap-3 bg-primary  m-4 rounded">
                <div>
                    <p>{{$value}}</p>
                    <p>Total {{$name}}</p>
                </div>
                <div><img src="/images/stats/{{$name}}.png" width="30px" alt=""></div>
            </div>
            @endforeach
        </div>
        <div class="flex md:flex-row flex-col gap-5 px-4 w-[75%] ml-20">
            <div class="chart-container">
                <canvas id="pieChart" class=""></canvas>
            </div>
            <div class="chart-container grow">
                <canvas id="lineChart" class=""></canvas>
            </div>
        </div>
    </section>
    <script>
        let data = @json($data);
        let label = @json($label);
        let date = @json($date);
        let date_label = @json($date_label);

        document.addEventListener('DOMContentLoaded', function() {
            renderpieC(label, data)
            renderlineC(date_label, date);
        });
    </script>
</x-dashboard>