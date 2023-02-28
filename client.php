<?php

class client{

    function __construct()
    {
        //location is wherwe the script is located
        //uri is loaded from a urn
        //trace is for debugging
        $params = array('location'=>'http://127.0.0.1:8081/server.php', 'uri'=>'urn://127.0.0.1:8081/server.php', 'trace'=>1);

        $this->instance = new SoapClient(NULL, $params);
    }

    public function getName($id_param){
        return $this->instance->__soapCall('getStudentRecord', $id_param);
    }

}

$api_client = new client();

$id_param = array('id'=>'1');

echo $api_client->getName($id_param);

?>