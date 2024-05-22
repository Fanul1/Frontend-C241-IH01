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
									<th>User</th>
                                    <th>Server</th>
                                    <th>Login By</th>
                                    <th>IP Address</th>
                                    <th>Uptime</th>
                                    <th>Bytes In</th>
                                    <th>Bytes Out</th>
                                    <th>Comment</th>
                                    <th><?= $totalhotspotactive; ?>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hotspotactive as $data) { ?>
                                    <tr>
										<th><?= $data['user']; ?></th>
                                        <th><?= $data['server']; ?></th>
                                        <th><?= $data['login-by']; ?></th>
                                        <th><?= $data['address']; ?></th>
                                        <th><?= $data['uptime']; ?></th>
                                        <th style="text-align: right;"><?= formatBytes($data['bytes-in'], 2); ?></th>
                                        <th style="text-align: right;"><?= formatBytes($data['bytes-out'], 3); ?></th>
                                        <th><?= $data['comment']; ?></th>
                                        <?php $id = str_replace('*', '', $data['.id']); ?>
                                        <th><a href="<?= site_url('hotspot/delUserActive/' . $id); ?>" onclick="return confirm('Apakah anda yakin akan hapus user <?= $data['user']; ?>')"><i class="fa fa-trash" style="color:red";></i></a>
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
