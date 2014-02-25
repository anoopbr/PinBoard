<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
	$( "#create-board-form" ).toggle();
	$( "#createboard" ).click(function() {
	  $( "#create-board-form" ).toggle("slow");
	});
});
</script>
</head>
<body>
<?php
session_start();
//echo $_SESSION['userid'];
include("header_user.php");
include("fetchuserdetails.php");
include("getcount.php");
$profile_user=$_GET['username'];
echo "<input type='hidden' value='$profile_user' name='username'>";
if(!is_dir("./userdir/$current_user")){
	if(!mkdir("./userdir/$current_user")){
		echo "dir not made";
	}
}
//echo "<h2>Hello $current_user</h2>";
//echo "<h2>Hello $profile_user</h2>";
//echo $current_user."-->redirected user:".$profile_user;
//check if the session variable has been created and the user entered this page from somewhere. no1
if(!empty($current_user) && !empty($profile_user)){
//Check if the user is visiting a friends page or his own page. no2
	if ($current_user==$profile_user){
	//no add as friend button <----
	//he can view all pics no privacy issues...and view all his friends(done).
	//Header("Location: fetchfriend.php?username=$current_user");
		$_SESSION['profile_user']=$current_user;
		echo '<div class="pin-profile-block">';
		include("fetchallpins.php");
		echo "</div>";
	}// end of no2
	//user visiting friends profile that he has allowed.
	//implement photos that can be viewed and then text. Pics(done)
	else{
	//echo "<br/>".$profile_user;
		$_SESSION['profile_user']=$profile_user;
		echo "<h2>Hello $profile_user</h2><br/>";
		include("fetchfriend.php");
		echo "my friend";
		include("fetchphotos.php");
		echo"<br/>fetchinfo enter";
		include("fetchinfo.php");
		echo"<br/>Fetching your friends Texts:";
		include("fetchtext.php");
	}
}//end of no1

else{
//redirect the user to the homepage and unset the session varibale as well
}
include("footer.php");
?>
</body>
</html>


