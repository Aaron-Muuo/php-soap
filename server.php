<?php

class server{

    function __construct()
    {
        
    }

    function getStudentRecord($id)
    {

        //can connect to the database and fetch some data
        return 'Sam';

    }
}


//define parameters
$params = array('uri'=>'http://127.0.0.1:8081/server.php');

//create a new instance of SOAP server
$server = new SoapServer(NULL, $params);

//export this class to be used by the client
$server->setClass('server');

//start the handle
$server->handle();

?>