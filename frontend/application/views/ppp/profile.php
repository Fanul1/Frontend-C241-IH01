<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3><?= $title; ?></h3>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-profile">
                Add Profile
            </button>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Local Address</th>
                        <th>Remote Address</th>
                        <th>Bridge</th>
                        <th>Only One</th>
                        <th>Rate Limit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($profiles)): ?>
                        <?php foreach ($profiles as $key => $profile): ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $profile['name']; ?></td>
                                <td><?= isset($profile['local-address']) ? $profile['local-address'] : ''; ?></td>
                                <td><?= isset($profile['remote-address']) ? $profile['remote-address'] : ''; ?></td>
                                <td><?= isset($profile['bridge']) ? $profile['bridge'] : ''; ?></td>
                                <td><?= isset($profile['only-one']) ? $profile['only-one'] : ''; ?></td>
                                <td><?= isset($profile['rate-limit']) ? $profile['rate-limit'] : ''; ?></td>
                                <td>
                                    <a href="#" data-toggle="modal" 
                                        data-target="#modal-edit-profile" data-id="<?= $profile['.id']; ?>"
                                        data-name="<?= $profile['name']; ?>"
                                        data-local-address="<?= $profile['local-address']; ?>"
                                        data-remote-address="<?= $profile['remote-address']; ?>"
                                        data-bridge="<?= $profile['bridge']; ?>" data-only-one="<?= $profile['only-one']; ?>"
                                        data-rate-limit="<?= $profile['rate-limit']; ?>">
                                        <i class="fa fa-edit" style="font-size:25px"></i>
                                    </a>
                                    <?php $id = str_replace('*', '', $profile['.id']); ?>
                                    <a href="<?= site_url('ppp/deleteProfile/' . $id); ?>"
                                        onclick="return confirm('Apakah anda yakin akan hapus profile <?= $profile['name']; ?>?')">
                                        <i class="fa fa-trash" style="color:red;"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No profiles found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL ADD PROFILE -->
<div class="modal fade" id="modal-add-profile" tabindex="-1" aria-labelledby="addProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title" id="addProfileModalLabel">Add PPP Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= site_url('ppp/addProfile') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="local-address">Local Address</label>
                        <input type="text" name="local-address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="remote-address">Remote Address</label>
                        <select name="remote-address-pool" class="form-control">
                            <option value="">-Select Pool-</option>
                            <?php foreach ($pools as $pool): ?>
                                <option value="<?= $pool['name']; ?>"><?= $pool['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="remote-address-manual" class="form-control mt-2"
                            placeholder="Or enter IP address manually">
                    </div>
                    <div class="form-group">
                        <label for="bridge">Bridge</label>
                        <select name="bridge" class="form-control">
                            <option value="">-Select Bridge-</option>
                            <?php foreach ($bridges as $bridge): ?>
                                <option value="<?= $bridge['name']; ?>"><?= $bridge['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="only-one">Only One</label>
                        <select name="only-one" class="form-control">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rate-limit">Rate Limit (tx/rx)</label>
                        <input type="text" name="rate-limit" class="form-control" placeholder="tx/rx">
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
<!-- MODAL EDIT PROFILE -->
<div class="modal fade" id="modal-edit-profile" tabindex="-1" aria-labelledby="editProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title" id="editProfileModalLabel">Edit PPP Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= site_url('ppp/editProfile') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label for="edit-name">Name</label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-local-address">Local Address</label>
                        <input type="text" name="local-address" id="edit-local-address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-remote-address">Remote Address</label>
                        <select name="remote-address-pool" id="edit-remote-address-pool" class="form-control">
                            <option value="">-Select Pool-</option>
                            <?php foreach ($pools as $pool): ?>
                                <option value="<?= $pool['name']; ?>"><?= $pool['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="remote-address-manual" id="edit-remote-address-manual"
                            class="form-control mt-2" placeholder="Or enter IP address manually">
                    </div>
                    <div class="form-group">
                        <label for="edit-bridge">Bridge</label>
                        <select name="bridge" id="edit-bridge" class="form-control">
                            <?php foreach ($bridges as $bridge): ?>
                                <option value="<?= $bridge['name']; ?>"><?= $bridge['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-only-one">Only One</label>
                        <select name="only-one" id="edit-only-one" class="form-control">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-rate-limit">Rate Limit (tx/rx)</label>
                        <input type="text" name="rate-limit" id="edit-rate-limit" class="form-control"
                            placeholder="tx/rx">
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

<script>
    $(document).on('click', '.btn-edit', function () {
        $('#edit-id').val($(this).data('id'));
        $('#edit-name').val($(this).data('name'));
        $('#edit-local-address').val($(this).data('local-address'));

        // Set remote address fields
        var remoteAddress = $(this).data('remote-address');
        var isPool = false;
        $('#edit-remote-address-pool option').each(function () {
            if ($(this).val() === remoteAddress) {
                $(this).prop('selected', true);
                isPool = true;
            }
        });
        if (!isPool) {
            $('#edit-remote-address-manual').val(remoteAddress);
        } else {
            $('#edit-remote-address-manual').val('');
        }

        $('#edit-bridge').val($(this).data('bridge'));
        $('#edit-only-one').val($(this).data('only-one'));
        $('#edit-rate-limit').val($(this).data('rate-limit'));
    });
</script>