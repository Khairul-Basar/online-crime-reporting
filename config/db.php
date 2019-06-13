<?php 
	$server = "127.0.0.1";
	$user = "root";
	$password = "";
	$dbname = "crime_reporting";

	$conn = mysqli_connect($server,$user,$password,$dbname);
	if (!$conn) {
		die("connection failed".mysqli_connect_error());
	}
 ?>