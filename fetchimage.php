<html>
<head>	
	<link rel="icon" type="image/png" href="images/icon.png"/>
	<title>Pinboard</title>
	<link rel="stylesheet" type="text/css" href="css/Style.css">
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
	<script>
	$().ready(function() {
		$( "#repin-blk" ).toggle();
		$( "#repin-btn" ).click(function() {
			$( "#repin-btn" ).toggle();
		  $( "#repin-blk" ).toggle( "slow", function() {
		    // Animation complete.
		  });
		});
		$( "#addtag" ).click(function() {
		    $('#pin-form').validate({ // initialize the plugin
		        rules: {
		            addtag: {
		                required: true,
		                minlength: 2
		            },
		            comment: {
		            	required: false
		            },
		            repindesc: {
		            	required: false
		            }
		        },
		        messages: {
		        	addtag:{
		        		required: "<error>addtag is required</error>",
		        		minlength: jQuery.format("<error>At least 2 characters required!</error>")
		        	}
		        }

		    });
		});

		$( "#addcomment" ).click(function() {
		    $('#pin-form').validate({ // initialize the plugin
		        rules: {
		            comment: {
		                required: true,
		                minlength: 4
		            },
		            addtag: {
		            	required: false
		            },repindesc: {
		            	required: false
		            }
		        },
		        messages: {
		        	comment:{
		        		required: "<error>comment is required</error>",
		        		minlength: jQuery.format("<error>At least 2 characters required!</error>")
		        	}
		        }

		    });
		});
		$( "#repin" ).click(function() {
		    $('#pin-form').validate({ // initialize the plugin
		        rules: {
		            repindesc: {
		                required: true,
		                minlength: 4
		            },
		            addtag: {
		            	required: false
		            },comment: {
		            	required: false
		            }
		        },
		        messages: {
		        	repindesc:{
		        		required: "<error>description is required</error>",
		        		minlength: jQuery.format("<error>At least 2 characters required!</error>")
		        	}
		        }

		    });
		});

	});
	</script>
	<style type="text/css">
	.searchblock{
		height: 29px;
	}
	</style>
</head>
<body>
<?php 
session_start();
include("header_user.php");
include("fetchuserboards.php");

$bid_list=$_SESSION['bid_list'];
?>
<center>
<div class="pin-profile-block">
<form method="POST" id="pin-form">
<?php
$current_user=$_SESSION['username'];
$pinid=$_GET['pinid'];
$bid=$_GET['boardid'];
$_SESSION['pinid']=$pinid;
include("fetchprivilegedusers.php");
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }
if (isset($_POST['like'])) {
	$opin= $_POST['opin'];
	$query_insert="INSERT INTO likes(pinid,uname) 
		VALUES('$opin','$current_user')";
	mysqli_query($con,$query_insert) or die('Error: ' . mysqli_error($con));
}
if (isset($_POST['unlike'])) {
	$opin=$_POST['opin'];
	$query_delete="DELETE from likes where pinid='".$opin."' and uname='".$current_user."'";
	mysqli_query($con,$query_delete) or die('Error: ' . mysqli_error($con));
}
if (isset($_POST['repin'])) {
	$desc=$_POST['repindesc'];
	$opin=$_POST['opin'];
	$bid = $_POST['boards'];
	$querymaxpinid=$con->stmt_init();
    $querymaxpinid->prepare("SELECT max(pinid) FROM pin");
	$querymaxpinid->execute();
	$querymaxpinid->bind_result($pinid);
	while($querymaxpinid->fetch()){
		$pin= $pinid;
	}
	$pin = $pin + 1;

    $query_insert="INSERT INTO pin(pinid,boardid,o_pinid,description) 
    VALUES('$pin','$bid','$opin','$desc')";
	mysqli_query($con,$query_insert) or die('Error: ');
	Header("Location: fetchimage.php?pinid=$pin&boardid=$bid");
}
if (isset($_POST['addtag'])) {
	$tag=$_POST['tag'];
	$opin=$_POST['opin'];
	$query_insert2="INSERT INTO tag(pinid,uname,tag) 
		VALUES('$opin','$current_user','$tag')";
	mysqli_query($con,$query_insert2) or die('Error: ' . mysqli_error($con));
}

if (isset($_POST['delete'])) {
	if(!$con) 
	    {
	        die("Unable to select database");
	    }
	$delquery=$con->stmt_init();

	$delquery->prepare("DELETE FROM  pin where pinid = ?");
	$delquery->bind_param('i',$_GET['pinid']);
	$delquery->execute();
}

if (isset($_POST['addcomment'])) {
	$comment= $_POST['comment'];
	$query_insert="INSERT INTO comments(pinid,uname,description) 
		VALUES('$pinid','$current_user','$comment')";
	mysqli_query($con,$query_insert) or die('Error: ' . mysqli_error($con));
}

if (isset($_POST['delcomments'])) {
	if(!$con) 
	    {
	        die("Unable to select database");
	    }
	$delcomquery=$con->stmt_init();

	$delcomquery->prepare("DELETE FROM  comments where pinid = ?");
	$delcomquery->bind_param('i',$_GET['pinid']);
	$delcomquery->execute();
}

$query=$con->stmt_init();

