<?php
error_reporting(E_ALL);
function debug($thingy){
		echo "<pre>";print_r($thingy);echo "</pre>";
	}
	$host = "";
	$mysql_user = "";
	$mysql_password = "";
	$mysql_database = "";
	
	// this is the connection object
	$mysqli = new mysqli($host, $mysql_user, $mysql_password, $mysql_database);
	
	/* check connection */
	if($mysqli -> connect_error){
		print("Connect failed: ".$mysqli->connect_error);
		exit();
	}else{
		//print'<p>Success</p>';
	}
?>
