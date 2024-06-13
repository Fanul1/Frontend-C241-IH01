<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <div class="overflow box-bordered" style="max-height: 70vh">    
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-center">
                        <h3>Resume Report  Jun 2024</h3>
                        <div>
                        <?php
                        // Calculate total earnings
                        $totalEarnings = 0;
                        foreach ($dataDump as $row) {
                            $totalEarnings += $row['price'];
                        }
                        ?>
                        <!-- Display total earnings -->
                        <strong>Total Earnings: Rp. </strong><?php echo number_format($totalEarnings, 2); ?>
                    </div>
                    </div>
                    <div>
                        <!-- Placeholder untuk konten tambahan jika diperlukan -->
                    </div>
                </div>
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title fa fa-area-chart">
                            <i class="fa fa-area-chart"> Resume Report </i>
                        </h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="lineChart" style="width: 100%; height: 400px;"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var labels = <?= json_encode($chartLabels) ?>;
        var data = <?= json_encode($chartData) ?>;

        var ctx = document.getElementById('lineChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Price (Rp.)', // Ubah label untuk mencantumkan 'Rp.'
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                return value.toLocaleString();
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Total Penghasilan (Rp)'
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            autoSkip: false, // Mencegah penyingkiran label
                            maxRotation: 45, // Memutar label untuk sesuaikan jika perlu
                            minRotation: 45 // Memutar label untuk sesuaikan jika perlu
                        }
                    }]
                }
            }
        });
    });
</script>
s