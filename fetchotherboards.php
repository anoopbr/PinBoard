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
	picid,createtime,boardimage,fname,lname,userimage FROM fetch_board_details WHERE uname<>?")
 or die (Header ("Location : error.php"));
$query->bind_param("s",$current_user);
$query->execute();
$query->bind_result($bid,$bname,$uname,$description,
	$picid,$createtime,$boardimage,$fname,$lname,$userimag);
$o_bid_list[]=array();
while($query->fetch()){
	$bid_details[]=array();
	$bid_details['bname']=$bname;
	$bid_details['description']=$description;
	$bid_details['boardimage']=$boardimage;
	$o_bid_list[$bid]=$bid_details;
}
$_SESSION['o_bid_list']=$o_bid_list;
?>