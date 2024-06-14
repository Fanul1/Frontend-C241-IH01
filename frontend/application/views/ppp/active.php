<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3><?= $title; ?></h3>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Service</th>
                        <th>Caller ID</th>
                        <th>Address</th>
                        <th>Uptime</th>
                        <th>Encoding</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($active_connections)) : ?>
                        <?php foreach ($active_connections as $key => $connection) : ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $connection['name']; ?></td>
                                <td><?= $connection['service']; ?></td>
                                <td><?= $connection['caller-id']; ?></td>
                                <td><?= $connection['address']; ?></td>
                                <td><?= $connection['uptime']; ?></td>
                                <td><?= $connection['encoding']; ?></td>
                                <td>
                                    <?php $id = str_replace('*', '', $connection['.id']); ?>
                                    <a href="<?= site_url('ppp/deleteActiveConnection/' . $id); ?>"
                                       onclick="return confirm('Are you sure you want to delete this active connection?');">
                                        <i class="fa fa-trash" style="color:red;"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8">No active connections found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
