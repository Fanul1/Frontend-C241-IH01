<?php

require('../routeros_api.class.php');

$API = new RouterosAPI();

if ($API->connect('id-18.hostddns.us:7895', 'user1', '123')) {

   $interface = $API->comm('/interface/print');
   $result = json_encode($interface);
   echo $result;

   $API->disconnect();

}

?>
