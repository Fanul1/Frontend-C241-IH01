Download (RX) = <?= formatBytes($rx, 2); ?> <br>
Upload (TX) = <?= formatBytes($tx, 2); ?> <br>
<?php
header('Content-Type: application/json');
echo json_encode($traffic_data);
?>
