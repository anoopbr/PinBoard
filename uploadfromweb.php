<?php 
$bid_list=$_SESSION['bid_list'];
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }
$query=$con->stmt_init();
if (isset($_POST['download'])){
	$img = file_get_contents($_POST['url']);
	$link = $_POST['url'];
    $query->prepare("SELECT max(picid) FROM picture");
	$query->execute();
	$query->bind_result($picid);
	while($query->fetch()){
		$pid= $picid;
	}
	$pid = $pid + 1;

	$content = file_get_contents($_POST['url']);
	$filename = './userdir/'.$current_user.'/'. basename($_POST['url']);
	file_put_contents($filename, $content);
	$url = $_POST['website'];

    $image = addslashes($content) ; 
    $query = "INSERT INTO picture (picid,picurl, image) VALUES ('$pid','{$url}', '{$image}')";
    $result = mysqli_query($con, $query)  or die('something wrong' . mysql_error()); 

    $query1=$con->stmt_init();
    $query1->prepare("SELECT max(pinid) FROM pin");
	$query1->execute();
	$query1->bind_result($pinid);
	while($query1->fetch()){
		$pin= $pinid;
	}
	$pin = $pin + 1;

	$title = $_POST['url'];
	$bid = $_POST['boards'];
	$title = $_POST['title'];
    $query_insert="INSERT INTO pin(pinid,boardid,picid,description) 
    VALUES('$pin','$bid','$pid','$title')";
	mysqli_query($con,$query_insert) or die('Error: ');

	if($_POST['webtags']!=""||$_POST['webtags']!=null){
		$tags=$_POST['webtags'];
		$current_user= $_SESSION['username'];
        $tagList=explode(",", $tags);
        if(!$con) 
            {
                die("Unable to select database");
            }
        foreach ($tagList as $key) {
        	$key=str_replace(" ", "", $key);
       		$key=strtolower($key);
            $query_insert="INSERT INTO tag(pinid,uname,tag) 
            VALUES('$pin','$current_user','$key')";
            mysqli_query($con,$query_insert) or die('Error: ' . mysqli_error($con));
        }
	}

	Header("Location: fetchimage.php?pinid=$pin&boardid=$bid");

}
?>
