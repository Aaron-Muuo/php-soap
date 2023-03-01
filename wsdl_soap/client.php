<?php

require 'vendor\econea\nusoap\src\nusoap.php';

$client = new nusoap_client('http://127.0.0.1:8081/services.php?wsdl');

$response = $client->call('getName',array('name'=>'Aaron'));
// $result = json_decode($response, true);
var_dump($response);

?>