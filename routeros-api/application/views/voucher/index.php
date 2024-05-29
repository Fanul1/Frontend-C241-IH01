<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Voucher</h3>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>
                    <i class="fa fa-users"></i> Vouchers &nbsp;&nbsp; | &nbsp;&nbsp;
                    <i onclick="location.reload();" class="fa fa-refresh pointer" title="Reload data"></i>
                </h3>
            </div>
            <div class="card-body">
                <div class="overflow" style="max-height: 80vh">
                    <div class="row">
                        <?php foreach ($profiles as $profile): ?>
                            <div class="col-4">
                                <div class="box bmh-75 box-bordered" style="background-color: <?= $profile['name'] == 'default' ? 'yellow' : 'purple'; ?>">
                                    <div class="box-group">
                                        <div class="box-group-icon">
                                            <a title="Open User by profile <?= $profile['name'] ?>" href="./?hotspot=users&profile=<?= urlencode($profile['name']) ?>&session=FAN-CELL">
                                                <i class="fa fa-ticket"></i>
                                            </a>
                                        </div>
                                        <div class="box-group-area">
                                            <h3>Profile : <?= $profile['name'] ?><br>
                                                <?= $profile['user_count'] ?> Items
                                            </h3>
                                            <a title="Open User by profile <?= $profile['name'] ?>" href="./?hotspot=users&profile=<?= urlencode($profile['name']) ?>&session=FAN-CELL">
                                                <i class="fa fa-external-link"></i> Open
                                            </a>&nbsp;
                                            <a title="Generate User by profile <?= $profile['name'] ?>" href="./?hotspot-user=generate&genprof=<?= urlencode($profile['name']) ?>&session=FAN-CELL">
                                                <i class="fa fa-users"></i> Generate
                                            </a>&nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>