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
		$( "#stream-box" ).slideUp();
		$( "#see-board" ).click(function() {
		  $( "#stream-box" ).slideUp( "fast", function() {
		    // Animation complete.
		  });
		  $( "#board-box" ).slideDown( "fast", function() {
		    // Animation complete.
		  });
		});
		$( "#see-stream" ).click(function() {
		  $( "#board-box" ).slideUp( "fast", function() {
		    // Animation complete.
		  });
		  $( "#stream-box" ).slideDown( "fast", function() {
		    // Animation complete.
		  });
		});
	});
	</script>
</head>
<body>
<?php
session_start();
include("header_user.php");
include("addboard.php");
?>
<center><div class="pin-profile-block">
<div class="pin-tab">
	<span class="pin-tab-btn" id="see-board">Boards</span>
	<span class="pin-tab-btn" id="see-stream">Follow Streams</span>
</div>
<?php
$current_user=$_SESSION['username'];
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }
$query=$con->stmt_init();

$query->prepare("SELECT boardid,boardname,uname,description,
	picid,createtime,boardimage,fname,lname,userimage FROM fetch_board_details WHERE uname = ? ORDER BY
	createtime DESC ");
$query->bind_param('s',$_SESSION['username']);
$query->execute();
$query->bind_result($bid,$bname,$uname,$description,
	$picid,$createtime,$boardimage,$fname,$lname,$userimage);
echo "<div id='board-box'>";
while($query->fetch()){
	?>
	<div class="pin-board-thumb-box">
	<?php echo "<a href='fetchpins.php?type=board&id=$bid'>";
	echo '<img height=200 src="data:image/jpeg;base64,' .base64_encode( $boardimage ). '" />'; ?>
		<p class="pin-board-hd"> <?php echo $bname; ?> </p>
		<p class="pin-board-txt"> <?php echo $description; ?> </p>
		</a>
	</div>
	<?php
}
echo "</div>";

$querystream=$con->stmt_init();

$querystream->prepare("SELECT streamid,streamname,uname,description,
	picid,createtime,streamimage FROM fetch_stream_details WHERE uname = ? ORDER BY
	createtime DESC ");
$querystream->bind_param('s',$current_user);
$querystream->execute();
$querystream->bind_result($streamid,$streamnane,$uname,$description,
	$picid,$createtime,$streamimage);
echo "<div id='stream-box'>";
while($querystream->fetch()){
	?>
	<div class="pin-board-thumb-box">
	<?php echo "<a href='fetchpins.php?type=stream&id=$streamid'>";
	echo '<img height=200 src="data:image/jpeg;base64,' .base64_encode( $streamimage ). '" />'; ?>
		<p class="pin-board-hd"> <?php echo $streamnane; ?> </p>
		<p class="pin-board-txt"> <?php echo $description; ?> </p>
		</a>
	</div>
	<?php
}
echo "</div>";
mysqli_close($con);
?>
</div>
<?php 
include("footer.php");
 ?>
</center>
</body>