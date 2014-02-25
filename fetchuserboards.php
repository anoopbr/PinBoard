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
$query->prepare("SELECT boardid,boardname FROM board WHERE uname=?")
 or die (Header ("Location : error.php"));
$query->bind_param("s",$current_user);
$query->execute();
$query->bind_result($bid,$bname);
$bid_list[]=array();
while($query->fetch()){
	$bid_list[$bid]=$bname;
}
$_SESSION['bid_list']=$bid_list;
?>