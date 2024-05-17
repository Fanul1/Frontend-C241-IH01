<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3 class>Hotspot <?= $title; ?></h3>
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-borderes" id="dataTable" width="100%" collspacing="0">
                            <thead>
                                <tr>
                                    <th><?= $totalhotspotactive; ?>ID</th>
                                    <th>User</th>
                                    <th>Server</th>
                                    <th>Login By</th>
                                    <th>IP Address</th>
                                    <th>Uptime</th>
                                    <th>Bytes In</th>
                                    <th>Bytes Out</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hotspotactive as $data) { ?>
                                    <tr>
                                        <th></th>
                                        <th><?= $data['user']; ?></th>
                                        <th><?= $data['server']; ?></th>
                                        <th><?= $data['login-by']; ?></th>
                                        <th><?= $data['address']; ?></th>
                                        <th><?= $data['uptime']; ?></th>
                                        <th style="text-align: right;"><?= formatBytes($data['bytes-in'], 2); ?></th>
                                        <th style="text-align: right;"><?= formatBytes($data['bytes-out'], 3); ?></th>
                                        <th><?= $data['comment']; ?></th>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>