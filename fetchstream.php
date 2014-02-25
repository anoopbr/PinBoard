<?php
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }

$querystream=$con->stmt_init();

$querystream->prepare("SELECT streamid,streamname,uname,description,
	picid,createtime,streamimage FROM fetch_stream_details WHERE uname = ? ORDER BY
	createtime DESC ");
$querystream->bind_param('s',$current_user);
$querystream->execute();
$querystream->bind_result($streamid,$streamnane,$uname,$description,
	$picid,$createtime,$streamimage);
$streamList = array();
while($querystream->fetch()){
 $streamList[$streamid]=$streamnane;
}
mysqli_close($con);
?>
