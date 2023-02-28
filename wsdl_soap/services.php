<?php
require 'vendor\econea\nusoap\src\nusoap.php';

require 'func.php';
$server =new nusoap_server();
$server->configureWSDL("Demo","urn:Demo");
$server->register(
	"getName",
	array("name" =>'xsd:string'),
	array("return" =>"xsd:string"),

);
$server->register(
	"adduser",
	array("name" =>'xsd:string'),
	array("return" =>"xsd:string"),
);
$server->register(
	"view_users",
	array("name" =>'xsd:string'),
	array("return" =>"xsd:string"),
);
$server->service(file_get_contents('php://input'));
 ?>