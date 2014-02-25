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

$query_cnts->prepare("SELECT pinid,likes,repin,cmt FROM pin_cnt order by pinid");
	$query_cnts->execute();
	$query_cnts->bind_result($pinid,$likes,$repin,$cmt);
	$like_array = array();
	$repin_array = array();
	$comment_array = array();
	while($query_cnts->fetch()){
		if($likes==null){
			$likes = 0;
		}
		if($repin==null){
			$repin = 0;
		}
		if($cmt==null){
			$cmt = 0;
		}
		$like_array[$pinid]=$likes;
		$repin_array[$pinid]=$repin-1;
		$comment_array[$pinid]=$cmt;
	}
	$_SESSION['like_array']=$like_array;
	$_SESSION['repin_array']=$repin_array;
	$_SESSION['comment_array']=$comment_array;
 ?>