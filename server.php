<?php

class server{


    public static function authenticate($header_params){
        if($header_params->username == 'Aaron' && $header_params->password == 'root'){
            return true;
        }else{
            throw new SoapFault('Wrong user/pass', 401);
        }
    }

    function __construct()
    {
        
    }

    function getStudentRecord($id)
    {

        //can connect to the database and fetch some data
        //do some operations
        //retuen result
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