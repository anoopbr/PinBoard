<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<center><div class="pin-profile-block">
<?php

//session_start();
$fetchfriend_user=$_SESSION['profile_user'];
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
	picid,createtime,boardimage,fname,lname,userimage FROM fetch_board_details ORDER BY
	createtime DESC");
$query->execute();
$query->bind_result($bid,$bname,$uname,$description,
	$picid,$createtime,$boardimage,$fname,$lname,$userimage);
while($query->fetch()){
	?>
	<div class="pin-board-thumb-box">
	<?php 
	echo "<a href='fetchpins.php?boardid=$bid'>"; 
	echo '<img height=200 src="data:image/jpeg;base64,' .base64_encode( $boardimage ). '" />';
	echo '<p><img height=30 src="data:image/jpeg;base64,' .base64_encode( $userimage ). '" /></p>';
	?>
		<p class="pin-board-hd"> <?php echo $bname; ?> </p>
		<p class="pin-board-txt"> <?php echo $description; ?> </p>
		</a>
	</div>
	<?php
}
?>
<div id="wrapper">
	<div id="columns">
		while($query->fetch()){
			?>
			<div class="pin">
			<?php 
			echo "<a href='fetchpins.php?boardid=$bid'>"; 
			echo '<img height=200 src="data:image/jpeg;base64,' .base64_encode( $boardimage ). '" />';
			echo '<p><img height=30 src="data:image/jpeg;base64,' .base64_encode( $userimage ). '" /></p>';
			?>
				<p class="pin-board-hd"> <?php echo $bname; ?> </p>
				<p class="pin-board-txt"> <?php echo $description; ?> </p>
				</a>
			</div>
			<?php
		}
		?>
	</div>
</div>
<?php
mysqli_close($con);
?>
</div>
</center>