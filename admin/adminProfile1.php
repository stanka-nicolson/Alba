<?php
session_start();
include('../connection.php');
include('../model/function.php');
//ini_set('display_errors',1);
//error_reporting(E_ALL);
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//debug($_SESSION);
//debug($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset = "utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../js/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
     rel = "stylesheet">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/alba/js/tabs.js"></script>

<link rel="stylesheet" href="/alba/css/forms.css" type="text/css">
<link rel="stylesheet" href="/alba/css/style.css" type="text/css">	
<title>Admin Report</title>
</head>
<body>

<div class="nav-user" id ="navUser">
		<a href = "/alba/reports/report2.php">Report 2 </a>
		<a href = "/alba/model/userLogout.php">Log Out</a>
		<a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div><!--nav-user-->

<div class="content-user"><!--white-->
<!--Report: View customers details per sailing-->



<?php

//not successfull session
if(!isset($_SESSION['email']) || !isset($_SESSION['pass_id']) || !isset($_SESSION['fname']) ||
!isset($_SESSION['lname']) || !isset($_SESSION['level_id']) ){
	
      header("location: ../index.php");
}

//session
if(isset($_SESSION['email']) || isset($_SESSION['pass_id']) || isset($_SESSION['fname']) ||
isset($_SESSION['lname']) || isset($_SESSION['level_id']) ){
	
$email=$_SESSION['email'];
$pass_id= $_SESSION['pass_id'];
$fname= $_SESSION['fname'];
$lname= $_SESSION['lname'];
$level_id = $_SESSION['level_id'];


}//end session

print '<div class="admin-header">
<h2> Hello '.$fname .' '.$lname .'</h2>
<h1>Admin dashboard</h1>';
?>

<h3>Report 1</h3>
<h4>View occupancy per sailing </h4>
<!-- booking form for makeing new booking-->

<div class ="form">
	<form action="<?php $_SERVER['PHP_SELF'];  ?>" method="post">

		<label for="title">Cruise Day Ferry:<span class="warning_css">*</span></label>
		<select name = "ferry_id">
		<option value="1" id="boat1">Morar - Eigg - Mack</option>
		<option value="2" id="boat2">Morar - Eigg - Rum</option>
		<option value="3" id="boat3">Morar - Rum</option>
		</select>

		<label for="title">Date<span class="warning_css">*</span></label>
		<input type="text" name="sail_date" id="datepicker">

		<div class="clearfix">
		<div  class="submit" >
		<button type="submit" name = "submit" value="Submit">Submit</button>
		</div>
		</div><!--clearfix-->
	</form>
</div><!--form--> 

<?php


if(isset($_POST['submit'])){//if the form is submited
	
	$submit=true;
	
	$ferry_id = $_POST['ferry_id'];
	$sail_date =mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['sail_date'])));
	
	if(empty($sail_date)){
		$submit=false;
		echo "<script>alert('Please enter  date')</script>";
	}
	
	
	if(!calendardate($sail_date)){
		$submit=false;
		echo "<script>alert('Please enter correct date')</script>";
	}
	
//check is ferry sail on the sellected date from user
		$dates="SELECT ferry_id,dates,totalSeats,remindSeats FROM ferrysail WHERE ferry_id = '".$ferry_id."' AND dates ='".$sail_date."' ORDER BY dates ASC";
	
		$r2= mysqli_query($mysqli,$dates);
		
		if(mysqli_affected_rows($mysqli)!=1){
	
		$submit=false;
		echo "<script>alert('Cruise Day ferry do not sail on sellected dates')</script>";
		}//dates query

//check is the ferry and trip are match
	$stmt="SELECT fs.ferry_id,fs.dates, fs.totalSeats,fs.remindSeats,f.fname FROM ferry f, ferrysail fs 
	WHERE fs.ferry_id = f.ferry_id
	AND fs.ferry_id= '".$ferry_id."' AND fs.dates ='".$sail_date."'LIMIT 1";

	$r1= mysqli_query($mysqli,$stmt);
	
	if($r1){
		while($rows = mysqli_fetch_assoc($r1)){
			
			$occupiedSeats = $rows['totalSeats'] - $rows['remindSeats'];
			
			print'<table><tr>
			<th>Ferry id</th>
			<th>Ferry name</th>
			<th>Date sail</th>
			<th>Total seats</th>
			<th>Remaining seats</th>
			<th>Occupied seats</th>
			</tr>
			<tr>
			<td>'.$rows['ferry_id'].'</td>
			<td>'.$rows['fname'].'</td>
			<td>'.$rows['dates'].'</td>
			<td>'.$rows['totalSeats'].'</td>
			<td>'.$rows['remindSeats'].'</td>
			<td>'.$occupiedSeats.'</td>
			</tr>
			</table></div>';//end admin-header
		
		}
		
	}else{
		print '<p>Error in seats query. Error: '.mysqli_error($mysqli).'</p>';
	}
	
	mysqli_close($mysqli);

}

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
</div><!-- content-user white-->
</body>

</html>