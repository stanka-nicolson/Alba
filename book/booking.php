<?php
session_start();
include('../connection.php');
include('../model/function.php');
ini_set('display_errors',1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//debug($_SESSION);
//debug($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset = "utf-8">
<title>Booking</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
<div class = "nav-user">
	

<?php
	if(!isset($_SESSION['email']) || !isset($_SESSION['pass_id']) || !isset($_SESSION['fname']) ||
	!isset($_SESSION['lname']) || !isset($_SESSION['level_id']) || !isset($_SESSION['type']) ){
		echo "<script>alert('Problem')</script>";
		header("location: index.php");
	}
	
	if(isset($_SESSION['email']) || isset($_SESSION['pass_id']) || isset($_SESSION['fname']) ||
	isset($_SESSION['lname']) || isset($_SESSION['level_id']) || isset($_SESSION['type']) ){
	
	$email= $_SESSION['email'];
	$pass_id= $_SESSION['pass_id'];
	$fname= $_SESSION['fname'];
	$lname= $_SESSION['lname'];
	$level_id = $_SESSION['level_id'];
	$type= $_SESSION['type'];
	
	}

	if($type == 'u'){
	
?>

	<a href="/alba/users/userProfile1.php">My Dashboard</a> <a href="/alba/model/userLogout.php">Log out</a> 
	
<?php 

	}else{
	
 ?>
	<a href="/alba/users/userFrequent.php">My Dashboard</a>
	<a href="/alba/model/userLogout.php">Log out</a>
	
	
<?php 

	}

	print'</div>

	<div class="content-user">';
	
$booking=true;

if(isset($_POST['booking'])){//if the form is submited
	
	$ferry_id = $_POST['ferry_id'];
	$trip_id = $_POST['trip_id'];
	$sail_date =mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['sail_date'])));
	$num_adults = $_POST['num_adults'];
	$num_ch1 = $_POST['num_ch1'];
	$num_ch2 = $_POST['num_ch2'];
	$num_inf = $_POST['num_inf'];
	$disabled =$_POST['disabled'];
	
	if(empty($sail_date)){
		$booking=false;
		echo "<script>alert('Please enter sailing date')</script>";
	}
	
	
	if(!calendardate($sail_date)){
		$booking=false;
		echo "<script>alert('Please enter correct sailing date')</script>";
	}
	
//validation bookings

