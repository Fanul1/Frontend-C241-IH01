<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Hotspot Users</h3>
            <div class="card-body">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-user">
                    Add User
                </button>
                <button type="button" class="btn btn-secondary ml-3" data-toggle="modal" data-target="#modal-generate">
                    Generate User
                </button>
                <button type="button" class="btn btn-secondary ml-3" data-toggle="modal" data-target="">
                    Print
                </button>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Profile</th>
                                    <th>Uptime</th>
                                    <th>Bytes In</th>
                                    <th>Bytes Out</th>
                                    <th>Comment</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hotspotuser as $data) { ?>
                                    <tr>
                                        <td><?= $data['name']; ?></td>
                                        <td><?= $data['password']; ?></td>
                                        <td><?= $data['profile']; ?></td>
                                        <td><?= $data['uptime']; ?></td>
                                        <td style="text-align: right;"><?= formatBytes($data['bytes-in'], 2); ?></td>
                                        <td style="text-align: right;"><?= formatBytes($data['bytes-out'], 3); ?></td>
                                        <td><?= $data['comment']; ?></td>
                                        <?php $id = str_replace('*', '', $data['.id']); ?>
                                        <td>
                                            <a href="<?= site_url('hotspot/delUser/' . $id); ?>"
                                                onclick="return confirm('Apakah anda yakin akan hapus user <?= $data['name']; ?>')">
                                                <i class="fa fa-trash" style="color:red;"></i>
                                            </a>
                                            <a href="<?= site_url('hotspot/editUser/' . $id); ?>">
                                                <i class="fa fa-edit" style="color:blue;"></i>
                                            </a>
                                        </td>
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
                            <option>all</option>
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
    </div>
</div>

<div class="modal fade" id="modal-generate" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title">Generate User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add the print button here -->
                <button onclick="window.print()" class="btn btn-secondary mb-3">Print</button>

                <form id="generate-user-form" action="<?= site_url('hotspot/generateUsers') ?>" method="post">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Qty (jumlah)</td>
                                <td><input type="number" name="qty" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Server</td>
                                <td>
                                    <select name="server" class="form-control" required>
                                        <?php foreach ($server as $srv): ?>
                                            <option value="<?= $srv['name'] ?>"><?= $srv['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>User Mode</td>
                                <td>
                                    <select name="user_mode" class="form-control" required>
                                        <option value="same">Username = Password</option>
                                        <option value="different">Username & Password</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Name Length</td>
                                <td><input type="number" name="name_length" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>Prefix</td>
                                <td><input type="text" name="prefix" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Character</td>
                                <td>
                                    <select name="character" class="form-control" required>
                                        <option value="alphanumeric">Alphanumeric</option>
                                        <option value="numeric">Numeric</option>
                                        <option value="alphabet">Alphabet</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Profile</td>
                                <td>
                                    <select name="profile" class="form-control" required>
                                        <?php foreach ($profile as $prof): ?>
                                            <option value="<?= $prof['name'] ?>"><?= $prof['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Time Limit</td>
                                <td><input type="text" name="time_limit" class="form-control"
                                        placeholder="Format: 30d, 12h, 4w3d"></td>
                            </tr>
                            <tr>
                                <td>Data Limit</td>
                                <td><input type="text" name="data_limit" class="form-control"
                                        placeholder="Example: 500MB, 2GB"></td>
                            </tr>
                            <tr>
                                <td>Comment</td>
                                <td><input type="text" name="comment" class="form-control"></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="generate-user-form" class="btn btn-primary">Generate</button>
            </div>
        </div>
    </div>
</div>
