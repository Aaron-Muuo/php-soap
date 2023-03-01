<?php
$functions = array();
/*****************************************************************************
 * To access this WSDL specification run via: /wsdl.php?WSDL
 * Any other access to this WSDL will display as a HTML document
 * 
 * 2013 (C) Copyright Lyndon Leverington / DarkerWhite
 *****************************************************************************
 * Set up the web service parameters:
 * $serviceName: Plain Text to display when someone accesses this service 
 *               without the ?WSDL parameter in the URL. Whitespaces are
 *               removed from this and this is then used as the ID for the 
 *               XML in the WSDL. Please only use A-Z, 0-9 and spaces.
 *
 * Declare all Functions for this Web Service
 * $functions Array Parameters:
 *  funcName - Name of the particular function being served
 *  doc - Documentation to report from Web Service regarding this function
 *  inputParams - An array of arrays where name = name of field and type = data type
 *                  Omit if not required
 *  outputParams - As above, but for responses
 *                  Omit if not required
 *  soapAddress - The php file to send to to process SOAP requests                
 *****************************************************************************/

    $serviceName = "My Example Web Service Access Point";

    $functions[] = array("funcName" => "ChooseColour",
                         "doc" => "Send a favourite colour and number to a text file.",
                         "inputParams" => array(array("name" => "Name", "type" => "string"),
                                                array("name" => "FavColour", "type" => "string"),
                                                array("name" => "FavNumber", "type" => "int")),
                         "outputParams" => array(array("name" => "Success", "type" => "boolean")),
                         "soapAddress" => "http://127.0.0.1:8081/soap-service.php"
                         );

// ----------------------------------------------------------------------------
// END OF PARAMETERS SET UP
// ----------------------------------------------------------------------------
                         
/*****************************************************************************
 * Process Page / Request
 *****************************************************************************/

    if (stristr($_SERVER['QUERY_STRING'], "wsdl")) {
    	// WSDL request - output raw XML
		header("Content-Type: application/soap+xml; charset=utf-8");
        echo DisplayXML();
    } else {
    	// Page accessed normally - output documentation
    	$cp = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); // Current page
    	echo '<!-- Attention: To access via a SOAP client use ' . $cp . '?WSDL -->';
    	echo '<html>';
    	echo '<head><title>' . $serviceName . '</title></head>';
    	echo '<body>';
    	echo '<h1>' . $serviceName . '</h1>';
        echo '<p style="margin-left:20px;">To access via a SOAP client use <code>' . $cp . '?WSDL</code></p>';
    	
        // Document each function
        echo '<h2>Available Functions:</h2>';
        echo '<div style="margin-left:20px;">';
        for ($i=0;$i<count($functions);$i++) {
            echo '<h3>Function: ' . $functions[$i]['funcName'] . '</h3>';
            echo '<div style="margin-left:20px;">';
            echo '<p>';
            echo $functions[$i]['doc'];
            echo '<ul>';
            if (array_key_exists("inputParams", $functions[$i])) {
            	echo '<li>Input Parameters:<ul>';
            	for ($j=0;$j<count($functions[$i]['inputParams']);$j++) {
            	   	echo '<li>' . $functions[$i]['inputParams'][$j]['name'];
            	   	echo ' (' . $functions[$i]['inputParams'][$j]['type'];
            	   	echo ')</li>';
            	}
            	echo '</ul></li>';
            }
            if (array_key_exists("outputParams", $functions[$i])) {
                echo '<li>Output Parameters:<ul>';
                for ($j=0;$j<count($functions[$i]['outputParams']);$j++) {
                    echo '<li>' . $functions[$i]['outputParams'][$j]['name'];
                    echo ' (' . $functions[$i]['outputParams'][$j]['type'];
                    echo ')</li>';
                }
                echo '</ul></li>';
            }
            echo '</ul>';
            echo '</p>';
            echo '</div>';
        }
        echo '</div>';
        	
    	echo '<h2>WSDL output:</h2>';
        echo '<pre style="margin-left:20px;width:800px;overflow-x:scroll;border:1px solid black;padding:10px;background-color:#D3D3D3;">';
        echo DisplayXML(false);
        echo '</pre>';
        echo '</body></html>';
    }
                         
    exit; 
    