//check is the ferry and trip are match
	$trip="SELECT ferry_id,trip_id FROM ferry WHERE ferry_id= '".$ferry_id."' AND trip_id='".$trip_id."'";

	$r1= mysqli_query($mysqli,$trip);
	
	if(mysqli_affected_rows($mysqli)!=1){
		
	//print"<script>alert('correct sailing routes')</script>";
		$booking=false;
		echo "<script>alert('Please enter correct sailing routes')</script>";
	}//trip query
	

	//check is ferry sail on the sellected date from user
		$dates="SELECT ferry_id,dates,totalSeats FROM ferrysail WHERE ferry_id = '".$ferry_id."' AND dates ='".$sail_date."' ORDER BY dates ASC";
	
		$r2= mysqli_query($mysqli,$dates);
		
		if(mysqli_affected_rows($mysqli)!=1){
	
		$booking=false;
		echo "<script>alert('Please choose another dates as this ferry do not sail on sellected dates')</script>";
		}//dates query
		

		//calculate and reduce total seats of the ferry with numbers of adults, ch1 and ch2 
		$numseats = $num_adults + $num_ch1 + $num_ch2;
		//print "<p>Nummber passengers is:'".$numseats."'</p>";

		$seats ="SELECT ferry_id,dates,totalSeats,remindSeats FROM ferrysail WHERE ferry_id='".$ferry_id."' AND dates='".$sail_date."'";
		$r3= mysqli_query($mysqli,$seats);
		
		if(mysqli_affected_rows($mysqli)==1){
			
			$rows = mysqli_fetch_array($r3);
			
			if($rows['remindSeats']> $numseats){
				
				$booking=false;
				echo "<script>alert('Please choose another dates as this ferry is fully booked')</script>";
			}else{
				
				$updateSeats="UPDATE ferrysail SET remindSeats = remindSeats - '".$numseats."'
					WHERE ferry_id = '".$ferry_id."'
					AND dates='".$sail_date."'LIMIT 1";				
				
				
				$r4= mysqli_query($mysqli,$updateSeats);
	
					if(mysqli_affected_rows($mysqli)!=1){
						
					$booking=false;
					//print"<p>Total seats are updated;</p>";
					print '<p>Error updateSeats query: ' . mysqli_error($mysqli).'</p>';
					}//if rows ==1
			}//totalseats
			
		}else{
			
			//print '<p>Error in seats query. Error: '.mysqli_error($mysqli).'</p>';
		}//query seats rows ==1


	
	if($booking){
	
	$stmt = "INSERT INTO booking (b_id,ferry_id,trip_id,sail_date, num_adults,num_ch1, num_ch2, num_inf,disabled, pass_id,booked)
	VALUES(0,
	'".$ferry_id."',
	'".$trip_id."',
	'".$sail_date."',
	'".$num_adults."',
	'".$num_ch1."',
	'".$num_ch2."',
	'".$num_inf."',
	'".$disabled."',
	'".$pass_id."',
	    NOW()
	)";
	
	$result= mysqli_query($mysqli,$stmt);
	
	if($result){
		
		print"<script type='text/javascript'>alert('Your booking has been submited.Thank you for choosing us for your trip!You will be log out now');</script>";
		print"<script type='text/javascript'>window.location.href='/alba/index.php';</script>";
	}else{
		trigger_error("Query Failed! SQL: $stmt - Error: ".mysqli_error(), E_USER_ERROR);
	}//result
	
	
	}//booking
	mysqli_close($mysqli);

}

?>

<div class="forms-head">
<h2>Your Booking </h2>
<!-- booking form for makeing new booking-->
</div><!--forms-head-->

<div class ="form">
	<form action="<?php $_SERVER['PHP_SELF'];  ?>" method="post">

		<div class="trip-help-block"><p id="message"></p></div>

		<label for="title">Cruise Day Destination:<span class="warning_css">*</span></label>
		<select name = "ferry_id" >
		<option value="1" id="boat1">Morar - Eigg - Mack</option>
		<option value="2" id="boat2">Morar - Eigg - Rum</option>
		<option value="3" id="boat3">Morar - Rum</option>
		</select>

		<label for="title">Route<span class="warning_css">*</span></label>
		<select name = "trip_id" >
		<option value="1">Morar - Eigg - Mack</option>
		<option value="2">Morar - Eigg</option>
		<option value="3">Eigg - Mack</option>
		<option value="4">Morar - Eigg - Rum</option>
		<option value="5">Eigg - Rum</option>
		<option value="6">Morar - Rum</option>
		</select>


		<label for="title">Date<span class="warning_css">*</span></label>
		<input type="text" name="sail_date" id="datepicker">


		<label for="num_adults">Adult(16+ years)<span class="warning_css">*</span></</label>
		<select name = "num_adults">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		</select>

		<label for="num_ch1">Child(11-16 years)</label>
		<select name = "num_ch1">
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
		<select name = "num_inf">
		<option value="0">0</option>
		<option value="1">1</option>
		<option value="2">2</option>
		</select>


		<label for="disabled">Require assisstance</label>
		<select name = "disabled" >
		<option value="0">No</option>
		<option value="1">Yes</option>
		</select>

		<div class="clearfix">
		<div  class="submit" >
		<button type="submit"  name = "booking" value="Book Ticket">Book Ticket</button>
		</div>
		</div><!--clearfix-->

	</form>
</div> <!--form-->  	
</div><!--content-user white-->	
</body>

</html>