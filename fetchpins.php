<html>
<head>	
	<link rel="icon" type="image/png" href="images/icon.png"/>
	<title>Pinboard</title>
	<link rel="stylesheet" type="text/css" href="css/Style.css">
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
	<style type="text/css">
	.searchblock{
		height: 29px;
	}
	</style>
	<script>
	$().ready(function() {
		$( "#boardsearchclose" ).click(function() {
			$( "#search-res-tag" ).slideUp();
		});
	});
	</script>
</head>
<body>
<?php 
session_start();
include("header_user.php");
include("fetchuserboards.php");
$username=$_SESSION['username'];
$bid_list=$_SESSION['bid_list'];
?>
<center>
<div class="pin-profile-block">
<?php
$type=$_GET['type'];
$id=$_GET['id'];
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }
$query=$con->stmt_init();
?>
<form method="POST" name="board-search">
	<div id="boardsearchblock" class="boardsearchblock">
		<input type="text" id="keyword" name="keyword" class="pin-frnd-search-box">
		<input type="submit" value="" name="boardsearch" id="frndsearch" class="pin-search-btn">
	</div>
	<div>
	<?php 
	if (isset($_POST['boardsearch'])) {
		$keyword =  "%{$_POST['keyword']}%";
		$query_search=$con->stmt_init();
		$query_search->prepare("SELECT distinct(pin),opin,pintitle,pinpicid,pinpicurl,pinimage,boardid,boardname,uname,description,
		picid,createtime,boardimage,fname,lname,userimage FROM tag_pin where
		boardid = ? AND ( tag like ? OR pintitle LIKE ? )ORDER BY createtime DESC");
		$query_search->bind_param('sss',$id,$keyword,$keyword);
		$query_search->execute();
		$query_search->bind_result($pin,$opin,$pintitle,$pinpicid,$pinpicurl,$pinimage,$bid,$bname,$uname,$description,
						$picid,$createtime,$boardimage,$fname,$lname,$userimage);
		$query_search->store_result();

		echo '<div class="add-forms" id="search-res-tag">';
		echo "<p id='boardsearchclose' class='frnd-list-close'>close</p>";
		if($query_search->num_rows>0){
			echo '<p class="pin-board-hd">There are <b>'.$query_search->num_rows.'</b> pins matching tag <b>"'.$_POST['keyword'].'"</b> </p>';
			while($query_search->fetch()){
				?>
				<div class="pin-board-thumb-box">
				<?php 
				echo "<a  class='pin-board-hd' href='fetchimage.php?pinid=$pin&boardid=$bid'>"; 
				echo '<img width=200 src="data:image/jpeg;base64,' .base64_encode( $pinimage ). '" /></a>';
				?>
				<p> <?php echo $pintitle; ?> </p>
				<?php
				echo '<div class="pin-board-thumb-bdetails">';
				echo "<a  class='pin-board-txt' href='fetchpins.php?boardid=$bid'>"; 
				echo '<p><img height=30 class="pin-board-thumb-img" src="data:image/jpeg;base64,' .base64_encode( $boardimage ). '" /></p>';
				?>
				<p class="pin-board-thumb-txt"> <?php echo $bname; ?> </p></a></div>
				<?php
				echo '<div class="pin-board-thumb-bdetails">';
				echo "<a  class='pin-board-txt' href='profile.php?username=$uname'>"; 
				echo '<p><img height=30 class="pin-board-thumb-img" src="data:image/jpeg;base64,' .base64_encode( $userimage ). '" /></p>';
				?>		
				<p class="pin-board-thumb-txt"> <?php echo $uname; ?> </p>
				</a></div>
			</div>
			<?php
		}
		}else{
			echo '<p class="pin-board-hd">Sorry, No results matching tag "'.$_POST['keyword'].'" !</p>';
		}
		echo '</div>';

	}
	 ?>
	</div>
</form>
<?php

if (isset($_POST['formsubmit']))
    {
    $query->prepare("SELECT max(picid) FROM picture");
	$query->execute();
	$query->bind_result($picid);
	while($query->fetch()){
		$pid= $picid;
	}
	$pid = $pid + 1;
    $image = $_FILES['image'] ;
    $name = $_FILES['image']['name'] ;
    $message =$_POST['message'];
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name'])) ; 
    $query = "INSERT INTO picture (picid,picurl, image) VALUES ('$pid','{$name}', '{$image}')";
    $result = mysqli_query($con, $query)  or die('something wrong' . mysql_error());    
    

    //select max of pinid
    $query1=$con->stmt_init();
    $query1->prepare("SELECT max(pinid) FROM pin");
	$query1->execute();
	$query1->bind_result($pinid);
	while($query1->fetch()){
		$pin= $pinid;
	}
	$pin = $pin + 1;

    $query_insert="INSERT INTO pin(pinid,boardid,picid,description) 
    VALUES('$pin','$boardid','$pid','$message')";
	mysqli_query($con,$query_insert) or die('Error: ');
    //$id = (int) mysqli_insert_id($result);
    //header('Location: image_view.php?id=' . $id);
    //exit;
    }
if($type=="board" && $id!=""){
	$fecth_query=$con->stmt_init();
	$fecth_query->prepare("SELECT pinid,opin,user,title,pic,url,image,time
	 FROM fetch_pics WHERE boardid=? ");
	$fecth_query->bind_param('s',$id);
	$fecth_query->execute();
	$fecth_query->bind_result($pinid,$opin,$uname,$text,$pic,$url,$image,$time);
	while($fecth_query->fetch()){
		?>
		<div class="pin-image-box">
			<?php
			echo '<a href ="fetchimage.php?pinid='.$pinid.'&boardid='.$id.'"><img height=200 src="data:image/jpeg;base64,' .base64_encode( $image ). '" /></a>';
			 ?>
			<p class="pin-board-hd"> <?php echo $text; ?> </p>
		</div>
		<?php 
	}
}

if($type=="stream" && $id!=""){
	$fecth_query=$con->stmt_init();
	$querystream=$con->stmt_init();
	$fecth_query->prepare("SELECT pinid
	 FROM fetch_stream_pics WHERE streamid=? ");
	$querystream->prepare("SELECT distinct opin,title,user,priv,pic,url,image,time
		 FROM fetch_pics WHERE pinid=? ");
	$fecth_query->bind_param('s',$id);
	$fecth_query->execute();
	$fecth_query->bind_result($pinid);
	$pidlist=array();
	while($fecth_query->fetch()){
		$pidlist[] = $pinid;
	}

	$querystreamtag=$con->stmt_init();
	$querystreamtag->prepare("SELECT pinid FROM tag where tag like ?");

	$querytag=$con->stmt_init();
	$querytag->prepare("SELECT tag
	 FROM streamtag WHERE streamid=? ");

	$querytag->bind_param('s',$id);
	$querytag->execute();
	$querytag->bind_result($tag);
	$strtaglist=array();
	while($querytag->fetch()){
		$tag=str_replace(" ","",$tag);
		$tag="%".$tag."%";
		$strtaglist[]=$tag;
	}

	foreach ($strtaglist as $key) {
		$querystreamtag->bind_param('s',$key);
		$querystreamtag->execute();
		$querystreamtag->bind_result($pinid);
		while($querystreamtag->fetch()){
			$pidlist[] = $pinid;
		}
	}

	$pidlist = array_unique($pidlist);
	foreach ($pidlist as $key ) {
		$p = $key;
		$querystream->bind_param('s',$p );
		$querystream->execute();
		$querystream->bind_result($opin,$title,$user,$priv,$pic,$url,$image,$time);
		while($querystream->fetch()){
			?>
			<div class="pin-image-box">
				<?php
				echo '<a href ="fetchimage.php?pinid='.$opin.'&boardid='.$id.'"><img height=200 src="data:image/jpeg;base64,' .base64_encode( $image ). '" /></a>';
				 ?>
				<p class="pin-board-hd"> <?php echo $title; ?> </p>
			</div>
			<?php 
		}

	}

}
?>
<?php 
$brd_flag="false";
foreach ($bid_list as $key => $value) {
	if($key==$id){
		$brd_flag="true";
	}
}

echo "<p><a class='back-btn' href='profile.php?username=".$username."'>back to boards</a></p>";

?>

 </div>
 <?php 
include("footer.php");
 ?>
 </center>
 </body>