/*****************************************************************************
 * Create WSDL XML 
 * @PARAM xmlformat=true - Display output in HTML friendly format if set false
 *****************************************************************************/
function DisplayXML($xmlformat=true) {
	global $functions;         // Functions that this web service supports
	global $serviceName;       // Web Service ID
	$i = 0;                    // For traversing functions array
	$j = 0;                    // For traversing parameters arrays
	$str = '';                 // XML String to output
	
	// Tab spacings
	$t1 = '    ';
	if (!$xmlformat) $t1 = '&nbsp;&nbsp;&nbsp;&nbsp;';
	$t2 = $t1 . $t1;
	$t3 = $t2 . $t1;
	$t4 = $t3 . $t1;
	$t5 = $t4 . $t1;
	
	$serviceID = str_replace(" ", "", $serviceName);
	
	// Declare XML format
    $str .= '<?xml version="1.0" encoding="UTF-8" standalone="no"?>' . "\n\n";
    
    // Declare definitions / namespaces
    $str .= '<wsdl:definitions ' . "\n"; 
    $str .= $t1 . 'xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/" ' . "\n";
    $str .= $t1 . 'xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/" ' . "\n";
    $str .= $t1 . 'xmlns:s="http://www.w3.org/2001/XMLSchema" ' . "\n"; 
    $str .= $t1 . 'targetNamespace="http://www.darkerwhite.com/" ' . "\n";
    $str .= $t1 . 'xmlns:tns="http://www.darkerwhite.com/" ' . "\n"; 
    $str .= $t1 . 'name="' . $serviceID . '" ' . "\n";
    $str .= '>' . "\n\n";
	
	// Declare Types / Schema
    $str .= '<wsdl:types>' . "\n";
    $str .= $t1 . '<s:schema elementFormDefault="qualified" targetNamespace="http://www.darkerwhite.com/">' . "\n";
    for ($i=0;$i<count($functions);$i++) {
    	// Define Request Types
    	if (array_key_exists("inputParams", $functions[$i])) {
    	   $str .= $t2 . '<s:element name="' . $functions[$i]['funcName'] . 'Request">' . "\n";
    	   $str .= $t3 . '<s:complexType><s:sequence>' . "\n";
    	   for ($j=0;$j<count($functions[$i]['inputParams']);$j++) {
    	       $str .= $t4 . '<s:element minOccurs="1" maxOccurs="1" ';
    	       $str .= 'name="' . $functions[$i]['inputParams'][$j]['name'] . '" ';
    	       $str .= 'type="s:' . $functions[$i]['inputParams'][$j]['type'] . '" />' . "\n";	
    	   }
    	   $str .= $t3 . '</s:sequence></s:complexType>' . "\n";
           $str .= $t2 . '</s:element>' . "\n";
    	}
    	// Define Response Types
        if (array_key_exists("outputParams", $functions[$i])) {
           $str .= $t2 . '<s:element name="' . $functions[$i]['funcName'] . 'Response">' . "\n";
           $str .= $t3 . '<s:complexType><s:sequence>' . "\n";
           for ($j=0;$j<count($functions[$i]['outputParams']);$j++) {
               $str .= $t4 . '<s:element minOccurs="1" maxOccurs="1" ';
               $str .= 'name="' . $functions[$i]['outputParams'][$j]['name'] . '" ';
               $str .= 'type="s:' . $functions[$i]['outputParams'][$j]['type'] . '" />' . "\n";    
           }
           $str .= $t3 . '</s:sequence></s:complexType>' . "\n";
           $str .= $t2 . '</s:element>' . "\n";
        }    	
    }
    $str .= $t1 . '</s:schema>' . "\n";
    $str .= '</wsdl:types>' . "\n\n";

    // Declare Messages
    for ($i=0;$i<count($functions);$i++) {
    	// Define Request Messages
        if (array_key_exists("inputParams", $functions[$i])) {
        	$str .= '<wsdl:message name="' . $functions[$i]['funcName'] . 'Request">' . "\n";
            $str .= $t1 . '<wsdl:part name="parameters" element="tns:' . $functions[$i]['funcName'] . 'Request" />' . "\n";
            $str .= '</wsdl:message>' . "\n";
        }
        // Define Response Messages
        if (array_key_exists("outputParams", $functions[$i])) {
            $str .= '<wsdl:message name="' . $functions[$i]['funcName'] . 'Response">' . "\n";
            $str .= $t1 . '<wsdl:part name="parameters" element="tns:' . $functions[$i]['funcName'] . 'Response" />' . "\n";
            $str .= '</wsdl:message>' . "\n\n";
        }
    }

    // Declare Port Types
    for ($i=0;$i<count($functions);$i++) {
    	$str .= '<wsdl:portType name="' . $functions[$i]['funcName'] . 'PortType">' . "\n";
    	$str .= $t1 . '<wsdl:operation name="' . $functions[$i]['funcName'] . '">' . "\n";
    	if (array_key_exists("inputParams", $functions[$i])) 
    	   $str .= $t2 . '<wsdl:input message="tns:' . $functions[$i]['funcName'] . 'Request" />' . "\n";
    	if (array_key_exists("outputParams", $functions[$i])) 
           $str .= $t2 . '<wsdl:output message="tns:' . $functions[$i]['funcName'] . 'Response" />' . "\n";
        $str .= $t1 . '</wsdl:operation>' . "\n";
    	$str .= '</wsdl:portType>' . "\n\n";
    }
    
    // Declare Bindings
    for ($i=0;$i<count($functions);$i++) {
        $str .= '<wsdl:binding name="' . $functions[$i]['funcName'] . 'Binding" type="tns:' . $functions[$i]['funcName'] . 'PortType">' . "\n";
        $str .= $t1 . '<soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http" />' . "\n";
        $str .= $t1 . '<wsdl:operation name="' . $functions[$i]['funcName'] . '">' . "\n";
        $str .= $t2 . '<soap:operation soapAction="' . $functions[$i]['soapAddress'] . '#' . $functions[$i]['funcName'] . '" style="document" />' . "\n";
        if (array_key_exists("inputParams", $functions[$i]))
            $str .= $t2 . '<wsdl:input><soap:body use="literal" /></wsdl:input>' . "\n";
        if (array_key_exists("outputParams", $functions[$i]))
            $str .= $t2 . '<wsdl:output><soap:body use="literal" /></wsdl:output>' . "\n";
    	$str .= $t2 . '<wsdl:documentation>' . $functions[$i]['doc'] . '</wsdl:documentation>' . "\n";
        $str .= $t1 . '</wsdl:operation>' . "\n";
    	$str .= '</wsdl:binding>' . "\n\n";
    }
    
    // Declare Service
    $str .= '<wsdl:service name="' . $serviceID . '">' . "\n";
    for ($i=0;$i<count($functions);$i++) {
        $str .= $t1 . '<wsdl:port name="' . $functions[$i]['funcName'] . 'Port" binding="tns:' . $functions[$i]['funcName'] . 'Binding">' . "\n";
        $str .= $t2 . '<soap:address location="' . $functions[$i]['soapAddress'] . '" />' . "\n";
        $str .= $t1 . '</wsdl:port>' . "\n";
    }
    $str .= '</wsdl:service>' . "\n\n";
    
    // End Document
    $str .= '</wsdl:definitions>' . "\n";
    
    if (!$xmlformat) $str = str_replace("<", "&lt;", $str); 
    if (!$xmlformat) $str = str_replace(">", "&gt;", $str);
    if (!$xmlformat) $str = str_replace("\n", "<br />", $str);
    return $str;
}

?>