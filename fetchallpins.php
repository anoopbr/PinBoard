<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<center><div>
<?php

//session_start();
$fetchfriend_user=$_SESSION['profile_user'];
$like_array=$_SESSION['like_array'];
$repin_array=$_SESSION['repin_array'];
$comment_array=$_SESSION['comment_array'];
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }
$query=$con->stmt_init();

$query->prepare("SELECT pin,opin,pintitle,pinpicid,pinpicurl,pinimage,boardid,boardname,uname,description,
	picid,time,boardimage,fname,lname,userimage FROM fetch_pin_details ORDER BY
	time DESC");
$query->execute();
$query->bind_result($pin,$opin,$pintitle,$pinpicid,$pinpicurl,$pinimage,$bid,$bname,$uname,$description,
	$picid,$createtime,$boardimage,$fname,$lname,$userimage);
while($query->fetch()){
	?>
	<div class="pin-board-thumb-box">
	<?php 
	echo "<a  class='pin-board-hd' href='fetchimage.php?pinid=$pin&boardid=$bid'>"; 
	echo '<img width=200 src="data:image/jpeg;base64,' .base64_encode( $pinimage ). '" /></a>';
	?>
	<p class="pin-title"> <?php echo $pintitle; ?> </p>
	<div class="pin-board-like-bdetails">
	<img src='images/like.png' height="10px" title="like"><span class="like-text"><?php echo $like_array[$opin]; ?></span>
	<img src='images/repin.png' height="10px" title="repin"><span class="like-text"><?php echo $repin_array[$opin]; ?></span>
	<img src='images/comment.png' height="10px" title="comment"><span class="like-text"><?php echo $comment_array[$pin]; ?></span>
	</div>
	<?php
	echo '<div class="pin-board-thumb-bdetails">';
	echo "<a  class='pin-board-txt' href='userprofile.php?username=$uname'>"; 
	echo '<p><img height=30 class="pin-board-thumb-img" src="data:image/jpeg;base64,' .base64_encode( $userimage ). '" /></p>';
	?>
		
	<p class="pin-board-thumb-txt-name"> <?php echo $uname; ?></p>
	<p class="pin-board-thumb-txt"> <?php echo $bname; ?> </p>
	</a>
	</div>
	</div>
	<?php
}
mysqli_close($con);
?>
</div>
</center>