$query->prepare("SELECT opin,title,user,priv,pic,url,image,time
	 FROM fetch_pics WHERE pinid=? ");
$query->bind_param('s',$pinid);
$query->execute();
$query->bind_result($opin,$title,$user,$priv,$pic,$url,$image,$time);
while($query->fetch()){
	echo "<p><a class='back-btn' href='fetchpins.php?type=board&id=".$bid."'>back to board</a></p>";
	echo "<a href='".$url."'>";
	echo '<img width = 700 src="data:image/jpeg;base64,' .base64_encode( $image ). '" />';
	echo "</a>";
	 ?>
	<p class="pin-board-hd"> <?php echo $title; ?> </p>
	<p class="pin-board-txt"> <?php echo $time; ?> </p>
	<p class="pin-board-txt"> <?php echo $user; ?> </p>
	<?php
	$user=$user;
	$priv=$priv;
	echo '<input type="hidden" name="opin" value="'.$opin.'">';
}
$query1=$con->stmt_init();
$query1->prepare("SELECT count(*)
	 FROM likes WHERE pinid=? and uname=? ");
$query1->bind_param('ss',$opin,$current_user);
$query1->execute();
$query1->bind_result($cnt);
while($query1->fetch()){
	$likes =$cnt;
}

$query2=$con->stmt_init();
$query2->prepare("SELECT count(*)
	 FROM likes WHERE pinid=?");
$query2->bind_param('s',$opin);
$query2->execute();
$query2->bind_result($cnt);
while($query2->fetch()){
	$like_count =$cnt;
}
$query3=$con->stmt_init();
$query3->prepare("SELECT tag FROM tag WHERE pinid=?");
$query3->bind_param('s',$opin);
$query3->execute();
$query3->bind_result($tg);
$tags=array();
while($query3->fetch()){
	$tags[] =$tg;
}

$query_fetch_comments=$con->stmt_init();
$query_fetch_comments->prepare("SELECT uname,text,fname,lname,userimage,time
 FROM fetch_comments WHERE pin=? order by time desc");
$query_fetch_comments->bind_param('s',$_GET['pinid']);
$query_fetch_comments->execute();
$query_fetch_comments->bind_result($uname,$text,$fname,$lname,$userimage,$time);

$privuser="false";
$priuserlist=$_SESSION['priuserlist'];

?>
<div class="pin-table">
<div class="pin-table-head-row">
<div class="pin-table-cell">
<?php
if($likes>0){
	echo '<input type="submit" value="unlike" name="unlike" id="unlike" class="pin-like-btn">';
}else{
	echo '<input type="submit" value="like" name="like" id="like" class="pin-like-btn">';
}
echo '<span class="pin-like-cnt">'.$like_count.'</span>';
 ?>
 	</div>
	<div class="pin-table-cell">
		<div id="tagblock" class="repin-blk">
			<span class="pin-tag-btn" id="repin-btn">repin</span>
			<div id="repin-blk" class="repin-form-blk">
				<input type="text" id="repindesc" name="repindesc" class="pin-input-box">
				<?php 
				echo "<select name='boards' id='boards'>";
				foreach ($bid_list as $key => $value) {
					if($key!=0){
						echo "<option value='$key'>$value</option>";
					}
				}
				echo "</select>";
				 ?>
				<input type="submit" value="repin" id="repin" name="repin" class="pin-tag-btn">
			</div>
		</div>
	</div>
	<div class="pin-table-cell">
	<div id="tagblock" class="tagblock">
		<input type="text" id="tag" name="tag" class="pin-input-box">
		<input type="submit" value="add tag" name="addtag" id="addtag" class="pin-tag-btn">
	<?php  
		if(!isset($tags) || !isset($tags)){
		echo" No Tags";
		}
		else{
		foreach($tags as $val)
		{
		echo "<span class='pin-tag-text'><a class='no-ul' href='search.php?keyword=$val'>$val</a></span>";
		}
		}
	 ?>
	</div>
	</div>
	<div class="pin-table-cell">
	<?php 
	if($user==$current_user){
		echo '<input type="submit" value="delete" name="delete" id="delete" class="pin-like-btn">';
	}
	 ?>
	
	</div>
	</div>
	</div>
	<div class="pin-comment-blk">
		<div class='comment-box'>
		<?php 	
			while($query_fetch_comments->fetch()){
				echo "<div class='user-comment-blk'><a class='frnd-srch-usr' href='userprofile.php?username=$uname'>";
				echo "<img height = 30 class='cmt-thmb' src='data:image/jpeg;base64," .base64_encode( $userimage ). "' />";
				echo "<span class='user-comment-text'>$text</span>";
				echo "<span class='user-comment-name'>$uname</span>";
				if($time<=60){
					echo "<span class='user-comment-time'>$time seconds ago</span>";
				}else if($time<=3600){
					$time=ceil($time / 60);
					echo "<span class='user-comment-time'>$time miniutes ago</span>";
				}else if($time<=86400){
					$time=ceil($time / 3600);
					echo "<span class='user-comment-time'>$time hours ago</span>";
				}else if($time<=604800){
					$time=ceil($time / 86400);
					echo "<span class='user-comment-time'>$time weeks ago</span>";
				}else{
					$time=ceil($time / 604800);
					echo "<span class='user-comment-time'>$time months ago</span>";
				}
				if(($uname==$current_user)||($current_user==$user)){
				echo '<input type="submit" value="delete" name="delcomment" id="delcomment" class="pin-comment-del-btn">';
				}
				echo "</a></div>";
			}
		mysqli_close($con);
		foreach ($priuserlist as $value) {
			if($value==$current_user){

				$privuser="true";
			}
			# code...
		}
		if($priv=='N' || ($privuser=="true" && $priv=='Y')){
		 ?>
			<div class='user-comment-blk'>
				<textarea name="comment" id="comment" class="pin-comment-area" rows="5"></textarea>
				<p><input type="submit" value="post" name="addcomment" id="addcomment" class="pin-comment-btn"></p>
			</div>
		</div>
		<?php 
		}
		?>
	</div>
</form>
</div>
</center>
</body>