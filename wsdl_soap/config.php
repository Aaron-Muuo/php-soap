<?php
$serverName = "localhost\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "your_database_name",
    "Uid" => "your_username",
    "PWD" => "your_password"
);

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Perform SQL queries or operations here

// Close the connection
sqlsrv_close($conn);
?>