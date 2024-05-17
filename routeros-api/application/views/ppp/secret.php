<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3><?= $title; ?></h3>
            <div class="card-body">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-user">
                    Add <?= $title; ?>
                </button>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-borderes" id="dataTable" width="100%" collspacing="0">
                            <thead>
                                <tr>
                                    <th><?= $totalsecret; ?></th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Service</th>
                                    <th>Profile</th>                                   
                                    <th>Local Address</th>
                                    <th>Remote Address</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($secret as $data) { ?>
                                    <tr>
                                        <?php $id = str_replace('*', '', $data['.id']); ?>
                                        <th><a href="<?= site_url('ppp/delSecret/' . $id); ?>" onclick="return confirm('Apakah anda yakin akan hapus user <?= $data['name']; ?>')"><i class="fa fa-trash" style="color:red";></i></a>
                                        <a href="<?= site_url('ppp/editSecret/' . $id); ?>"><i class="fa fa-edit" class=" btn btn-primary";></i></a></th>
                                        <th><?= $data['name']; ?></th>
                                        <th><?= $data['password']; ?></th>
                                        <th><?= $data['service']; ?></th>
                                        <th><?= $data['local-address']; ?></th>
                                        <th><?= $data['remote-address']; ?></th>                                       
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
