<?php
session_start();
include("../connection.php");// Include config file
include('../model/function.php');
//debug($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
     rel = "stylesheet">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
  
  $( function() {
    $( "#datepicker" ).datepicker({
		dateFormat: 'yy-mm-dd',
		showAnim: "slideDown"
	});
  });
  </script>
	<link rel="stylesheet" href="/alba/css/forms.css" type="text/css">
<title>Register</title>
   
</head>
<body>
<?php

// Define variables and initialize with empty values
$fname_err = $lname_err = $dob_err = $address_err = $town_err = $postcode_err = "";
$country_err = $telephone_err = $email_err = $password_err = $confirm_password_err = "";

$register = true;
// Processing form data when form is submitted
if(isset($_POST['register'])){//if the form is submited
	
	$title = $_POST['title'];
	
	$fname = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['fname'])));
	
	$lname = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['lname'])));
	$gender = $_POST['gender'];
	$dob =  mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['dob'])));
	$address1 = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['address1'])));
	$address2 = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['address2'])));
	$town = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['town'])));
	$postcode = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['postcode'])));
	$country =  mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['country'])));
	$telephone = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['telephone'])));
	$email = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['email'])));
	$password = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['password'])));
	$conf_password = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['conf_password'])));
	
	//check if input fields are empty
	//if(empty($fname) || empty($lname) || empty($dob) || empty($address1) || empty($town) || empty($postcode) || empty($telephone) || empty($country)  
	//	|| empty($email) || empty($password) || empty($conf_password) ){
	//	$register=false;
	//	echo "<script>alert('Please enter your details')</script>";
	//}
	
	//valiadtion if input fields are empty
	if(empty($fname)){
		$register=false;
		$fname_err ="Please enter your First Name";
	
	}
	
	if(empty($lname)){
		$register=false;
		$lname_err ="Please enter your Surname";
	}
	
	if(empty($dob)){
		$register=false;
		$dob_err ="Please enter your Date of birth";
	}
	
	if(empty($address1)){
		$register=false;
		 $address_err ="Please enter your address";
	}
	
	if(empty($town)){
		$register=false;
		$town_err ="Please enter your town";
	}
	
	if(empty($postcode)){
		$register=false;
		$postcode_err ="Please enter your post code";
	}
	if(empty($country)){
		$register=false;
		$country_err ="Please enter your country";
	}
	if(empty($telephone)){
		$register=false;
		$telephone_err ="Please enter your telephone number";
	}
	
	if(empty($email)){
		$register=false;
		$email_err ="Please enter your email";
	}
	if(empty($password)){
		$register=false;
		$password_err ="Please enter your password";
	}
	if(empty($conf_password)){
		$register=false;
		$confirm_password_err = "Please enter your confirm password";
	}
	
	
	//check is telephone is numbers only
	if( !(is_numeric($telephone))){
		$register=false;
		$telephone_err ="Please enter valid telephone";
	}
	
	if(strlen($password)< 6){
		$register=false;
		$password_err ="Password must have at least 6 characters";
	}
	
	//vaidate data only as year-month-day and checkdate function passed parametres are(mm-dd-yyyy)
	if(!calendardate($dob)){
		$register=false;
		$dob_err ="Please enter correct date of birth";
	}
	
	//is passwords match
	if($password != $conf_password){
		$register = false;
		$confirm_password_err ="Please make sure your passwords match";
	}
	
	//Regex check on email
	if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email)){ 
		$register=false;
		$email_err ="Please enter valid email";
	
	}
	
	//check if @ sign exists in email
	if(substr_count($email,'@') !=1){
		$register=false;
		$email_err ="Please enter valid email";
	}
	
	//check if inputed email already exists
	$query1 = "SELECT email FROM passengers WHERE email= '".$email."' LIMIT 1";
	$result1 = mysqli_query($mysqli, $query1);
	
	if(mysqli_num_rows($result1)==1){
		$register = false;
		$email_err ="Please choose another email. This email already exists";
	}
	
	//no problem with input data filds
	if($register){

	//insert in db new user query 
	$query= "INSERT INTO passengers (pass_id,title,fname,lname,gender,dob,address1,address2,town,postcode,country,telephone,email,password,level_id,type)
	VALUES(	0,
			'".$title."',
			'".$fname."',
			'".$lname."',
			'".$gender."',
			'".$dob."',
			'".$address1."',
			'".$address2."',
			'".$town."',
			'".$postcode."',
			'".$country."',
			'".$telephone."',
			'".$email."',
			'".$password."',
			1,
			'u'
			)";
	//run query	
	$result = mysqli_query($mysqli,$query);	

	//data has been insert in table
		if($result){
	
		//find newly register users id and open session with it
		$inst = "SELECT pass_id,level_id,type FROM passengers WHERE email ='".$email."' LIMIT 1";
		$instresult=mysqli_query($mysqli,$inst);
		//$rows=mysqli_fetch_assoc($instresult);
	
			while($rows=mysqli_fetch_assoc($instresult)){
		
		//open new session
				$_SESSION['email'] = $email;
				$_SESSION['pass_id']=$rows['pass_id'];
				$_SESSION['fname']= $fname;
				$_SESSION['lname']=$lname;
				$_SESSION['level_id'] = $rows['level_id'];
				$_SESSION['type']=$rows['type'];
		
		//send user to profile page
				header('Location: ../users/userProfile1.php');
				exit();
			}//while
			
		}else{
			print'<p>No Registration:'. mysqli_error($mysqli).'</p>';
		
		}//end success insert data in table
		
	}//end success register
	// Close statement
	mysqli_close($mysqli);
}//end submitt form
?>
 <div class="forms-head">
	<div class="link"><a href="/alba/index.php">BACK HOME</a></div>
 	<h2>Register</h2>
	<p>Please fill this form to create an account.</p>
