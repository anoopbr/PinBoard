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
$query->prepare("SELECT catid, catname FROM category ORDER BY catname");
$query->execute();
$query->bind_result($catid,$catname);
$catList  = array();
while ($query->fetch()) {
	$catList[$catid] = $catname;
}
if (isset($_POST['addboard'])) {
		$boardname =  $_POST['boardname'];
	    $category = $_POST['category'];
	    $desc = $_POST['desc'];
	    $secret = $_POST['secret-radio'];
	    $comment = $_POST['comment-radio'];

		$query=$con->stmt_init();

		$query->prepare("SELECT max(boardid) FROM board");
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
		$query_insert="INSERT INTO board(boardid,uname,boardname,description,catid,public,privileged,picid) 
		VALUES('$maxbid','$current_user','$boardname','$desc','$category','$secret','$comment','60')";
		mysqli_query($con,$query_insert) or die('Error: ' . mysqli_error($con));
		mysqli_close($con);	
		
}
?>
