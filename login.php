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
		$('#login-form').validate({ 
			rules: {
				uname: {
					required: true
				},
				pwd: {
					required: true
				}
			},
			messages: {
				uname: {
					required: "<error>User name is required</error>"
				},
				pwd: {
					required: "<error>Password name is required</error>"
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
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }
$query=$con->stmt_init();
$username="";
$error = false;
$dberror = false;
  // run this only, once the user has hit the "Go" button
  if (isset($_POST['login'])) {
    // assign form inputs
    $username = $_POST['uname'];
    $password = $_POST['pwd'];
	// validate inputs

    if ( !empty($username) && !empty($password) ) {    

      // validate the user from database
		if($query->prepare("SELECT pwd FROM profile where uname=?")){
			$query->bind_param("s",$username);
			$query->execute() or die('i am dead');
			$query->bind_result($pass);
			$query->fetch();
			$query->close();		
			if($pass!=$password || empty($pass)){
				//echo "pass not true";
				$dberror=true;
				//exit;
				}
			else{
			//echo "everythings fine";
				mysqli_query($con,"UPDATE profile SET lastlogin=now() where uname = '$username'");
				$_SESSION['username']=$username;
				Header("Location: profile.php?username=$username");
				exit;
				}
			
			//echo "disconnected";
			
		}//end if query->prepare
	else {
			$dberror=true;
		}//end of query->prepare else, if the query fails
        
     }//end of !$username and !$password

    else {
	//echo "input failed";
      $error = true; // input validation failed
    }
	
	}//end of if $GO
?>

<div class="pin-login-block">
	<div><center><h1>Login to your account</h1></center></div>
	<form id="login-form" method="POST">
	<?php
	if ($dberror) {
	echo '<center><error>Invalid username or password</error></center>',"\n";
	}?>
	<div class="pin-table">
		<div class="pin-table-head-row">
			<div class="pin-table-cell">
				User Name
			</div>
			<div class="pin-table-cell">
				<input name="uname" id="uname type="text" class="pin-input-box">
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
	</div>
	<div><center>
	<p><input type="submit" value="Sign in" class="pin-btn" name="login"></p>
	<p><a href="Register.php" class="pin-link">Forgot User Name?</a>
	 | <a href="Register.php" class="pin-link">Forgot Password?</a></p>
	</form>
	<hr>
	<h1>New to Pinboard?</h1>
	<p><a href="Register.php" class="pin-link-reg">Sign up</a></p>
	</center></div>
</div>
<?php
include("footer.php");
?>
</center>
</body>