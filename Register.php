<html>
<head>	
	<link rel="icon" type="image/png" href="images/icon.png"/>
	<title>Pinboard</title>
	<link rel="stylesheet" type="text/css" href="css/Style.css">
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
 	<script>
 	$().ready(function() {
 		$(document).ready(function () {
		   $("#conpwd").keyup(function(){
		   	var pwd =$("#pwd").val();
		   	var conpwd = $(this).val();
		   	$("#divCheckPasswordMatch").html(pwd == conpwd
            ? "<noerror><img src='images/check.png' class='check_img'>Passwords match.</noerror>"
            : "<error>Passwords do not match!</error>"
        	);
		   });
		   $("#uname").keyup(function(){
		   	var uname =$(this).val();
		   	$('#uname_status').html('<error>Checking...</error>');
		   	if(uname != ''){
		        $.post('checkuname.php',{ uname: uname }, function(data) {
		            $('#uname_status').html(data);
		        });
		    } else {
		        $('#uname_status').html('');
		    }
		   });
		   $("#email").keyup(function(){
		   	var email =$(this).val();
		   	$('#email_status').html('<error>Checking...</error>');
		   	if(uname != ''){
		        $.post('checkemail.php',{ email: email }, function(data) {
		            $('#email_status').html(data);
		        });
		    } else {
		        $('#email_status').html('');
		    }
		   });
		});

	    $('#registration-form').validate({ // initialize the plugin
	        rules: {
	            email: {
	                required: true,
	                email: true
	            },
	            uname: {
	                required: true,
	                minlength: 4
	            },
	            fname: {
	            	required: true,
	            	minlength:2
	            },
	            lname: {
	            	required: true,
	            	minlength:2
	            },
	            pwd: {
	            	required: true,
	            	minlength: 6
	            }
	        },
	        messages: {
	        	uname:{
	        		required: "<error>User name is required</error>",
	        		minlength: jQuery.format("<error>At least 4 characters required!</error>")
	        	},
	        	fname:{
	        		required: "<error>First name is required</error>",
	        		minlength: jQuery.format("<error>At least 2 characters required!</error>")
	        	},
	        	lname:{
	        		required: "<error>Last name is required</error>",
	        		minlength: jQuery.format("<error>At least 2 characters required!</error>")
	        	},
	        	email:{
	        		required: "<error>Email is required</error>",
	        		 email: "<error>Your email address must be in the format of name@domain.com</error>"
	        	},
	        	pwd:{
	        		required: "<error>Password name is required</error>",
	        		minlength: jQuery.format("<error>At least 6 characters required!</error>")
	        	}
	        }

	    });

	});
	</script>
</head>
<body>
<center>
<?php
include("header.php");
session_start();
unset($_SESSION['username']);
$error=false;
$username_taken=false;
if (isset($_POST['register'])) {
		$uname =  $_POST['uname'];
	    $fname = $_POST['fname'];
	    $lname = $_POST['lname'];
	    $email = $_POST['email'];
	    $pwd = $_POST['pwd'];

		$user='root';
		$password='';
		$database='pinterest';
		$con=mysqli_connect('localhost',$user,$password,$database);
		if(!$con) 
			{
				die("Unable to select database");
			}
		$query_insert="INSERT INTO profile(uname,fname,lname,pwd,email,picid) VALUES('$uname','$fname','$lname','$pwd','$email','10')";
		mysqli_query($con,$query_insert) or die('Error: ' . mysqli_error($con));
		mysqli_close($con);	

		$_SESSION['username']=$uname;
		if(!is_dir("./userdir/$uname")){
			if(!mkdir("./userdir/$uname")){
				echo "dir not made";
			}
		}
		Header("Location: profile.php?username=$uname");
	
}
?>
<div class="pin-login-block">
	<h1>Register</h1>
	<form id="registration-form" method="POST">
	<div class="pin-table">
		<div class="pin-table-head-row">
			<div class="pin-table-cell">
				User Name
			</div>
			<div class="pin-table-cell">
				<input name="uname" id="uname" type="text" class="pin-input-box">
				<span id = "uname_status"> </span>
			</div>
		</div>
		<div class="pin-table-head-row">
			<div class="pin-table-cell">
				First Name
			</div>
			<div class="pin-table-cell">
				<input name="fname" id="fname" type="text" class="pin-input-box">
			</div>
		</div>
		<div class="pin-table-head-row">
			<div class="pin-table-cell">
				Last Name
			</div>
			<div class="pin-table-cell">
				<input name="lname" id="lname" type="text" class="pin-input-box">
			</div>
		</div>
		<div class="pin-table-head-row">
			<div class="pin-table-cell">
				Email
			</div>
			<div class="pin-table-cell">
				<input name="email" id="email" type="text" class="pin-input-box">
				<span id = "email_status"> </span>
			</div>
		</div>
		<div class="pin-table-row">
			<div class="pin-table-cell">
				Password
			</div>
			<div class="pin-table-cell">
				<input name="pwd" id="pwd" type="password" class="pin-input-box">
			</div>
		</div>
		<div class="pin-table-row">
			<div class="pin-table-cell">
				Confirm Password
			</div>
			<div class="pin-table-cell">
				<input name="conpwd" id="conpwd" type="password" class="pin-input-box">
				<div id="divCheckPasswordMatch"></div>
			</div>
		</div>
	</div>
	<p><input type="submit" id="create-user" value="Submit" name="register" class="pin-btn"></p>
	<p><a href="/Project" class="pin-link-reg">Sign in</a></p>
	</form>
</div>
</center>
<?php
include("footer.php");
?>
</body>