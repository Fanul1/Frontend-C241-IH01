<?php

require('connection.php');

   $userhotspot = $API->comm('/ip/hotspot/user/print');
//    echo $result;

   foreach ($userhotspot as $data) {
    echo 'Username ='. $data['name'] . 'Password ='. $data['password']. '<br>';
}
   $API->disconnect();
?>
 