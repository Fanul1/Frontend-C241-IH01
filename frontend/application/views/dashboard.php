<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <!-- CPU Load -->
                <div class="col-md-3">
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

                <!-- Hotspot Active -->
                <div class="col-md-3">
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

                <!-- Hotspot Users -->
                <div class="col-md-3">
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

                <!-- Uptime -->
                <div class="col-md-3">
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
            <!-- /.row -->

            <!-- Interface Select and Traffic Chart -->
            <div class="row">
                <div class="col-md-6">
                    <select name="interface" id="interface" class="form-control">
                        <?php foreach ($interface as $inter) { ?>
                            <option value="<?= $inter['name'] ?>"><?= $inter['name'] ?></option>
                        <?php } ?>
                    </select>
                    <canvas id="trafficChart" style="max-width: 100%;"></canvas>
                    <div id="reloadtraffic"></div>
                </div>

                <!-- Bar Chart -->
                <div class="col-md-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Jumlah Penjualan Voucher</h3>

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
                                <canvas id="barChart" style="max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>

<!-- Modal for Welcome Popup -->
<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="welcomeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="welcomeModalLabel">Welcome Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Welcome, <?= $this->session->userdata('username'); ?>!</p>
        <p>You have successfully logged in.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {
        // Check sessionStorage to decide whether to show the welcome modal
        var shownWelcomeModal = sessionStorage.getItem('shownWelcomeModal');
        if (!shownWelcomeModal) {
            $('#welcomeModal').modal('show');
            sessionStorage.setItem('shownWelcomeModal', true);
        }

        // Set interval to reload traffic data
        setInterval(reloadtraffic, 1000);
    });

    function reloadtraffic() {
        var interface = $('#interface').val();
        $.post('<?= site_url('dashboard/traffic') ?>', { interface: interface }, function(data) {
            updateChart(data.traffic_data);
        }, 'json');
    }

    var ctxTraffic = document.getElementById('trafficChart').getContext('2d');
    var trafficChart = new Chart(ctxTraffic, {
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
                        callback: function (value) {
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

    var ctxBar = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['HARIAN', 'MINGGUAN', 'BULANAN'],
            datasets: [{
                label: 'Jumlah Voucher',
                data: [
                    <?= $voucherData['HARIAN']; ?>,
                    <?= $voucherData['MINGGUAN']; ?>,
                    <?= $voucherData['BULANAN']; ?>
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
