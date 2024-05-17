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
<div class="modal fade" id="modal-add-user" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title">Add <?= $title; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= site_url('ppp/addpppsecret') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user">User</label>
                        <input type="text" name="user" autocomplete="off" class="form-control" id="user" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="service">Service</label>
                        <select name="service" id="service" class="form-control" required>
                            <option value="">-Pilih-</option>
                            <option value="pppoe">pppoe</option>
                            <option value="l2tp">l2tp</option>
                            <option value="ovpn">ovpn</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profile">Profiles</label>
                        <select name="profile" id="profile" autocomplete="off" class="form-control">
                            <?php foreach ($profile as $data) { ?>
                                <option><?= $data['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="localaddress">Local Address</label>
                        <input type="text" name="localaddress" class="form-control" autocomplete="off" id="localaddress">
                    </div>
                    <div class="form-group">
                        <label for="remoteaddress">Remote Address</label>
                        <input type="text" name="remoteaddress" class="form-control" autocomplete="off" id="remoteaddress">
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <input type="text" name="comment" class="form-control" id="comment">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-light">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
