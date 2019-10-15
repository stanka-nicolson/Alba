<?php
session_start();
include('../connection.php');
//debug($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><!--responsive icon-->
<link rel="stylesheet" href="/alba/css/forms.css" type="text/css">
<link rel="stylesheet" href="/alba/css/style.css" type="text/css">
<title>Frequent User Profile</title>

</head>
<body>

<div class="nav-user" id ="navUser">
		<a href = "/alba/book/booking.php" >New Booking</a>
		<a href = "/alba/model/userLogout.php">Log Out</a>
		<a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div><!--nav-user-->

<div class="content-user"><!--white-->
<?php

if(!isset($_SESSION['email']) || !isset($_SESSION['pass_id']) || !isset($_SESSION['fname']) ||
!isset($_SESSION['lname']) || !isset($_SESSION['level_id']) || !isset($_SESSION['type']) ){
	echo "<script>alert('Problem')</script>";
      header("location: ../index.php");
}

if(isset($_SESSION['email']) || isset($_SESSION['pass_id']) || isset($_SESSION['fname']) ||
isset($_SESSION['lname']) || isset($_SESSION['level_id']) || isset($_SESSION['type']) ){
	
$email= $_SESSION['email'];
$pass_id= $_SESSION['pass_id'];
$fname= $_SESSION['fname'];
$lname= $_SESSION['lname'];
$level_id = $_SESSION['level_id'];
$type = $_SESSION['type'];

}//end session
//if($type == 'u'){
//	print '<p>type user</p>';
//}else{
//	print '<p>type frequent</p>';
//}
print '<div class="user-header">
<h2> Hello '.$fname .' '.$lname .'</h2>
<h4>Frequent user</h4>
<p class="invite">All our frequent customers are invited to a private ceilidh on Isle of Eigg on 27th October 2019. We would love for you to attend!!!</p>
<h1>My dashboard</h1>';

	$stmt = "SELECT b.b_id,b.sail_date,b.num_adults, b.num_ch1, b.num_ch2, b.num_inf,b.disabled, b.booked,t.trip_name
			FROM booking b, trip t 
			WHERE b.trip_id=t.trip_id
			AND pass_id = '".$pass_id."'
			group by b.b_id;";
//$stmt="SELECT t.trip_name,b.b_id,b.sail_date,b.num_adults, b.num_ch1, b.num_ch2, b.num_inf, b.booked
//FROM booking b
//LEFT JOIN trip t 
//ON b.trip_id = t.trip_id
//WHERE pass_id= '".$pass_id."'";
	
$r= mysqli_query($mysqli,$stmt);

if($r){

	if(mysqli_num_rows($r)>=1){
		while($row=mysqli_fetch_array($r)){
			print"
		
			<h3>{$row['trip_name']}</h3>
				<p class=\"red\"> Booking number: {$row['b_id']}</p>
				<table>
				<tr><th>Sail date:</th>
					<td>{$row['sail_date']} </td>
				</tr>
				<tr><th>Number adults:</th> 
					<td>{$row['num_adults']}</td>
				</tr>
				<tr><th>Number children(age 11-16 years old):</th> 
				<td>{$row['num_ch1']}</td>
				</tr>
				<tr><th>Number children(age 3-10 years old):</th>
				<td>{$row['num_ch2']}</td>
				</tr>
				<tr><th>Number infants:</th> 
				<td>{$row['num_inf']}</td>
				</tr>
				<tr><th>Disabled:</th>
				<td>{$row['disabled']}</td>
				</tr>
				<tr><th>Date of booking:</th> 
				<td>{$row['booked']}</td>
				</tr>
				</table>
				<p class=\"red\"><a href=\"/alba/book/editBooking.php?id={$row['b_id']}\">Edit Booking</a> /
				<a href=\"/alba/book/deleteBooking1.php?id={$row['b_id']}\">Delete Booking</a></p></br>
				
				<hr>\n";
		
		}//end while
	
	}else{

	print '<h2>No Booking has been made by you</h2></div>';//end user-header
	
	}//num rows	
}else{

print '<p>Error in select query. Error: '.mysqli_error($mysqli).'</p>';

}//end if	

mysqli_close($mysqli);

?>

<script>
function myFunction() {
    var x = document.getElementById("navUser");
    if (x.className === "nav-user") {
        x.className += " responsive";
    } else {
        x.className = "nav-user";
    }
}
</script>

</body>
</div>
</html>