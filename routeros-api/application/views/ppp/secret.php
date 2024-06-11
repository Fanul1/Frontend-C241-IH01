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
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Service</th>
                                    <th>Profile</th>
                                    <th>Local Address</th>
                                    <th>Remote Address</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($secret as $data) { ?>
                                    <tr>
                                        <?php $id = str_replace('*', '', $data['.id']); ?>
                                        <td><?= $data['name']; ?></td>
                                        <td><?= $data['password']; ?></td>
                                        <td><?= $data['service']; ?></td>
                                        <td><?= $data['profile']; ?></td>
                                        <?php
                                        $profileName = $data['profile'];
                                        $profileInfo = array_filter($profile, function ($item) use ($profileName) {
                                            return $item['name'] === $profileName;
                                        });
                                        $profileData = !empty($profileInfo) ? reset($profileInfo) : [];
                                        $localAddress = $profileData['local-address'] ?? '-';
                                        $remoteAddress = $profileData['remote-address'] ?? '-';
                                        ?>
                                        <td><?= $localAddress; ?></td>
                                        <td><?= $remoteAddress; ?></td>
                                        <td><?= $data['comment']; ?></td>
                                        <td>
                                            <a href="<?= site_url('ppp/delSecret/' . $id); ?>"
                                               onclick="return confirm('Apakah anda yakin akan hapus user <?= $data['name']; ?>?')">
                                                <i class="fa fa-trash" style="color:red;"></i>
                                            </a>
                                            <!-- EDIT -->
                                            <a href="#" id="edit" 
                                               data-name="<?= $data['name']; ?>" 
                                               data-password="<?= $data['password']; ?>" 
                                               data-id="<?= $data['.id']; ?>" 
                                               data-service="<?= $data['service']; ?>" 
                                               data-profile="<?= $data['profile']; ?>" 
                                               data-comment="<?= $data['comment']; ?>" 
                                               data-localaddress="<?= $data['local-address']; ?>" 
                                               data-remoteaddress="<?= $data['remote-address']; ?>" 
                                               data-toggle="modal" 
                                               data-target="#modal-edit" 
                                               title="Edit">
                                                <i class="fa fa-edit" style="font-size:25px"></i>
                                            </a>
                                            <!-- EDIT -->
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

<!-- MODAL TAMBAH SECRET -->
<div class="modal fade" id="modal-add-user" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title">Add <?= $title; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-add-user" action="<?= site_url('ppp/addpppsecret') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" autocomplete="off" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="service">Service</label>
                        <select name="service" class="form-control" required>
                            <option value="">-Select-</option>
                            <option value="pppoe">pppoe</option>
                            <option value="l2tp">l2tp</option>
                            <option value="ovpn">ovpn</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profile">Profile</label>
                        <select name="profile" autocomplete="off" class="form-control" required>
                            <?php foreach ($profile as $data) { ?>
                                <option value="<?= $data['name']; ?>"><?= $data['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php if ($profileRequiresAddress): ?>
                        <!-- Display address fields if profile requires -->
                        <div class="form-group">
                            <label for="localaddress">Local Address</label>
                            <input type="text" name="localaddress" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="remoteaddress">Remote Address</label>
                            <input type="text" name="remoteaddress" class="form-control" autocomplete="off">
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <input type="text" name="comment" class="form-control">
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

<!-- MODAL EDIT SECRET -->
<div class="modal fade" id="modal-edit" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title">Edit <?= $title; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= site_url('ppp/editpppsecret') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user">User</label>
                        <input type="hidden" name="id" id="id">
                        <input type="text" name="user" autocomplete="off" class="form-control" id="user" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="service">Service</label>
                        <select name="service" id="service" class="form-control" required>
                            <option value="">-Select-</option>
                            <option value="pppoe">pppoe</option>
                            <option value="l2tp">l2tp</option>
                            <option value="ovpn">ovpn</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profile">Profile</label>
                        <select name="profile" id="profile" autocomplete="off" class="form-control">
                            <?php foreach ($profile as $data) { ?>
                                <option value="<?= $data['name']; ?>"><?= $data['name']; ?></option>
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

<script>
    $(document).on('click', '#edit', function () {
        $('#id').val($(this).data('id'));
        $('#user').val($(this).data('name'));
        $('#password').val($(this).data('password'));
        $('#service').val($(this).data('service'));
        $('#profile').val($(this).data('profile'));
        $('#localaddress').val($(this).data('localaddress'));
        $('#remoteaddress').val($(this).data('remoteaddress'));
        $('#comment').val($(this).data('comment'));
    });
</script>
