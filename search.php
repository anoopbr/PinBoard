<html>
<head>	
	<link rel="icon" type="image/png" href="images/icon.png"/>
	<title>Pinboard</title>
	<link rel="stylesheet" type="text/css" href="css/Style.css">
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
	<style type="text/css">
	.searchblock{
		height: 29px;
	}
	</style>
</head>
<body>
<?php 
session_start();
include("header_user.php");;
$username=$_SESSION['username'];
$_SESSION['keyword'] = $_GET['keyword'];
$keyword="%{$_GET['keyword']}%";
$act=$_GET['keyword'];
?>
<center>
<div class="pin-profile-block">
<?php 
$str = $_GET['keyword'];
$pinlist=array();
$str=str_replace(" ","",$str);
$str=str_replace("%","",$str);
$str=str_replace("_","",$str);
if($str!=null||$str!=""){
$arr = str_split($str);
$j=count($arr);
$j=$j-2;
$keylist=array();
for($i=0;$i<$j;$i++){
	$keylist[]=$arr[$i].$arr[$i+1].$arr[$i+2];
}

$user='root';
$password='';
$database='pinterest';
$fullkeylist=array();
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }

$querytag=$con->stmt_init();

$querytag->prepare("SELECT pin,opin,pintitle,pinpicid,pinpicurl,pinimage,boardid,boardname,uname,description,
	picid,createtime,boardimage,fname,lname,userimage FROM tag_pin where tag like ? ORDER BY createtime DESC");
$querytag->bind_param('s',$keyword);
$querytag->execute();
$querytag->bind_result($pin,$opin,$pintitle,$pinpicid,$pinpicurl,$pinimage,$bid,$bname,$uname,$description,
	$picid,$createtime,$boardimage,$fname,$lname,$userimage);
$querytag->store_result();
echo '<div class="add-forms" id="search-res-tag">';
if($querytag->num_rows>0){
	echo '<p class="pin-board-hd">There are <b>'.$querytag->num_rows.'</b> pins matching tag <b>"'.$_GET['keyword'].'"</b> </p>';
	mysqli_query($con,"INSERT into Activity(uname,keyword) values('$username','$act')");
while($querytag->fetch()){
	?>
	<div class="pin-board-thumb-box">
	<?php 
	$fullkeylist[]=$opin;
	echo "<a  class='pin-board-hd' href='fetchimage.php?pinid=$pin&boardid=$bid'>"; 
	echo '<img width=200 src="data:image/jpeg;base64,' .base64_encode( $pinimage ). '" /></a>';
	?>
	<p> <?php echo $pintitle; ?> </p>
	<?php
	echo '<div class="pin-board-thumb-bdetails">';
	echo "<a  class='pin-board-txt' href='fetchpins.php?boardid=$bid'>"; 
	echo '<p><img height=30 class="pin-board-thumb-img" src="data:image/jpeg;base64,' .base64_encode( $boardimage ). '" /></p>';
	?>
	<p class="pin-board-thumb-txt"> <?php echo $bname; ?> </p></a></div>
	<?php
	echo '<div class="pin-board-thumb-bdetails">';
	echo "<a  class='pin-board-txt' href='profile.php?username=$uname'>"; 
	echo '<p><img height=30 class="pin-board-thumb-img" src="data:image/jpeg;base64,' .base64_encode( $userimage ). '" /></p>';
	?>
		
		<p class="pin-board-thumb-txt"> <?php echo $uname; ?> </p>
		</a></div>
	</div>
	<?php
}
}else{
	echo '<p class="pin-board-hd">Sorry, No results matching tag "'.$_GET['keyword'].'" !</p>';
}
echo '</div>';


$queryaname=$con->stmt_init();

$queryaname->prepare("SELECT pin,opin,pintitle,pinpicid,pinpicurl,pinimage,boardid,boardname,uname,description,
	picid,time,boardimage,fname,lname,userimage FROM fetch_pin_details where pintitle like ? ORDER BY createtime DESC");
$queryaname->bind_param('s',$keyword);
$queryaname->execute();
$queryaname->bind_result($pin,$opin,$pintitle,$pinpicid,$pinpicurl,$pinimage,$bid,$bname,$uname,$description,
	$picid,$createtime,$boardimage,$fname,$lname,$userimage);
$queryaname->store_result();
echo '<div class="add-forms" id="search-res-tag">';
if($queryaname->num_rows>0){
	echo '<p class="pin-board-hd">There are <b>'.$querytag->num_rows.'</b> pins with matching name <b>"'.$_GET['keyword'].'"</b> </p>';
	mysqli_query($con,"INSERT into Activity(uname,keyword) values('$username','$act')");
while($queryaname->fetch()){
	?>
	<div class="pin-board-thumb-box">
	<?php 
	$fullkeylist[]=$opin;
	echo "<a  class='pin-board-hd' href='fetchimage.php?pinid=$pin&boardid=$bid'>"; 
	echo '<img width=200 src="data:image/jpeg;base64,' .base64_encode( $pinimage ). '" /></a>';
	?>
	<p> <?php echo $pintitle; ?> </p>
	<?php
	echo '<div class="pin-board-thumb-bdetails">';
	echo "<a  class='pin-board-txt' href='fetchpins.php?boardid=$bid'>"; 
	echo '<p><img height=30 class="pin-board-thumb-img" src="data:image/jpeg;base64,' .base64_encode( $boardimage ). '" /></p>';
	?>
	<p class="pin-board-thumb-txt"> <?php echo $bname; ?> </p></a></div>
	<?php
	echo '<div class="pin-board-thumb-bdetails">';
	echo "<a  class='pin-board-txt' href='profile.php?username=$uname'>"; 
	echo '<p><img height=30 class="pin-board-thumb-img" src="data:image/jpeg;base64,' .base64_encode( $userimage ). '" /></p>';
	?>
		
		<p class="pin-board-thumb-txt"> <?php echo $uname; ?> </p>
		</a></div>
	</div>
	<?php
}
}else{
	echo '<p class="pin-board-hd">Sorry, No pin name matching "'.$_GET['keyword'].'" !</p>';
}
echo '</div>';


$queryaboard=$con->stmt_init();

$queryaboard->prepare("SELECT boardid,boardname,uname,description,
	picid,createtime,boardimage,fname,lname,userimage FROM fetch_board_details where boardname like ? ORDER BY createtime DESC");
$queryaboard->bind_param('s',$keyword);
$queryaboard->execute();
$queryaboard->bind_result($bid,$bname,$uname,$description,
	$picid,$createtime,$boardimage,$fname,$lname,$userimage);
$queryaboard->store_result();
echo '<div class="add-forms" id="search-res-tag">';
if($queryaboard->num_rows>0){
	echo '<p class="pin-board-hd">There are <b>'.$querytag->num_rows.'</b> boards with matching name <b>"'.$_GET['keyword'].'"</b> </p>';
while($queryaboard->fetch()){
	?>
	<div class="pin-board-thumb-box">
	<?php 
	echo "<a href='fetchpins.php?type=board&id=$bid'>"; 
	echo '<img height=200 src="data:image/jpeg;base64,' .base64_encode( $boardimage ). '" />';
	echo '<p><img height=30 src="data:image/jpeg;base64,' .base64_encode( $userimage ). '" /></p>';
	?>
		<p class="pin-board-txt"> <?php echo $uname; ?> </p>
		<p class="pin-board-hd"> <?php echo $bname; ?> </p>
		<p class="pin-board-txt"> <?php echo $description; ?> </p>
		</a>
	</div>
	<?php
}
}else{
	echo '<p class="pin-board-hd">Sorry, No boards matching name "'.$_GET['keyword'].'" !</p>';
}
echo '</div>';


$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }

$query=$con->stmt_init();

$query->prepare("SELECT pinid FROM tag where tag like ? ORDER BY createtime DESC");
foreach ($keylist as $key) {
	$key = '%'.$key.'%';
	$query->bind_param('s',$key);
	$query->execute();
	$query->bind_result($pin);
	while($query->fetch()){
		$pinlist[$pin]=$pin;
	}

}

$querypin=$con->stmt_init();

$querypin->prepare("SELECT pin,opin,pintitle,pinpicid,pinpicurl,pinimage,boardid,boardname,uname,description,
	picid,time,boardimage,fname,lname,userimage FROM fetch_pin_details where pin = ? ORDER BY createtime DESC");

if($pinlist!=""||$pinlist!=null){
	echo '<p class="pin-board-hd">You may also like to look into</p>';
	$result = array_unique($pinlist);
	foreach ($result as $keyword) {
		$querypin->bind_param('s',$keyword);
		$querypin->execute();
		$querypin->bind_result($pin,$opin,$pintitle,$pinpicid,$pinpicurl,$pinimage,$bid,$bname,$uname,$description,
			$picid,$createtime,$boardimage,$fname,$lname,$userimage);
		while($querypin->fetch()){
			$duplicate="false";
			foreach ($fullkeylist as $orglist) {
				if($orglist==$pin){
					$duplicate="true";
				}
			}
			if($duplicate=="false"){
				?>
				<div class="pin-board-thumb-box">
				<?php 
				echo "<a  class='pin-board-hd' href='fetchimage.php?pinid=$pin&boardid=$bid'>"; 
				echo '<img width=200 src="data:image/jpeg;base64,' .base64_encode( $pinimage ). '" /></a>';
				?>
				<p> <?php echo $pintitle; ?> </p>
				<?php
				echo '<div class="pin-board-thumb-bdetails">';
				echo "<a  class='pin-board-txt' href='fetchpins.php?boardid=$bid'>"; 
				echo '<p><img height=30 class="pin-board-thumb-img" src="data:image/jpeg;base64,' .base64_encode( $boardimage ). '" /></p>';
				?>
				<p class="pin-board-thumb-txt"> <?php echo $bname; ?> </p></a></div>
				<?php
				echo '<div class="pin-board-thumb-bdetails">';
				echo "<a  class='pin-board-txt' href='profile.php?username=$uname'>"; 
				echo '<p><img height=30 class="pin-board-thumb-img" src="data:image/jpeg;base64,' .base64_encode( $userimage ). '" /></p>';
				?>
					
					<p class="pin-board-thumb-txt"> <?php echo $uname; ?> </p>
					</a></div>
				</div>
				<?php
			}
		}
	}
}
else{

}

mysqli_close($con);
}else{
	echo '<p class="pin-board-hd">Sorry, please enter some meaniningful keyword to search !</p>';
}
?>
</div>
 <?php 
include("footer.php");
 ?>
</center>
 </body>