<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">CPU Load</span>
                            <span class="info-box-number">
                                <?= $cpu; ?>
                                <small>%</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-laptop"></i></span>
                        <a href="<?= site_url('hotspot/active') ?>" style="color: black">
                            <div class="info-box-content">
                                <span class="info-box-text">Hotspot Active</span>
                                <span class="info-box-number"><?= $hotspotactive; ?></span>
                            </div>
                        </a>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <a href="<?= site_url('hotspot/users') ?>" style="color: black">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Hotspot Users</span>
                                <span class="info-box-number"><?= $hotspotuser; ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Uptime</span>
                            <span class="info-box-number"><?= $uptime; ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <select name="interface" id="interface">
                <?php foreach ($interface as $inter) { ?>
                    <option value="<?= $inter['name'] ?>"><?= $inter['name'] ?></option>
                <?php } ?>
            </select>
            <canvas id="trafficChart"></canvas>
            <div id="reloadtraffic"></div>
            </div>
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"> Jumlah Penjualan Voucher</h3>
            
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                            </div>
                          </div>
                        <div class="card-body">
                            <div class="chart">
                              <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                          <!-- /.card-body -->
            </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {
        setInterval(reloadtraffic, 1000);
    });

    function reloadtraffic() {
        var interface = $('#interface').val();
        $.post('<?= site_url('dashboard/traffic') ?>', {interface: interface}, function(data) {
            updateChart(data.traffic_data);
        }, 'json');
    }

    var ctx = document.getElementById('trafficChart').getContext('2d');
    var trafficChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Rx',
                    data: [],
                    borderColor: 'blue',
                    fill: true,
                    backgroundColor: 'rgba(0, 0, 255, 0.1)'
                },
                {
                    label: 'Tx',
                    data: [],
                    borderColor: 'red',
                    fill: true,
                    backgroundColor: 'rgba(255, 0, 0, 0.1)'
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' kbps';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Kbps'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Time'
                    }
                }
            }
        }
    });
    var rtx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(rtx, {
        type: 'bar',
        data: {
            labels: ['HARIAN', 'MINGGUAN', 'BULANAN'],
            datasets: [{
                label: 'Jumlah Voucher',
                data: [
                    <?php echo $voucherData['HARIAN']; ?>,
                    <?php echo $voucherData['MINGGUAN']; ?>,
                    <?php echo $voucherData['BULANAN']; ?>
                ],
                backgroundColor: ['#3c8dbc', '#f56954', '#00a65a'],
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 10,
                    ticks: {
                        stepSize: 1,
                    }
                }
            }
        }
    });

    function updateChart(traffic_data) {
        trafficChart.data.labels = traffic_data.map(d => d.time);
        trafficChart.data.datasets[0].data = traffic_data.map(d => d.rx / 1000);
        trafficChart.data.datasets[1].data = traffic_data.map(d => d.tx / 1000);
        trafficChart.update();
    }
</script>
