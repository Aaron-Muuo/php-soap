<?php

ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache
$server = new SoapServer("http://localhost/wsdl.php?WSDL");	// Locate WSDL file to learn structure of functions
$server->addFunction("ChooseColour");	// Same func name as in our WSDL XML, and below
$server->handle();  

function ChooseColour($formdata) {
    $attempt = false; // File writing attempt successful or not
    $formdata = get_object_vars($formdata); // Pull parameters from SOAP connection
    
    // Sort out the parameters and grab their data
    $myname = $formdata['Name']; 
    $mycolour = $formdata['FavColour'];
    $mynumber = $formdata['FavNumber'];
    
    $str =  "Name: " . $myname . ", ";
    $str .= "Colour: " . $mycolour . ", ";
    $str .= "Number: " . $mynumber . "\r\n";
    
    $filename = "./formdata.txt";
    if (($fp = fopen($filename, "a")) == false) return array('Success' => false);
    if (fwrite($fp, $str)) {
    	$attempt = true;
    }
    fclose($fp);     

    return array('Success' => $attempt);
}

?>