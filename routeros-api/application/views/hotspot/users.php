<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Hotspot Users</h3>
            <div class="card-body">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-user">
                    Add User
                </button>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-borderes" id="dataTable" width="100%" collspacing="0">
                            <thead>
                                <tr>
									<th>Username</th>
                                    <th>Password</th>
                                    <th>Profile</th>
                                    <th>Uptime</th>
                                    <th>Bytes In</th>
                                    <th>Bytes Out</th>
                                    <th>Comment</th>
                                    <th><?= $totalhotspotuser; ?>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hotspotuser as $data) { ?>
                                    <tr>
										<th><?= $data['name']; ?></th>
										<th><?= $data['password']; ?></th>
                                        <th><?= $data['profile']; ?></th>
                                        <th><?= $data['uptime']; ?></th>
                                        <th style="text-align: right;"><?= formatBytes($data['bytes-in'], 2); ?></th>
                                        <th style="text-align: right;"><?= formatBytes($data['bytes-out'], 3); ?></th>
                                        <th><?= $data['comment']; ?></th>
										<?php $id = str_replace('*', '', $data['.id']); ?>
										<th><a href="<?= site_url('hotspot/delUser/' . $id); ?>" onclick="return confirm('Apakah anda yakin akan hapus user <?= $data['name']; ?>')"><i class="fa fa-trash" style="color:red";></i></a>
										<a href="<?= site_url('hotspot/editUser/' . $id); ?>"><i class="fa fa-edit" class=" btn btn-primary";></i></a></th>
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
                <h4 class="modal-title">Add User Hotspot</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= site_url('hotspot/addUser') ?>" method="post">
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
                        <label for="server">Server</label>
                        <select name="server" id="server" class="form-control">
                            <option >all</option>
                            <?php foreach ($server as $data) { ?>
                                <option><?= $data['name']; ?></option>
                            <?php } ?>
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
                        <label for="timelimit">Time Limit</label>
                        <input type="text" name="timelimit" class="form-control" autocomplete="off" id="timelimit">
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
