<?php
session_start();

include('../connection.php');
include('../header.html');

//debug($_POST);
?>

<div class = "index-content"><!--blue-->	
<div class="content"><!--white-->
<div class ="contact-content">
<h1>Contact us</h1>
<h2>Alba Wildlife Cruises</h2>
<p>Morar </p>
<p> Mallaig </p> 
<p>PH40 4PA</p> 
<p>Scotland </p>
<p>United Kingdom</p>
<p>Telephone: 01687456789</p>
<p>Email: alba@gmail.com</p>
<h2>Send us a message</h2>
</div><!--contact-content-->
<?php

if(isset($_POST['send'])){//if the form is submited

	$contact = true;

	$name = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['name'])));
	$email = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['email'])));
	$subject =  mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['subject'])));
	$message = mysqli_real_escape_string($mysqli,trim(strip_tags($_POST['message'])));
	
	
	
	
	//check if @ sign exists in email
	if(substr_count($email,'@') !=1){
		$contact=false;
		echo "<script >alert('Please enter valid email.')</script>";
	}
	
	if($contact){
		
	print'<h3 class="form-confirm-message">Thank you, '.$name.' for your enquiry.</br>
	We received your message!</h3>';
	
	
	$to = '13006443@uhi.ac.uk';
	$headers='From:'.$email. "\r\n";
	$headers .='Reply-To:'.$email. "\r\n";
	$headers .= 'X-Mailer: PHP/'.phpversion();

	mail($to, $subject, $message,$headers);
	
	$_POST=[];
	
	}
	//else{
		//print"<p>Please try again!</p>";
	//}
}//end submitt form
?>
<div class = "form">
	<form action="contact.php" method="POST">
	
	<label  for="name" >Name<span class="warning_css">*</span></label>
	<input type="text" name="name" id="css" placeholder="Your name.." value=" <?php if(isset($_POST['name'])){print htmlspecialchars($_POST['name']); } ?> " size ="15"></br>
	
	<label for="name" >Email<span class="warning_css">*</span></label>
	<input type="text" id="css" name="email" placeholder="Your email.." value=" <?php if(isset($_POST['email'])){print htmlspecialchars($_POST['email']); } ?> "></br>
	
	<label for="name" >Subject<span class="warning_css">*</span></label>
	<input type="text" id="css" name="subject" value=" <?php if(isset($_POST['subject'])){print htmlspecialchars($_POST['subject']); } ?> "></br>
	
	<label for="name" >Message<span class="warning_css">*</span></label>
	<textarea id="css" placeholder="Write something.." name="message" style="height:200px" ></textarea></br>
	
	<div class="clearfix">
	<div  class="submit1" >
	<button type="submit" name ="send" value="Send">Send</button>
	</div>
	</div><!--clearfix-->
	</form>
	
</div><!--form-->
</div>
</div>	
<?php
 $path = $_SERVER['DOCUMENT_ROOT'];
 $path .= "/alba/view/footer.html";
include_once($path);
?>

