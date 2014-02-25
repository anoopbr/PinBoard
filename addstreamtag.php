<?php
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
	{
		die("Unable to select database");
	}
if (isset($_POST['addstreamtag'])) {
	$stream=$_POST['stream'];
	$tags=$_POST['followtag'];
	$tagList=explode(",", $tags);
	if(!$con) 
		{
			die("Unable to select database");
		}
	foreach ($tagList as $key) {
		$query_insert="INSERT INTO streamtag(streamid,tag) 
		VALUES('$stream','$key')";
		mysqli_query($con,$query_insert) or die('Error: ' . mysqli_error($con));
	}
	Header("Location: fetchpins.php?type=stream&id=$stream");
		
}

if (isset($_POST['addstreamboard'])) {
	$stream=$_POST['stream'];
	if(!$con) 
		{
			die("Unable to select database");
		}
	if( isset($_POST['followstreamboard']) && is_array($_POST['followstreamboard']) ) {
	    foreach($_POST['followstreamboard'] as $key) {
	    	echo $key;
		$query_insert="INSERT INTO streamitem(streamid,boardid) 
		VALUES('$stream','$key')";
		mysqli_query($con,$query_insert) or die('Error: ' . mysqli_error($con));
	    }
	}
	Header("Location: fetchpins.php?type=stream&id=$stream");
}
mysqli_close($con);	
?>
