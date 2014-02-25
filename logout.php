<html>
<head>
	<link rel="icon" type="image/png" href="images/icon.png"/>
	<title>Pinboard</title>
	<link rel="stylesheet" type="text/css" href="css/Style.css">
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>

</head>
<body class="home-body">
<center>
<?php
session_start();
session_destroy();
?>
<div class="home-block1">
	<img src="images/logo.png"class="pin-home-logo" id="logo">
	<div>
		<a href="#home-block2"><img src="images/about.png"class="pin-home-btn"></a>
		<a href="login.php"><img src="images/signin.png"class="pin-home-btn"></a>
		<a href="Register.php"><img src="images/signup.png"class="pin-home-btn"></a>
	</div>
</div>
</center>
</body>