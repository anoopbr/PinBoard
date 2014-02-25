<?php
//Creating a connection for prepared statement
$dbPrepare =new mysqli("localhost","root","", "pinterest");
if ($dbPrepare->connect_error){
//http_redirect("error.php", array("sqlerr" => "Database Connectivity Lost!!"));
Header("Location: error.php");
}

// or die("Could not connect");
//if (!$dbPrepare)
  //{
 	//Header("Location: error.php");
	//die (Header("Location: error.php"));
  //}
$query=$dbPrepare->stmt_init();
?>
