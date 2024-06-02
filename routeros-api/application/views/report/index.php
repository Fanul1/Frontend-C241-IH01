<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Report</h3>
            <div class="overflow box-bordered" style="max-height: 70vh">
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
                            echo "<td style='text-align:right;'>" . $row['price'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
