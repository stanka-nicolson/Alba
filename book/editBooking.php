<?php
session_start();
include('../connection.php');
include('../model/function.php');
//error_reporting(E_ALL);
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//debug($_POST);
//debug($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset = "utf-8">
<title>Edit Booking</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../js/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
     rel = "stylesheet">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/alba/js/tabs.js"></script>
<link rel="stylesheet" href="/alba/css/style.css" type="text/css">	
<link rel="stylesheet" href="/alba/css/forms.css" type="text/css">	
</head>
<body>
<div class="nav-user">

<?php

if(!isset($_SESSION['email']) || !isset($_SESSION['pass_id']) || !isset($_SESSION['fname']) ||
!isset($_SESSION['lname']) || !isset($_SESSION['level_id']) || !isset($_SESSION['type']) ){
	echo "<script>alert('Problem')</script>";
      header("location:../index.php");
}

if(isset($_SESSION['email']) || isset($_SESSION['pass_id']) || isset($_SESSION['fname']) ||
isset($_SESSION['lname']) || isset($_SESSION['level_id']) || isset($_SESSION['type']) ){
	
	//print '<p>My email in session email is: '.$_SESSION['email'].'</p>';
	
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
//get ti id for the booking need to edit if not number redirect index page
if(isset($_GET['id']) && !is_numeric($_GET['id'])){
	header('Location: ../index.php');
	exit;
}
//if exist, numerik and not null get id
if(isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id']>0)){	
	
	$b_id=$_GET['id'];
	
	//select the edit data from booking and trip table
	$stmt ="SELECT b.b_id,b.ferry_id,b.trip_id,b.sail_date,b.num_adults, b.num_ch1, b.num_ch2, b.num_inf,b.disabled,t.trip_name
			FROM booking b, trip t 
			WHERE b.trip_id=t.trip_id
			AND b.b_id = '".$b_id."'
			group by b.b_id";
			
	//run quiery		
	$r1= mysqli_query($mysqli,$stmt);
	
	//if there is data come from the query
	if($r1){
		//take the data as array
		$row= mysqli_fetch_array($r1);
		
		//print data out as form
	print'<div class="forms-head"><h2>Update your booking</h2></div>
	<div class="form">
		<form action="editBooking.php" method="post">
			
			<h3>'.$row['trip_name'].'</h3>
			<label> Your booking number is:'.$row['b_id'].'</label>
			
			<div class="trip-help-block"><p id="message"></p></div>
			<label for="title">Cruise Day Destination:<span class="warning_css">*</span></label>
			<select name = "ferry_id">
			<option value="1" id="boat1">Morar - Eigg - Mack</option>
			<option value="2" id="boat2">Morar - Eigg - Rum</option>
			<option value="3" id="boat3">Morar - Rum</option>
			</select>
				
			<labelfor="title">Route<span class="warning_css">*</span></label>
			<select name = "trip_id">
			<option value="1">Morar - Eigg - Mack</option>
			<option value="2">Morar - Eigg</option>
			<option value="3">Eigg - Mack</option>
			<option value="4">Morar - Eigg - Rum</option>
			<option value="5">Eigg - Rum</option>
			<option value="6">Morar - Rum</option>
			</select>
				
			<label for="title">Date<span class="warning_css">*</span></label>
			<input type="text" name="sail_date" id="datepicker" value="'.$row['sail_date'].'">
				
			<label for="num_adults">Adult(16+ years)<span class="warning_css">*</span></</label>
			<select name ="num_adults">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			</select>

			<label for="num_ch1">Child(11-16 years)</label>
			<select name = "num_ch1" >
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			</select>

			<label for="num_ch2">Child(3-10 years)</label>
			<select name = "num_ch2">
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			</select>

			<label for="num_inf">Infant(Under 3 years free)</label>
			<select name = "num_inf" >
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			</select>
			
			<label for="disabled">Does passenger require assisstance</label>
			<select name = "disabled">
			<option value="0">No</option>
			<option value="1">Yes</option>
			</select>
	
			<input type="hidden" name="b_id" value="'.$b_id.'">
			
			<div class="clearfix">
			<button type="submit"  value="Edit booking">Edit Booking</button>
			</div>
			</div>
			
		</form>
	</div>';
			
		}else{
			
		print '<p>no result found for retrive edit quiery'. mysqli_error($mysqli).'</p>';
			}//if $r1
	
	//form has been submited
}else if(isset($_POST['b_id']) && is_numeric($_POST['b_id']) && ($_POST['b_id']>0)){	
	
	//store the post book id in variable
	$b_id=$_POST['b_id'];
	
	$update=true;
	
	//store the post variables
	$ferry_id=$_POST['ferry_id'];
	$trip_id = $_POST['trip_id'];
	$sail_date =mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['sail_date'])));
	$num_adults = $_POST['num_adults'];
	$num_ch1 = $_POST['num_ch1'];
	$num_ch2 = $_POST['num_ch2'];
	$num_inf = $_POST['num_inf'];
	$disabled =$_POST['disabled'];
	
	//field sail date is empty
	if(empty($sail_date)){
		$update=false;
		echo "<script>alert('Please enter sailing date')</script>";
	}
	
	//not correct format date
	if(!calendardate($sail_date)){
		$update=false;
		echo "<script>alert('Please enter correct sailing date')</script>";
	}
	//evrything is correct update query
	if($update){
		
		$stmt= "UPDATE booking 
		SET ferry_id = '".$ferry_id."',
			trip_id = '".$trip_id."',
			sail_date = '".$sail_date."',
			num_adults = '".$num_adults."',
			num_ch1 = '".$num_ch1."',
			num_ch2  = '".$num_ch2."',
			num_inf = '".$num_inf."',
			disabled ='".$disabled."'
		WHERE b_id='".$b_id."' LIMIT 1";
		
		$r1= mysqli_query($mysqli,$stmt);
	
		if(mysqli_affected_rows($mysqli)==1){
			
		print"<script type='text/javascript'>alert('Your booking has been updated.Thank you!You will be log out now');</script>";
		print"<script type='text/javascript'>window.location.href='/alba/index.php';</script>";
		
		}else{
			
		print '<p>Error update query: ' . mysqli_error($mysqli).'</p>';
		}//result
	
		
	}//booking
	
}

mysqli_close($mysqli);

?>
</body>
</html>