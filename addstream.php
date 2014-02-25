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
if (isset($_POST['addstream'])) {
		$boardname =  $_POST['streamname'];
	    $desc = $_POST['streamdesc'];
		$query=$con->stmt_init();
		$query->prepare("SELECT max(streamid) FROM followstream");
		$query->execute();
		$query->bind_result($bid);
		while($query->fetch()){
			$maxbid= $bid;
		}
		$maxbid = $maxbid + 1;
		$con=mysqli_connect('localhost',$user,$password,$database);
		if(!$con) 
			{
				die("Unable to select database");
			}
		$query_insert="INSERT INTO followstream(streamid,uname,streamname,description,picid) 
		VALUES('$maxbid','$current_user','$boardname','$desc','60')";
		mysqli_query($con,$query_insert) or die('Error: ' . mysqli_error($con));
		mysqli_close($con);	
		Header("Location: userboard.php");
}
?>
