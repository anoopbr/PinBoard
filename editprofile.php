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
</head>
<body>
<?php
session_start();
//echo $_SESSION['userid'];

include("header_user.php");
$current_user=$_SESSION['username'];
$profile_user=$_GET['username'];
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if (isset($_POST['update'])) {
	    $fname = $_POST['fname'];
	    $lname = $_POST['lname'];
	    $email = $_POST['email'];
	    $dob = $_POST['dob'];
	    $gender = $_POST['gender'];
	    $aboutme = $_POST['aboutme'];
	    $phone = $_POST['phone'];
	    $street = $_POST['street'];
	    $city = $_POST['city'];
	    $state = $_POST['state'];
	    $country = $_POST['country'];
	    $zip = $_POST['zip'];
		if(!$con) 
			{
				die("Unable to select database");
			}
		$query_insert="Update profile set fname='$fname', lname='$lname', dob='$dob', gender='$gender', aboutme='$aboutme', phone='$phone', street='$street', city='$city', state='$state', country='$country', zip='$zip' where uname='$current_user'";
		mysqli_query($con,$query_insert) or die('Error: ' . mysqli_error($con));
		include("fetchuserdetails.php");
	}
else if (isset($_POST['formsubmit']))
    {
    $query=$con->stmt_init();
    $query->prepare("SELECT max(picid) FROM picture");
	$query->execute();
	$query->bind_result($picid);
	while($query->fetch()){
		$pid= $picid;
	}
	$pid = $pid + 1;
    $image = $_FILES['image'] ;
    $name = $_FILES['image']['name'] ;
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name'])) ; 
    $query = "INSERT INTO picture (picid,picurl, image) VALUES ('$pid','{$name}', '{$image}')";

    $result = mysqli_query($con, $query)  or die('something wrong' . mysql_error());    
	if(!$con) 
	{
		die("Unable to select database");
	}
	$query_insert="Update profile set picid='$pid' where uname='$current_user'";
	mysqli_query($con,$query_insert) or die('Error: ' . mysqli_error($con));
	include("fetchuserdetails.php");
	}
if(!empty($current_user) && !empty($profile_user)){
//Check if the user is visiting a friends page or his own page. no2
	if ($current_user==$profile_user){
	//no add as friend button <----
	//he can view all pics no privacy issues...and view all his friends(done).
	//Header("Location: fetchfriend.php?username=$current_user");
		$_SESSION['profile_user']=$current_user;
		$user='root';
	    $password='';
	    $database='pinterest';
	    $con=mysqli_connect('localhost',$user,$password,$database);
	    if(!$con) 
	        {
	            die("Unable to select database");
	        }
	    $query=$con->stmt_init();
	    $query->prepare("SELECT fname,lname,email,dob,gender,phone,aboutme,street,city,state,country,zip,picid FROM profile where uname=?") or die (Header ("Location : error.php"));
	    $query->bind_param("s",$current_user);
	    $query->execute();
	    $query->bind_result($fname,$lname,$email,$dob,$gender,$phone,$aboutme,$street,$city,$state,$country,$zip,$picid);
	    $query->fetch();
	?>
	<center>
	<div class="pin-profile-block">
		<h1>Update Profile</h1>
		<form id="registration-form" method="POST" enctype="multipart/form-data">
		<div class="pin-table" id="basic-info">
			<div class="pin-table-head-row">
				<div class="pin-table-cell-blck">
					<?php
					$pic=$_SESSION['image'];
					echo "<img width = 200 class='usr-thmb' src='data:image/jpeg;base64," .base64_encode( $pic ). "' />";
					 ?>
					<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
					<p id="phup">Click browse button to choose photo:<br /><input type="file" name="image" /></p>
					<input type="submit" name="formsubmit" value="upload here" size="35" />
				</div>
				<div class="pin-table-cell-blck">
					<div class="pin-table" id="basic-info">
					<h3>Account Information</h3>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								First Name
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<input name="fname" id="fname" type="text" class="pin-input-box" value="'.$_SESSION['fname'].'">';
								 ?>
								
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Last Name
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<input name="lname" id="lname" type="text" class="pin-input-box" value="'.$_SESSION['lname'].'">';
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Email
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<input name="email" id="email" type="text" class="pin-input-box" value="'.$_SESSION['email'].'">';
								 ?>
								<span id = "email_status"> </span>
							</div>
						</div>
					</div>
					<div class="pin-table" id="personal-info">
					<h3>Personal Information</h3>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								About me
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<textarea name="aboutme" id="aboutme" class="pin-input-area" rows="5">'.$_SESSION['aboutme'].'</textarea>';
								 ?>
							</div>
						</div>
						<div class="pin-table-row">
							<div class="pin-table-cell">
								Date of birth
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<input name="dob" id="dob" type="text" class="pin-input-box" value="'.$_SESSION['dob'].'">';
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Gender
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<input name="gender" id="gender" type="text" class="pin-input-box" value="'.$_SESSION['gender'].'">';
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Phone
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<input name="phone" id="phone" type="text" class="pin-input-box" value="'.$_SESSION['phone'].'">';
								 ?>
							</div>
						</div>
					</div>
					<div class="pin-table" id="address-info">
					<h3>Contact Information</h3>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Street
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<input name="street" id="street" type="text" class="pin-input-box" value="'.$_SESSION['street'].'">';
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								City
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<input name="city" id="city" type="text" class="pin-input-box" value="'.$_SESSION['city'].'">';
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								State
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<input name="state" id="state" type="text" class="pin-input-box" value="'.$_SESSION['state'].'">';
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Country
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<input name="country" id="country" type="text" class="pin-input-box" value="'.$_SESSION['country'].'">';
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Zip
							</div>
							<div class="pin-table-cell">
								<?php 
								echo '<input name="zip" id="zip" type="text" class="pin-input-box" value="'.$_SESSION['zip'].'">';
								 ?>
							</div>
						</div>
					</div>
					<p><input type="submit" id="create-user" value="Update Information" name="update" class="pin-btn-long"></p>
				</div>
			</div>
		</div>
		</form>
	</div>
	</center>
	<div id="error_content_update" style="color:#FF0000;display:none">Please enter some text</div>
	<?php
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
mysqli_close($con);	
?>
</body>
</html>


