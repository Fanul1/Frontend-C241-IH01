<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <div class="overflow box-bordered" style="max-height: 70vh">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-area-chart"></i> Predicted Users Line Chart
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="lineChart" style="width: 100%; height: 400px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Memasukkan data respons dari controller -->
<script>
    var responseData = <?php echo $responseData; ?>;
    var predictedUsers = responseData.predicted_users;

    var labels = [];
    for (var i = 0; i < predictedUsers.length; i++) {
        labels.push(i.toString() + ":00");
    }

    var data = {
        labels: labels,
        datasets: [{
            label: 'Predicted Users',
            data: predictedUsers,
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    };

    var config = {
        type: 'line',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    var myChart = new Chart(
        document.getElementById('lineChart'),
        config
    );
</script>
