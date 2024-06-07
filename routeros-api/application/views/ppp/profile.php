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
                        <th>Name</th>
                        <th>Local Address</th>
                        <th>Remote Address</th>
                        <th>Bridge Learning</th>
                        <th>Use MPLS</th>
                        <th>Use Compression</th>
                        <th>Use Encryption</th>
                        <th>Only One</th>
                        <th>Change TCP MSS</th>
                        <th>Use UPnP</th>
                        <th>Address List</th>
                        <th>On Up</th>
                        <th>On Down</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($profiles)) : ?>
                        <?php foreach ($profiles as $key => $profile) : ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $profile['name']; ?></td>
                                <td><?= $profile['local-address']; ?></td>
                                <td><?= $profile['remote-address']; ?></td>
                                <td><?= $profile['bridge-learning']; ?></td>
                                <td><?= $profile['use-mpls']; ?></td>
                                <td><?= $profile['use-compression']; ?></td>
                                <td><?= $profile['use-encryption']; ?></td>
                                <td><?= $profile['only-one']; ?></td>
                                <td><?= $profile['change-tcp-mss']; ?></td>
                                <td><?= $profile['use-upnp']; ?></td>
                                <td><?= $profile['address-list']; ?></td>
                                <td><?= $profile['on-up']; ?></td>
                                <td><?= $profile['on-down']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="14">No profiles found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
