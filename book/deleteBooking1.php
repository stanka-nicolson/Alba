<?php
session_start();
include('../connection.php');
//debug($_POST);
//debug($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/alba/css/style.css" type="text/css">	
<link rel="stylesheet" href="/alba/css/forms.css" type="text/css">	
<title>Delete Booking</title>
<!-- logo/user_profile.php left side,right side name of logged user; nav menu under blue banner/My bookings - list all bookings with buttons delete and edit;
Profile settings;log out will take home page web site index.php/ -->
</head>
<body>

<div class="nav-user">

<?php

if(!isset($_SESSION['email']) || !isset($_SESSION['pass_id']) || !isset($_SESSION['fname']) ||
!isset($_SESSION['lname']) || !isset($_SESSION['level_id']) || !isset($_SESSION['type']) ){
	echo "<script>alert('Problem')</script>";
      header("location:index.php");
}

if(isset($_SESSION['email']) || isset($_SESSION['pass_id']) || isset($_SESSION['fname']) ||
isset($_SESSION['lname']) || isset($_SESSION['level_id']) || isset($_SESSION['type']) ){
		
$email= $_SESSION['email'];
$pass_id= $_SESSION['pass_id'];
$fname= $_SESSION['fname'];
$lname= $_SESSION['lname'];
$level_id = $_SESSION['level_id'];
$type= $_SESSION['type'];

}//session

	if($type == 'u'){
	
	?>

<a href="/alba/users/userProfile1.php">My Dashboard</a>
<a href="/alba/model/userLogout.php">Log out</a> 

<?php 

	}else{
	
 ?>
 
<a href="/alba/users/userFrequent.php">My Dashboard</a>
<a href="/alba/model/userLogout.php">Log out</a>


<?php 

	}
	
	print'</div>

	<div class="content-user">';

if(isset($_GET['id']) && !is_numeric($_GET['id'])){
	header('Location: ../index.php');
	exit;
}

if(isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id']>0)){	
	
	$b_id=$_GET['id'];
	
	 //"SELECT * FROM bookings WHERE b_id ={$GET['b_id']}";
	$stmt ="SELECT b.b_id,b.sail_date,b.num_adults, b.num_ch1, b.num_ch2, b.num_inf,b.disabled, b.booked,t.trip_name
			FROM booking b, trip t 
			WHERE b.trip_id=t.trip_id
			AND b.b_id = '".$b_id."'
			group by b.b_id";
			
			
	$r1= mysqli_query($mysqli,$stmt);
	
	
		if($r1){
			$row= mysqli_fetch_array($r1);
			
			print'<form action='.$_SERVER['PHP_SELF'].' method="post">
			<div class="user-header"><h2>Are you sure you want to delete the booking</h2>
			
			<h3>'.$row['trip_name'].'</h3>
				<p>	Booking number: '.$row['b_id'].'</p>
				<table>
				<tr><th>Sale date</th>
					<td>'.$row['sail_date'].' </td>
				</tr>
				<tr><th>Number adults</th> 
					<td>'.$row['num_adults'].'</td>
				</tr>
				<tr><th>Number children1</th> 
				<td>'.$row['num_ch1'].'</td>
				</tr>
				<tr><th>Number children1</th>
				<td>'.$row['num_ch2'].'</td>
				</tr>
				<tr><th>Number infants</th> 
				<td>'.$row['num_inf'].'</td>
				</tr>
				<tr><th>Disabled</th>
				<td>'.$row['disabled'].'</td>
				</tr>
				<tr><th>Booking date</th> 
				<td>'.$row['booked'].'</td>
				</tr>
				</table></div>
				<input type="hidden" name="b_id" value="'.$b_id.'">
				
				<div class ="form">
				<div class="clearfix">
				<button type="submit" value="Delete booking">Delete Booking</button>
				</div><!--clearfix-->
			</form></div>';
			
		}else{
			
		print '<p>no result found for retrive booking quiery'. mysqli_error($mysqli).'</p>';
			}//if $r1
	
}else if(isset($_POST['b_id']) && is_numeric($_POST['b_id']) && ($_POST['b_id']>0)){	
	
	$b_id=$_POST['b_id'];
	
	$stmt="DELETE FROM booking WHERE b_id='".$b_id."' LIMIT 1";
	
	$r1= mysqli_query($mysqli,$stmt);
	
	if(mysqli_affected_rows($mysqli)==1){
		
		print"<script type='text/javascript'>alert('Booking has been canceled.Thank you!You will be log out now');</script>";
		print"<script type='text/javascript'>window.location.href='/alba/index.php';</script>";
		
	}else{
		
		print '<p>Error delete query: ' . mysqli_error($mysqli).'</p>';
	}//if rows ==1
	
}

mysqli_close($mysqli);
	
?>

</div><!-- content-user white-->
</body>
</html>