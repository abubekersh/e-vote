<div class="p-4 bg-white rounded-xl shadow-md">
    <h2 class="text-xl font-bold mb-4">Votes Per Candidate</h2>
    <canvas id="voteChart"></canvas>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', function() {
        const ctx = document.getElementById('voteChart').getContext('2d');
        let labels = {
            !!json_encode($candidates) !!
        };
        let values = {
            !!json_encode($voteCounts) !!
        };
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Votes',
                    data: values,
                    backgroundColor: '#3B82F6',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endpush