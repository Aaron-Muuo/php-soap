<?php

function getName($name)
{
	$conn=mysqli_connect("localhost","root","admin","api_db");
	if (mysqli_connect_error()) {
		echo "Failed to connect to mysql:".mysqli_connect_error();
		die();
	}
	$result= mysqli_query($conn, "SELECT * FROM api_table WHERE name='$name' ");
	$retstr="";
	if (mysqli_num_rows($result)>0) {
		while ($row=mysqli_fetch_array($result)) {
			$response[]= $row;
		}
		return json_encode($response);
	}
	else{
		return "No data";
	}
}
function adduser($name,$email,$phone){
	
	$conn=mysqli_connect("localhost","root","admin","api_db");
	if (mysqli_connect_error()) {
		echo "Failed to connect to mysql:".mysqli_connect_error();
		die();
	}
		$result= mysqli_query($conn, "INSERT INTO api_table (name,email,phone) VALUES('$name','$email','$phone')");
	$retstr="";
	if ($result) {
		$response="Successfully inserted";
		return json_encode($response);
	}
	else{
		return "Failed to insert";
	}

	
}
function view_users(){

	$response= "Type your name here";

	return json_encode($response);

	
	// $conn=mysqli_connect("localhost","root","admin","api_db");
	// if (mysqli_connect_error()) {
	// 	echo "Failed to connect to mysql:".mysqli_connect_error();
	// 	die();
	// }
	// $result= mysqli_query($conn, "SELECT * FROM api_table ");
	// $retstr="";
	// if (mysqli_num_rows($result)>0) {
	// 	while ($row=mysqli_fetch_array($result)) {
	// 		$response[]= $row;
	// 	}
	// 	return json_encode($response);
	// }
	// else{
	// 	return "No data";
	// }

	
}
 ?>