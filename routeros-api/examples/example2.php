<?php

require('../routeros_api.class.php');

$API = new RouterosAPI();

if ($API->connect('id-18.hostddns.us:7895', 'user1', '123')) {

   $userhotspot = $API->comm('/ip/hotspot/user/print');
   $result = json_encode($userhotspot);
   echo $result;

   $API->disconnect();

}

?>
