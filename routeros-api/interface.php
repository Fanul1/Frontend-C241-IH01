<?php


require('connection.php');

   $interface = $API->comm('/interface/print');
   $result = json_encode($interface);
   echo $result;

   $API->disconnect();

?>
