<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3><?= $title; ?></h3>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <table class="table table-striped">
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
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pppoe_servers)) : ?>
                        <?php foreach ($pppoe_servers as $key => $server) : ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $server['service-name']; ?></td>
                                <td><?= $server['interface']; ?></td>
                                <td><?= $server['max-mtu']; ?></td>
                                <td><?= $server['max-mru']; ?></td>
                                <td><?= $server['mrru']; ?></td>
                                <td><?= $server['default-profile']; ?></td>
                                <td><?= $server['authentication']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8">No PPPoE servers found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>