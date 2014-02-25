<?php 
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }
$query_cnts=$con->stmt_init();

$query_cnts->prepare("SELECT uname2,text FROM notifications where uname1='$current_user' and seen!='Y' order by createtime");
	$query_cnts->execute();
	$query_cnts->bind_result($uname,$text);
	$notifications_array= array();
	while($query_cnts->fetch()){
		$notifications_array[]= $uname." ".$text;
	}
	$_SESSION['notifications_array']=$notifications_array;
 ?>