</div><!--forms-head-->	
	
<div class ="form">	
	<form action="register.php" method="POST">

		<label for="title">Title<span class="warning_css">*</span></label>
		<select name="title" id="css">
		<option value="Mr">Mr</option>
		<option value="Mrs">Mrs</option>
		<option value="Miss">Miss</option>
		</select>
	
		<label for="fname" >First Name<span class="warning_css">*</span></label>
		<input type="text" name="fname" id="css" placeholder="First Name" value=" <?php if(isset($_POST['fname'])){print htmlspecialchars($_POST['fname']); } ?> " size ="15">
		<div class="help-block"><?php echo $fname_err; ?></div>
		
		<label for="lname" >Surname<span class="warning_css">*</span></label>
		<input type="text"  name="lname" id="css" value=" <?php if(isset($_POST['lname'])){print htmlspecialchars($_POST['lname']); } ?> ">
		<div class="help-block"><?php echo $lname_err; ?></div>
		
			
		<label >Gender<span class="warning_css">*</span></label>
		<label class="male">Male
		<input type="radio"  name="gender" id ="css" value="male" checked/></label>
		
		<label class="male">Female
		<input type="radio"  name="gender" id="css" value="female"></label>
		
		
		<label >Date of birth<span class="warning_css">*</span></label>
		<input type="text" name="dob" id="datepicker">
		<div class="help-block"><?php echo $dob_err; ?></div>

		<label>Address<span class="warning_css">*</span></label>
		<input type="text"  name="address1" id="css" value=" <?php if(isset($_POST['address1'])){print htmlspecialchars($_POST['address1']); } ?> ">
		<div class="help-block"><?php echo $address_err; ?></div>

		<label>Address</label>
		<input type="text"  name="address2" id="css" value=" <?php if(isset($_POST['address2'])){print htmlspecialchars($_POST['address2']); } ?> ">

		<label >Town / City<span class="warning_css">*</span></label>
		<input type="text" name="town"  id="css" value=" <?php if(isset($_POST['town'])){print htmlspecialchars($_POST['town']); } ?> ">
		<div class="help-block"><?php echo $town_err; ?></div>

		<label >Post code<span class="warning_css">*</span></label>
		<input type="text" id="css" name="postcode" value=" <?php if(isset($_POST['postcode'])){print htmlspecialchars($_POST['postcode']); } ?> ">
		<div class="help-block"><?php echo $postcode_err; ?></div>

		<label>Country<span class="warning_css">*</span></label>
		<input type="text" id="css" name="country" value=" <?php if(isset($_POST['country'])){print htmlspecialchars($_POST['country']); } ?> ">
		<div class="help-block"><?php echo $country_err; ?></div>
	
		<label>Telephone<span class="warning_css">*</span></label>
		<input type="text" id="css" name="telephone" value=" <?php if(isset($_POST['telephone'])){print htmlspecialchars($_POST['telephone']); } ?> ">
		<div class="help-block"><?php echo $telephone_err; ?></div>

		<label>Email<span class="warning_css">*</span></label>
		<input type="text" id="css" name="email" value=" <?php if(isset($_POST['email'])){print htmlspecialchars($_POST['email']); } ?> ">
		<div class="help-block"><?php echo $email_err; ?></div>
	
		<label>Password<span class="warning_css">*</span></label>
		<input type="password" id="css" name="password">
		<div class="help-block"><?php echo $password_err; ?></div>
	
		<label >Confirm password<span class="warning_css">*</span></label>
		<input type="password" id="css" name="conf_password">
		<div class="help-block"><?php echo $confirm_password_err; ?></div>
			

		<div class="clearfix">
		<div  class="submit" >
		<button type="submit" name ="register" value="Register">Register</button>
		</div>
		</div><!--clearfix-->
	
		<p>You are already a member of our web site? <a href="login.php">Login here</a>.</p>
	</form>
</div> <!--form-->  	
	
</body>
</html>

