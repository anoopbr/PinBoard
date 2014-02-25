<?php
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }

$querypriusers=$con->stmt_init();
$querypriusers->prepare("SELECT uname FROM allowed_users WHERE pinid = ?");
$querypriusers->bind_param('s',$pinid);
$querypriusers->execute();
$querypriusers->bind_result($uname);
$priuserlist = array();
while($querypriusers->fetch()){
 $priuserlist[]=$uname;
}
$_SESSION['priuserlist']=$priuserlist;
?>
