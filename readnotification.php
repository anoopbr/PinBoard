<?php 
session_start();
$current_user=$_SESSION['username'];
$user='root';
$password='';
$database='pinterest';
echo $current_user;
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }
$query_insert="Update notifications set seen='Y' where uname1='$current_user'";
mysqli_query($con,$query_insert) or die('Error: ' . mysqli_error($con));
 ?>