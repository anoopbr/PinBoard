<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>myJourney</title>
<link href="login.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {font-size: 14px}
.style3 {font-size: 12px}
-->
</style>
</head>
<?php
include("head2.php");
session_start();
$username="";
include('dbpreparedconn.php');
$error = false;
$dberror = false;
  // run this only, once the user has hit the "Go" button
  if (isset($_POST['go'])) {
    // assign form inputs
    $username = $_POST['username'];
    $password = $_POST['password'];
	// validate inputs

    if ( !empty($username) && !empty($password) ) {    

      // validate the user from database
		if($query->prepare("SELECT password FROM user where uname=?")){
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


<script src="jquery-1.7.2.js"></script>
<!--<script>
$("#head2 ul").hide();
$("#menu .settings").hide();
$("#menu .signout").hide();
$("#Layer1").hide();
</script>

-->

<body>

<form method="post" style="width:300px;height:300px;" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <table width="314" height="250" border="0" cellpadding="5" cellspacing="5" style="margin-top:0px; margin-left:10 px;">
    <tr> <td height="32"><div align="left"><span style="color:#06BACE; font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 18px;">Login to myJourney</span></div></td>
    </tr>
	<tr>
      <td width="308" height="78" style="padding-left::15px;"> <span class="style2" style="padding:5px;color:#06BACE;font-family: Geneva, Arial, Helvetica, sans-serif;">User name:</span><span class="style2"><br />
        <input name="username" type="text" value="<?php echo $username; ?>" style="margin-left:5px; height: 30px; width: 200px;"/>
        <?php
	  if ( $error && empty($username) ) {
	    echo '<br/><span style="color:red">Error! Please enter a user name.</span><br>',"\n";
	  }?>
      </span></td>
    </tr>
    <tr>
      <td height="96" style="padding-left::5px;"><span style="padding:5px;color:#06BACE;font-family: Geneva, Arial, Helvetica, sans-serif;"><span class="style2">Password</span>:</span><br />
	  <input name="password" type="password"  style="margin-left:5px; height: 30px; width: 200px;"/>
	  <?php
	  if ( $error && empty($password) ) {
	    echo '<br/><span style="color:red">Error! Please enter a password.</span><br>',"\n";
	  }?>
	  
	  <br /><br />
	  <input name="go" class="signin" type="submit" value="Sign In" style="padding-left:5px; margin-left:5px; color:#FFFBF0; background-color:#464646;border-style:none; border:thin;"/>
	  
	  	<br />
	   <?php
	  if ($dberror) {
	    echo '<span style="color:red">Invalid username or password.</span><br>',"\n";
	  }?>
	   <br />
	  <a href="signup.php" class="style3" style="color:#06BACE;font-family: Geneva, Arial, Helvetica, sans-serif; "> Create an account </a>	   </td>
    </tr>
  </table>
</form>
<div id="loginpic"><img src="images/a.jpeg"  width=" 800" height="500"/></div>
</body>
</html>
