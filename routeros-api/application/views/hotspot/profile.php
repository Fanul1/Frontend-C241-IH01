<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Hotspot <?= $title; ?></h3>
            <div class="card-body">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-profile">
                    Add Profile
                </button>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Shared Users</th>
                                    <th>Rate limit</th>
                                    <th>Expired Mode</th>
                                    <th>Validity</th>
                                    <th>Price Rp</th>
                                    <th>Selling Price Rp</th>
                                    <th>Lock User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hotspotprofile as $data) { ?>
                                    <tr>
                                        <td><?= $data['name']; ?></td>
                                        <td><?= $data['shared-users']; ?></td>
                                        <td><?= $data['rate-limit']; ?></td>
                                        <td><?= $data['expired-mode']; ?></td>
                                        <td><?= $data['validity']; ?></td>
                                        <td><?= $data['price']; ?></td>
                                        <td><?= $data['selling-price']; ?></td>
                                        <td><?= $data['lock-user']; ?></td>
                                        <td>
                                            <?php $id = str_replace('*', '', $data['.id']); ?>
                                            <a href="<?= site_url('hotspot/delProfile/' . $id); ?>"
                                                onclick="return confirm('Apakah anda yakin akan hapus profile <?= $data['name']; ?>')">
                                                <i class="fa fa-trash" style="color:red"></i>
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
<div class="modal fade" id="modal-add-profile" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title">Add User Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= site_url('hotspot/addUserProfile') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" autocomplete="off" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="address_pool">Address Pool</label>
                        <select name="address_pool" class="form-control" id="address_pool" required>
                            <option value="none">None</option>
                            <?php foreach ($address_pools as $pool): ?>
                                <option value="<?= $pool['name'] ?>"><?= $pool['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="shared_users">Shared Users</label>
                        <input type="number" name="shared_users" class="form-control" id="shared_users" required>
                    </div>
                    <div class="form-group">
                        <label for="rate_limit">Rate Limit [up/down]</label>
                        <input type="text" name="rate_limit" class="form-control" id="rate_limit"
                            placeholder="Example: 512k/1M" required>
                    </div>
                    <div class="form-group">
                        <label for="expired_mode">Expired Mode</label>
                        <select name="expired_mode" class="form-control" id="expired_mode" required onchange="toggleValidityField()">
                            <option value="None">None</option>
                            <option value="Remove">Remove</option>
                            <option value="Notice">Notice</option>
                            <option value="Remove & Record">Remove & Record</option>
                            <option value="Notice & Record">Notice & Record</option>
                        </select>
                    </div>
                    <div class="form-group" id="validity_group" style="display: none;">
                        <label for="validity">Validity</label>
                        <input type="text" name="validity" class="form-control" id="validity">
                    </div>
                    <div class="form-group">
                        <label for="price_rp">Price Rp</label>
                        <input type="text" name="price_rp" class="form-control" id="price_rp">
                    </div>
                    <div class="form-group">
                        <label for="selling_price_rp">Selling Price Rp</label>
                        <input type="text" name="selling_price_rp" class="form-control" id="selling_price_rp">
                    </div>
                    <div class="form-group">
                        <label for="lock_user">Lock User</label>
                        <select name="lock_user" class="form-control" id="lock_user" required>
                            <option value="Disable">Disable</option>
                            <option value="Enable">Enable</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="parent_queue">Parent Queue</label>
                        <select name="parent_queue" class="form-control" id="parent_queue">
                            <option value="none">None</option>
                            <?php foreach ($parent_queues as $queue): ?>
                                <option value="<?= $queue['name'] ?>"><?= $queue['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
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
    function toggleValidityField() {
        const expiredMode = document.getElementById('expired_mode').value;
        const validityGroup = document.getElementById('validity_group');
        if (expiredMode === 'Remove' || expiredMode === 'Notice' || expiredMode === 'Remove & Record' || expiredMode === 'Notice & Record') {
            validityGroup.style.display = 'block';
        } else {
            validityGroup.style.display = 'none';
        }
    }
</script>
