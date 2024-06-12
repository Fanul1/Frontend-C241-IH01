<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Log User</h3>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <a href="<?php echo base_url('log/export_to_csv_user'); ?>" class="btn btn-success mb-5" onclick="return confirm('Apa anda yakin untuk export?')">Export to CSV</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Username</th>
                            <th>Address</th>
                            <th>Mac Address</th>
                            <th>Validity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logData as $log): ?>
                            <tr>
                                <td><?= $log['Date'] ?></td>
                                <td><?= $log['Time'] ?></td>
                                <td><?= $log['Username'] ?></td>
                                <td><?= $log['Address'] ?></td>
                                <td><?= $log['MacAddress'] ?></td>
                                <td><?= $log['Validity'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
