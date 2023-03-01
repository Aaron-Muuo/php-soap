<?php

require 'vendor\econea\nusoap\src\nusoap.php';

$client = new nusoap_client("http://localhost/API_DEMO/services.php?wsdl")
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title></title>
 </head>
 <body>
 	<form action="" method="POST">
 		<label>Name</label>
 		<input type="text" name="name" placeholder="Enter your name">
 		<input type="text" name="email" placeholder="Enter your email">
 		<input type="text" name="phone" placeholder="Enter your phone">
 		<input type="submit" name="save" value="save">
 	</form>

 	<hr>
 	<form action="" method="POST">
 		<label>Name</label>
 		<input type="text" name="name" placeholder="Enter your name">
 		<input type="submit" name="submit" value="send">
 		<input type="submit" name="viewall" value="view my name">
 	</form>
 	
 	
 	<?php 
 	if (isset($_POST['viewall'])) {

 		$response = $client->call('view_users', array());
 		$result = json_decode($response, true);
 		echo $result;
 		// if ($result!=null) {
 		// 	echo "<table>";
 		// 	echo "<tr>";
 		// 	echo "<th>ID</th>";
 		// 	echo "<th>NAME</th>";
 		// 	echo "<th>EMAIL</th>";
 		// 	echo "<th>PHONE</th>";
 		// 	echo "</tr>";

 		// 	foreach ($result as $key) {
 		// 		echo "<tr>";
 		// 		echo "<td>$key[0]</td>";
 		// 		echo "<td>$key[1]</td>";
 		// 		echo "<td>$key[2]</td>";
 		// 		echo "<td>$key[3]</td>";
 		// 		echo "</tr>";
 		// 	}
 		// 	echo "</table>";
 		// }
 		// else{
 		// 	echo "<p>No data</p>";
 		// }
 		

 	}
 	if (isset($_POST['save'])) {
 		$name= $_POST['name'];
 		$email= $_POST['email'];
 		$phone= $_POST['phone'];
 		// $data[] = ("$name", "$email", "$phone");
 		// $data[] = {$name,$email,$phone}

 		$response = $client->call('adduser',array('name'=>$name,'email'=>$email,'phone'=>$phone

 		));
 		$result = json_decode($response, true);
 		echo $result;

 	}
 	if (isset($_POST['submit'])) {
 		$name= $_POST['name'];

 		$response = $client->call('getName',array("name"=>$name));

 		$result = json_decode($response, true);

 		if ($result!=null) {
 			echo "<table>";
 			echo "<tr>";
 			echo "<th>ID</th>";
 			echo "<th>NAME</th>";
 			echo "<th>EMAIL</th>";
 			echo "<th>PHONE</th>";
 			echo "</tr>";

 			foreach ($result as $key) {
 				echo "<tr>";
 				echo "<td>$key[0]</td>";
 				echo "<td>$key[1]</td>";
 				echo "<td>$key[2]</td>";
 				echo "<td>$key[3]</td>";
 				echo "</tr>";
 			}
 			echo "</table>";
 		}
 		else{
 			echo "<p>No data</p>";
 		}
 	}
 	?>
 
 </body>
 </html>