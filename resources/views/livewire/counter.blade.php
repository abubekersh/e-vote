<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .chart-container {
            max-width: 500px;
            /* margin: auto; */
            background: #f1eef6;
            border: 1px black solid;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<!-- <canvas id="users"></canvas> -->
<div class="chart-container">
    <canvas id="pieChart" class=""></canvas>
</div>

<body>
    <script>
        let data = @json($counts);
        let label = @json($labels);

        renderC(label, data)

        function renderC(label, data) {
            const ctx = document.getElementById('pieChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: label,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            '#3B82F6', // Blue
                            '#10B981', // Green
                            '#F59E0B', // Amber
                            '#EF4444',
                            '#EF4004' // Red // Violet
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Users Registered by Date'
                        }
                    }
                }
            });
        }
    </script>
</body>

</html>