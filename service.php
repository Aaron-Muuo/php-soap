<?php

//inclide the client file
include './client.php';

//define the data
$id_param = array('id'=>'1');

echo $client->getName($id);

?>