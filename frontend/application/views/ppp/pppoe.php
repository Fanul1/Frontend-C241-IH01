<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3><?= $title; ?></h3>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-pppoe-server">
                Add PPPoE Server
            </button>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service Name</th>
                        <th>Interface</th>
                        <th>Max MTU</th>
                        <th>Max MRU</th>
                        <th>MRRU</th>
                        <th>Default Profile</th>
                        <th>Authentication</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pppoe_servers)): ?>
                        <?php foreach ($pppoe_servers as $key => $server): ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $server['service-name']; ?></td>
                                <td><?= $server['interface']; ?></td>
                                <td><?= $server['max-mtu']; ?></td>
                                <td><?= $server['max-mru']; ?></td>
                                <td><?= $server['mrru']; ?></td>
                                <td><?= $server['default-profile']; ?></td>
                                <td><?= $server['authentication']; ?></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#modal-edit-pppoe-server"
                                        data-id="<?= $server['.id']; ?>" data-service-name="<?= $server['service-name']; ?>"
                                        data-interface="<?= $server['interface']; ?>" data-max-mtu="<?= $server['max-mtu']; ?>"
                                        data-max-mru="<?= $server['max-mru']; ?>" data-mrru="<?= $server['mrru']; ?>"
                                        data-default-profile="<?= $server['default-profile']; ?>"
                                        data-authentication="<?= $server['authentication']; ?>">
                                        <i class="fa fa-edit" style="font-size:25px"></i>
                                    </a>
                                    <?php $id = str_replace('*', '', $server['.id']); ?>
                                    <a href="<?= site_url('ppp/deletePppoeServer/' . $id); ?>"
                                        onclick="return confirm('Are you sure you want to delete this <?= $server['service-name']; ?>?');">
                                        <i class="fa fa-trash" style="color:red;"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">No PPPoE servers found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-pppoe-server" tabindex="-1" aria-labelledby="addPppoeServerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title" id="addPppoeServerModalLabel">Add PPPoE Server</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= site_url('ppp/addPppoeServer') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="service-name">Service Name</label>
                        <input type="text" name="service-name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="interface">Interface</label>
                        <select name="interface" class="form-control" required>
                            <?php foreach ($interfaces as $interface): ?>
                                <option value="<?= $interface['name']; ?>"><?= $interface['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="max-mtu">Max MTU</label>
                        <input type="text" name="max-mtu" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="max-mru">Max MRU</label>
                        <input type="text" name="max-mru" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="mrru">MRRU</label>
                        <input type="text" name="mrru" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="default-profile">Default Profile</label>
                        <select name="default-profile" class="form-control" required>
                            <?php foreach ($profiles as $profile): ?>
                                <option value="<?= $profile['name']; ?>"><?= $profile['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="authentication">Authentication</label>
                        <input type="text" name="authentication" class="form-control">
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
<!-- Edit Modal -->
<div class="modal fade" id="modal-edit-pppoe-server" tabindex="-1" aria-labelledby="editPppoeServerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h4 class="modal-title" id="editPppoeServerModalLabel">Edit PPPoE Server</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= site_url('ppp/editPppoeServer') ?>" method="post">
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-service-name">Service Name</label>
                        <input type="text" name="service-name" id="edit-service-name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-interface">Interface</label>
                        <select name="interface" id="edit-interface" class="form-control" required>
                            <?php foreach ($interfaces as $interface): ?>
                                <option value="<?= $interface['name']; ?>"><?= $interface['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-max-mtu">Max MTU</label>
                        <input type="text" name="max-mtu" id="edit-max-mtu" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-max-mru">Max MRU</label>
                        <input type="text" name="max-mru" id="edit-max-mru" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-mrru">MRRU</label>
                        <input type="text" name="mrru" id="edit-mrru" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-default-profile">Default Profile</label>
                        <select name="default-profile" id="edit-default-profile" class="form-control" required>
                            <?php foreach ($profiles as $profile): ?>
                                <option value="<?= $profile['name']; ?>"><?= $profile['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-authentication">Authentication</label>
                        <input type="text" name="authentication" id="edit-authentication" class="form-control">
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
    $('#modal-edit-pppoe-server').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var serviceName = button.data('service-name');
        var interface = button.data('interface');
        var maxMtu = button.data('max-mtu');
        var maxMru = button.data('max-mru');
        var mrru = button.data('mrru');
        var defaultProfile = button.data('default-profile');
        var authentication = button.data('authentication');

        var modal = $(this);
        modal.find('#edit-id').val(id);
        modal.find('#edit-service-name').val(serviceName);
        modal.find('#edit-interface').val(interface);
        modal.find('#edit-max-mtu').val(maxMtu);
        modal.find('#edit-max-mru').val(maxMru);
        modal.find('#edit-mrru').val(mrru);
        modal.find('#edit-default-profile').val(defaultProfile);
        modal.find('#edit-authentication').val(authentication);
    });
</script>