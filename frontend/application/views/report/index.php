<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Report</h3>
            <div class="overflow box-bordered" style="max-height: 70vh">
                
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="<?php echo base_url('report/export_to_firestore'); ?>" class="btn btn-primary" onclick="return confirm('Apa anda yakin untuk export?')">Export to Firestore</a>
                    <a href="<?php echo base_url('report/export_to_csv'); ?>" class="btn btn-success ml-2" onclick="return confirm('Apa anda yakin untuk export?')">Export to CSV</a>
                </div>
                <div>
                    <?php
                    // Calculate total earnings
                    $totalEarnings = 0;
                    foreach ($dataDump as $row) {
                        $totalEarnings += $row['price'];
                    }
                    ?>
                    <!-- Display total earnings -->
                    <strong>Total Earnings: Rp. </strong><?php echo number_format($totalEarnings, 2); ?>
                </div>
            </div>



                <table id="dataTable" class="table table-bordered table-hover text-nowrap">
                    <thead class="thead-light">
                        <tr>
                            <th>&#8470;</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Username</th>
                            <th>Profile</th>
                            <th>Comment</th>
                            <th style="text-align:right;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dataDump as $index => $row) {
                            echo "<tr>";
                            echo "<td>" . ($index + 1) . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['time'] . "</td>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['profile'] . "</td>";
                            echo "<td>" . $row['comment'] . "</td>";
                            echo "<td style='text-align:right;'>" . number_format($row['price'], 2) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add this CSS to style the elements -->
<style>
    .d-flex {
        display: flex;
    }
    .justify-content-between {
        justify-content: space-between;
    }
    .align-items-center {
        align-items: center;
    }
    .mb-3 {
        margin-bottom: 1rem;
    }
</style>
