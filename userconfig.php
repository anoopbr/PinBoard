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
$query_frnds=$con->stmt_init();

$query_frnds->prepare("SELECT friend FROM friends WHERE user=? ");
$query_frnds->bind_param('s',$current_user);
	$query_frnds->execute();
	$query_frnds->bind_result($friendname);
	$friend_array = array();
	while($query_frnds->fetch()){
		$friend_array[]=$friendname;
	}

$_SESSION['frnd_list'] = $friend_array;

$query_penfrnds=$con->stmt_init();

$query_penfrnds->prepare("SELECT friend FROM friends_pending WHERE user=? ");
$query_penfrnds->bind_param('s',$current_user);
$query_penfrnds->execute();
$query_penfrnds->bind_result($friendname);
$penfriend_array = array();
while($query_penfrnds->fetch()){
	$penfriend_array[]=$friendname;
}
$_SESSION['pen_frnd_list'] = $penfriend_array;

$query_approvefrnds=$con->stmt_init();

$query_approvefrnds->prepare("SELECT friend FROM Friends_approval WHERE user=? ");
$query_approvefrnds->bind_param('s',$current_user);
$query_approvefrnds->execute();
$query_approvefrnds->bind_result($friendname);
$appfriend_array = array();
while($query_approvefrnds->fetch()){
	$appfriend_array[]=$friendname;
}
$_SESSION['app_frnd_list'] = $appfriend_array;

$query_sugestfrnds=$con->stmt_init();

$query_sugestfrnds->prepare("SELECT friend FROM Friend_suggestion WHERE user=? ");
$query_sugestfrnds->bind_param('s',$current_user);
$query_sugestfrnds->execute();
$query_sugestfrnds->bind_result($friendname);
$sugfriend_array = array();
while($query_sugestfrnds->fetch()){
	$sugfriend_array[]=$friendname;
}
$_SESSION['sug_frnd_list'] = $sugfriend_array;

?>
