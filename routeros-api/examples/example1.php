<?php

require('../routeros_api.class.php');

$API = new RouterosAPI();

if ($API->connect('192.168.100.54:8728', 'user1', '123')) {

   $interface = $API->comm('/interface/print');
   $result = json_encode($interface);
   echo $result;

   $API->disconnect();

}

?>
