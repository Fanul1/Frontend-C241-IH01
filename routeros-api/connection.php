<?php

require('routeros_api.class.php');

$API = new RouterosAPI();

if ($API->connect('id-18.hostddns.us', 'user1', '123')) {

}

?>
