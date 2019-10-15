<?php
session_start();// Initialize the session
include('../connection.php');// Include config file
//debug($_POST);
//debug($_SESSION);

// Define variables and initialize with empty values
$username_err = $password_err ="";

// Processing form data when form is submitted

if(isset($_POST['login'])){
	
	$login=true;
	
	$email = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['email'])));
	$password = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['password'])));

	 // Check if username is empty
	If(empty($email)){
		$login=false;
		$username_err="Please enter your email";
	}
	
	 // Check if password is empty
	If(empty($password)){
		$login=false;
		$password_err="Please enter your password";
	}

	//all fieds are correctly fill
	if($login){
		
	    // Prepare a select statement
		$query = "SELECT pass_id,fname,lname,email,level_id,type FROM passengers WHERE email ='".$email."' AND password = '".$password."' LIMIT 1";
		$result=mysqli_query($mysqli,$query);
		
		 // Check if username exists, if yes then verify password
		if(mysqli_num_rows($result) == 1){
			
			 // Password is correct, so start a new session
			$rows = mysqli_fetch_array($result);

			//check user level or admin
			if($rows['level_id'] == 1){

				//check if this uder have done bookings
				$stmt = "SELECT * FROM booking WHERE pass_id='".$rows['pass_id']."'";
				$r=mysqli_query($mysqli,$stmt);
				
				//count how many bookings user done
				$count=mysqli_num_rows($r);
				
				//if user have 7 or more bookings send it to frequent user page 
				if($count >= 7){
				
				//if user have more than 7 bookings type is changet from 'u' to 'f'
				$updatetype = "UPDATE passengers SET type = 'f' WHERE pass_id ='".$rows['pass_id']."'";
				$r5=mysqli_query($mysqli,$updatetype);
				
				
				
				//start sessions
				$_SESSION['email']=$rows['email'];
				$_SESSION['pass_id']=$rows['pass_id'];
				$_SESSION['fname']=$rows['fname'];
				$_SESSION['lname']=$rows['lname'];
				$_SESSION['level_id']=$rows['level_id'];
				$_SESSION['type']=$rows['type'];
				
				header('Location: ../users/userFrequent.php');
				
				}else{
					
				//if user has les than 6 bookings send normal user page	
				$_SESSION['email']=$rows['email'];
				$_SESSION['pass_id']=$rows['pass_id'];
				$_SESSION['fname']=$rows['fname'];
				$_SESSION['lname']=$rows['lname'];
				$_SESSION['level_id']=$rows['level_id'];
				$_SESSION['type']=$rows['type'];
				
				header('Location: ../users/userProfile1.php');
				}//count pass_id
				
				
			}else{
				
				//user is admin level
				
				$_SESSION['email'] = $rows['email'];
				$_SESSION['pass_id']=$rows['pass_id'];
				$_SESSION['fname']= $rows['fname'];
				$_SESSION['lname']=$rows['lname'];
				$_SESSION['level_id'] = $rows['level_id'];
		
				
			header('Location: ../admin/adminProfile1.php');
				
			}//rows
	
		}//find 1 query
			
				$password_err = "The combination of email address and password you entered does not match.";
		}//result
		
	// Close connection	
	mysqli_close($mysqli);
}//submit

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/alba/css/forms.css" type="text/css">
    <title>Login</title>
</head>
<body>
<div class="forms-head">
	<div class="link"><a href="/alba/index.php">BACK HOME</a></div>
	<h2>Login</h2>
	
	<p>Please fill in your credentials to log.</p>
</div><!--forms-head-->

<div class ="form">
	<form action="login.php" method="POST">
	
		<label for="name" >Email<span class="warning_css">*</span></label>
		<input type="text" id="css" name="email" placeholder="Insert email">
		<div class="help-block"><?php echo $username_err; ?></div>
	
		<label for="name" >Password<span class="warning_css">*</span></label>
		<input type="password" id="css" name="password" placeholder="Insert password">
		<div class="help-block"><?php echo $password_err; ?></div>
	
		<div class="clearfix">
		<div  class="submit" >
		<button type="submit" name ="login" value="Login">Login</button>
		</div>
		</div><!--clearfix-->
	
		<p>Don't have an account? <a href="/alba/forms/register.php">Register here</a>.</p>
	
	</form>
</div> <!--form-->  
     
</body>
</html>