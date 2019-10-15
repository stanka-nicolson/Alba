<?php session_start();
include('connection.php');
error_reporting(E_ALL);

if(isset($_SESSION['email'])){
	$email=$_SESSION['email'];
	
$query = "SELECT pass_id,fname,lname,level_id FROM passengers WHERE email = '" .$email."'"; //make quiery from two tables
$result = mysqli_query($mysqli,$query);
	$rows = mysqli_fetch_assoc($result);
		$pass_id= $rows['pass_id'];
		$fname= $rows['fname'];
		$lname= $rows['lname'];
		$level_id = $rows['level_id'];
		
		
$_SESSION['pass_id']=$pass_id;
$_SESSION['fname']=$fname;
$_SESSION['lname']=$lname;
$_SESSION['level_id']=$level_id;
$_SESSION['email']=$email;
//print '<p>Again pass_id is: '.$pass_id.'</p>
//<p>My name is: '. $fname.' '.$lname.'</p>
//<p>I am level: '.$level_id.'</p>
//';
//print'<p>My email is: '.$email.'</p>';


mysqli_close($mysqli);

}else{
	print'<p>No session problem</p>';
}

if(!isset($_SESSION['pass_id']) || !isset($_SESSION['email'])){
      header("location:index.php");
   }
//else{
	//print"<script>alert('Problem')</script>";
	//header('Location: index.php');
//}
?>