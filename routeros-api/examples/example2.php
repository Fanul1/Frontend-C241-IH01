<?php

require('../routeros_api.class.php');

$API = new RouterosAPI();

if ($API->connect('192.168.1.1:8291', 'user1', '123')) {

   $userhotspot = $API->comm('/ip/hotspot/user/print');
   $result = json_encode($userhotspot);
   echo $result;

   $API->disconnect();

}

?>
