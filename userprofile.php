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

$_SESSION['profile_user']=$profile_user;
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }

if (isset($_POST['addfrnd'])) {
	$afrnd =$_POST['addfrnd'];
	$query_addfrnd="INSERT INTO FriendRelation(uname1,uname2) 
	VALUES('$current_user','$afrnd')";
	mysqli_query($con,$query_addfrnd) or die('Error: ' . mysqli_error($con));
}

if (isset($_POST['confrnd'])) {
	$afrnd =$_POST['confrnd'];
	if(!$con) 
	    {
	        die("Unable to select database");
	    }
	$confrnd=$con->stmt_init();

	$confrnd->prepare("UPDATE friendrelation set status = 'Approved' where uname1 = ? and uname2 = ? ");
	$confrnd->bind_param('ss',$afrnd,$_SESSION['username']);
	$confrnd->execute();

}

if (isset($_POST['delfrnd'])) {
	$dfrnd =$_POST['delfrnd'];
	if(!$con) 
	    {
	        die("Unable to select database");
	    }
	$delfrnd=$con->stmt_init();

	$delfrnd->prepare("DELETE FROM  friendrelation where (uname1 = ? and uname2 = ?) 
		or (uname2 = ? and uname1 = ?)");
	$delfrnd->bind_param('ssss',$_SESSION['username'],$dfrnd,$_SESSION['username'],$dfrnd);
	$delfrnd->execute();

}

include("fetchfriendlists.php");
$frnd_list = $_SESSION['frnd_list'];
$pen_frnd_list = $_SESSION['pen_frnd_list'];
$app_frnd_list = $_SESSION['app_frnd_list'];

$frd_flg="false";
$frd_pen_flg="false";
$frd_app_flg="false";
foreach($frnd_list as $val){
	if($profile_user==$val){
		$frd_flg="true";
	}
}
foreach($pen_frnd_list as $val){
	if($profile_user==$val){
		$frd_pen_flg="true";
	}
}
foreach($app_frnd_list as $val){
	if($profile_user==$val){
		$frd_app_flg="true";
	}
}

mysqli_close($con);	
if(!empty($current_user) && !empty($profile_user)){
//Check if the user is visiting a friends page or his own page. no2

	//no add as friend button <----
	//he can view all pics no privacy issues...and view all his friends(done).
	//Header("Location: fetchfriend.php?username=$current_user");
		$_SESSION['profile_user']=$profile_user;
		$user='root';
	    $password='';
	    $database='pinterest';
	    $con=mysqli_connect('localhost',$user,$password,$database);
	    if(!$con) 
	        {
	            die("Unable to select database");
	        }

	    $queryprofile=$con->stmt_init();
	    $queryprofile->prepare("SELECT image FROM view_profile where uname=?") or die (Header ("Location : error.php"));
	    $queryprofile->bind_param("s",$profile_user);
	    $queryprofile->execute();
	    $queryprofile->bind_result($image);
	    $queryprofile->fetch();

	    $con=mysqli_connect('localhost',$user,$password,$database);
	    if(!$con) 
	        {
	            die("Unable to select database");
	        }

	    $query=$con->stmt_init();
	    $query->prepare("SELECT fname,lname,email,dob,gender,phone,aboutme,street,city,state,country,zip,picid FROM profile where uname=?") or die (Header ("Location : error.php"));
	    $query->bind_param("s",$profile_user);
	    $query->execute();
	    $query->bind_result($fname,$lname,$email,$dob,$gender,$phone,$aboutme,$street,$city,$state,$country,$zip,$picid);
	    $query->fetch();

	    $con=mysqli_connect('localhost',$user,$password,$database);
	    if(!$con) 
	        {
	            die("Unable to select database");
	        }

		$queryboard=$con->stmt_init();
		$queryboard->prepare("SELECT boardid,boardname,uname,description,
			picid,createtime,boardimage,fname,lname,userimage FROM fetch_board_details WHERE uname = ? ORDER BY
			createtime DESC ");
		$queryboard->bind_param('s',$profile_user);
		$queryboard->execute();
		$queryboard->bind_result($bid,$bname,$uname,$description,
			$picid,$createtime,$boardimage,$fname,$lname,$userimage);


	?>
	<center>
	<div class="pin-profile-block">
		<form id="registration-form" method="POST" enctype="multipart/form-data">
		<div class="pin-table" id="basic-info">
			<div class="pin-table-head-row">
				<div class="pin-table-cell-blck" style="border:0px solid #111; text-align:left; display:block; 
							background:#efefef;border-radius:20px;box-shadow:4px 4px 20px #aaa; padding-top:50px;
							margin-left:10px; padding-bottom:50px; float:left; margin-top:0px;">
					<?php
					//$pic=$_SESSION['image'];
					echo "<center><img width = 200 class='usr-thmb' src='data:image/jpeg;base64," .base64_encode( $image ). "' /></center>";
					 ?>
					<div class="pin-table" id="basic-info">
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								First Name
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $fname;
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Last Name
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $lname;
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Email
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $email;
								 ?>
								<span id = "email_status"> </span>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								About me
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $aboutme;
								 ?>
							</div>
						</div>
					</div>
					<?php 
						if($frd_flg=="true"){
					 ?>
					<h3>Personal Information</h3>
					<div class="pin-table" id="personal-info">
						<div class="pin-table-row">
							<div class="pin-table-cell">
								Date of birth
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $dob;
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Gender
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $gender;
								 ?>
							</div>
						</div>
					</div>
					<h3>Contact Information</h3>
					<div class="pin-table" id="address-info">
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Street
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $street;
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								City
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $city;
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								State
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $state;
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Country
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $country;
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Zip
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $zip;
								 ?>
							</div>
						</div>
						<div class="pin-table-head-row">
							<div class="pin-table-cell">
								Phone
							</div>
							<div class="pin-table-cell">
								<?php 
								echo $phone;
								 ?>
							</div>
						</div>
					</div>
					<?php 
					}
					 ?>
					<p>
					<?php 
						if($current_user==$profile_user){
					 ?>
					<input type="submit" id="create-user" value="Update Information" name="update" class="pin-btn-long"></p>
					<?php } ?>
				</div>
				<div class="pin-table-cell-blck">
					<div class="user-header">
					<?php 
					echo '<h1>'.strtoupper($fname).' '.strtoupper($lname).'</h1>';
					if($frd_flg=="true"){
						echo "<span class='frnd-btn-txt'>Friends</span>";
						echo "<span><button type='submit' class='add-frnd-btn' name='delfrnd' value='$profile_user'>Delete</button></span>";
					}else if($frd_pen_flg=="true"){
						echo "<span class='pen-frnd-btn-txt'>Pending</span>";
						echo "<span><button type='submit' class='add-frnd-btn' name='delfrnd' value='$profile_user'>Delete</button></span>";
					}else if($frd_app_flg=="true"){
						echo "<span><button type='submit' class='add-frnd-btn' name='confrnd' value='$profile_user'>Confirm</button></span>";
						echo "<span><button type='submit' class='add-frnd-btn' name='delfrnd' value='$profile_user'>Delete</button></span>";
					}else{
					echo "<p><button type='submit' class='add-frnd-btn' name='addfrnd' value='$profile_user'>Add Friend</button></p>";
					}
					echo "</div>";
					echo "<div id='board-box'>";
					while($queryboard->fetch()){
						?>
						<div class="pin-board-thumb-box">
						<?php echo "<a href='fetchpins.php?type=board&id=$bid'>";
						echo '<img height=100 src="data:image/jpeg;base64,' .base64_encode( $boardimage ). '" />'; ?>
							<p class="pin-board-hd"> <?php echo $bname; ?> </p>
							<p class="pin-board-txt"> <?php echo $description; ?> </p>
							</a>
						</div>
						<?php
					}
					echo "</div>";
					 ?>
				</div>
			</div>
		</div>
		</form>
	</div>
	</center>
	<div id="error_content_update" style="color:#FF0000;display:none">Please enter some text</div>
	<?php

}//end of no1

else{
//redirect the user to the homepage and unset the session varibale as well
}
mysqli_close($con);	
?>
</body>
</html>


