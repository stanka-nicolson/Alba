<?php

	function calendardate($d){
	$d1 = explode('-',$d);
	return sizeof($d1)==3 && checkdate($d1[1],$d1[2],$d1[0]);
	}

	/*
	function count_pass($id){
		
	$stmt = "SELECT * FROM booking WHERE pass_id='".$id."'";
			
	$r=mysqli_query($mysqli,$stmt);
	
	return (mysqli_num_rows($r));
	
	}
	*/
		//$count= ;
	//function count_pass($d){
	//	$stmt = "SELECT * FROM booking WHERE pass_id='".$d."'";
	//	$count= mysqli_num_rows($stmt);
	//	return ($count);
	//}
	
?>