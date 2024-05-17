<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Hotspot Host</h3>
            <div class="card-body"> 
            </div>
            <div clServer"row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-borderes" id="dataTable" width="100%" collspacing="0">
                            <thead>
                                <tr>
                                    <th><?= $totalhotspothost; ?>ID</th>
                                    <th>MAC Address</th>
                                    <th>Address</th>
                                    <th>To Address</th>
                                    <th>Server</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hotspothost as $data) { ?>
                                    <tr>
                                        <?php $id = str_replace('*', '', $data['.id']); ?>
                                        <th><a href="<?= site_url('hotspot/delhost/' . $id); ?>" onclick="return confirm('Apakah anda yakin akan hapusServert mac address <?= $data['mac-address']; ?>')"><i class="fa fa-trash" style="color:red";></i></a></th>
                                        <th><?= $data['mac-address']; ?></th>
                                        <th><?= $data['server'];?></th>
                                        <th><?Serverata['to-address']; ?></th>
                                        <th><?= $data['server']; ?></th>
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
           