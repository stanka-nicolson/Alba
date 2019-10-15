<?php
session_start();
include('../connection.php');
include('../model/function.php');
ini_set('display_errors',1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
debug($_SESSION);
debug($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset = "utf-8">
<title>Booking</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../js/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
     rel = "stylesheet">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <script>
	  
	var $noDates = new Array("2019-05-25","2019-05-26","2019-09-01","2019-09-07","2019-09-08",
	"2019-09-14","2019-09-15","2019-09-21","2019-09-22","2019-09-28","2019-09-29",
	"2019-10-05","2019-10-06","2019-10-12","2019-10-13","2019-10-19","2019-10-20",);
 
	function noshowDates(date) {
 
	var $return=true;
	var $returnclass ="available";	
 
	var $dateFormat = $.datepicker.formatDate('yy-mm-dd',date);
 
		// We will now check if the date belongs to disableddates array 
		for (var i = 0; i < $noDates.length; i++) {
 
		// Now check if the current date is in disabled dates array. 
			if ($noDates[i] == $dateFormat) {
				$return = false;
        $returnclass= "unavailable";
			}
		}
		return [$return,$returnclass];
	}// noshowDate 
	  
	  
    $(function() {
		$( "#datepicker" ).datepicker({
		dateFormat: 'yy-mm-dd',
		beforeShowDay: noshowDates,
		firstDay: 1,
		minDate: new Date(2019,5-1,20), 
		maxDate: new Date(2019,10-1,21),
		changeMonth:true,
		changeYear:true,
		numberOfMonths:[1,3],
		showAnim: "slideDown",
		show: true
        });
    });
	
	
	
      </script>
 <link rel="stylesheet" href="css/style.css" type="text/css">	
</head>
<body>


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
		echo "<script>alert('Please enter date')</script>";
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
			$occupantSeats = $rows['totalSeats'] - $rows['remindSeats'];
			print'<table><tr>
			<th>ferry id</th>
			<th>ferry name</th>
			<th>date</th>
			<th>Total seats</th>
			<th>Remind seats</th>
			<th>Occupant seats</th>
			</tr>
			<tr>
			<td>'.$rows['ferry_id'].'</td>
			<td>'.$rows['fname'].'</td>
			<td>'.$rows['dates'].'</td>
			<td>'.$rows['totalSeats'].'</td>
			<td>'.$rows['remindSeats'].'</td>
			<td>'.$occupantSeats.'</td>
			</tr>
			</table>';
		
		}
		
	}else{
		print '<p>Error in seats query. Error: '.mysqli_error($mysqli).'</p>';
	}
	
	mysqli_close($mysqli);

}

?>

<h2>Report </h2>
<!-- booking form for makeing new booking-->
<form action="<?php $_SERVER['PHP_SELF'];  ?>" method="post">

<legend> Booking</legend>
</br>

<p id="message"></p></br></br>

<label class="css" for="title">Cruise Day Ferry:<span class="warning_css">*</span></label>
<select name = "ferry_id" id="css">
<option value="1" id="boat1">Morar - Eigg - Mack</option>
<option value="2" id="boat2">Morar - Eigg - Rum</option>
<option value="3" id="boat3">Morar - Rum</option>
</select>

<label class="css" for="title">Date<span class="warning_css">*</span></label>
<input type="text" name="sail_date" id="datepicker"></br>
</br>

<div class="submit_for_css">
	<input type="submit" name = "submit" value="Submit">
	</div>

</form>
</body>
</html>