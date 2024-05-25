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
            <div id="reloadtraffic"></div>
            <div class="card card-info mt-2">
                <div class="card-header">
                    <h3 class="card-title">Line Chart</h3>

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
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="lineChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 403px;"
                            width="403" height="250" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        setInterval(reloadtraffic, 1000);
    });

    function reloadtraffic() {
        var interface = $('#interface').val();
        $('#reloadtraffic').load('<?= site_url('dashboard/traffic') ?>', {interface: interface}); // Send selected interface via POST
    }
</script>
<script>
    $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
        var lineChartOptions = $.extend(true, {}, areaChartOptions)
        var lineChartData = $.extend(true, {}, areaChartData)
        lineChartData.datasets[0].fill = false;
        lineChartData.datasets[1].fill = false;
        lineChartOptions.datasetFill = false

        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        })
    })
</script>