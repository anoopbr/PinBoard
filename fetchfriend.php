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
		$( "#search" ).click(function() {
			$( "#frnd-list-close" ).slideDown();
		  $( "#frnd-srch-list-dis-blk" ).slideDown();
		});
		$( "#frnd-list-close" ).click(function() {
			$( "#frnd-list-close" ).slideUp();
		  $( "#frnd-srch-list-dis-blk" ).slideUp();
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
//echo $_SESSION['userid'];
include("header_user.php");
include("fetchfriendlists.php");
$fetchfriend_user=$_SESSION['profile_user'];
$frnd_list = $_SESSION['frnd_list'];
$pen_frnd_list = $_SESSION['pen_frnd_list'];
$app_frnd_list = $_SESSION['app_frnd_list'];
$sug_frnd_list = $_SESSION['sug_frnd_list'];
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }
$query=$con->stmt_init();

$query->prepare("SELECT friend FROM friends WHERE user=? ");
$query->bind_param('s',$_SESSION['username']);
	$query->execute();
	$query->bind_result($friendname);
	$friend_array = array();
	while($query->fetch()){
	//echo "these are your friends";
	$friend_array[]=$friendname;
	//echo "<a href='profile.php?username=$friendname'>$friendname</a>";
	//echo "<br/>";
	}
	$query->close();

if (isset($_POST['addfrnd'])) {
	$afrnd =$_POST['addfrnd'];
	$query_addfrnd="INSERT INTO FriendRelation(uname1,uname2) 
	VALUES('$current_user','$afrnd')";
	mysqli_query($con,$query_addfrnd) or die('Error: ' . mysqli_error($con));
}

if (isset($_POST['confrnd'])) {
	$afrnd =$_POST['confrnd'];
	if(!$con) 
	    {
	        die("Unable to select database");
	    }
	$confrnd=$con->stmt_init();

	$confrnd->prepare("UPDATE friendrelation set status = 'Approved' where uname1 = ? and uname2 = ? ");
	$confrnd->bind_param('ss',$afrnd,$_SESSION['username']);
	$confrnd->execute();

}

if (isset($_POST['delfrnd'])) {
	$dfrnd =$_POST['delfrnd'];
	if(!$con) 
	    {
	        die("Unable to select database");
	    }
	$delfrnd=$con->stmt_init();

	$delfrnd->prepare("DELETE FROM  friendrelation where (uname1 = ? and uname2 = ?) 
		or (uname2 = ? and uname1 = ?)");
	$delfrnd->bind_param('ssss',$_SESSION['username'],$dfrnd,$_SESSION['username'],$dfrnd);
	$delfrnd->execute();

}
 ?>
<center><div class="pin-profile-block">
<form method="POST">
<div class="pin-table" id="basic-info">
		<div class="pin-frnds-table-row">
			<div class="pin-table-cell">
					<div id="frndsearchblock" class="frndsearchblock">
						<div id="searchblock" class="searchblock">
							<input type="text" id="keyword" name="keyword" class="pin-frnd-search-box">
							<input type="submit" value="" name="frndsearch" id="frndsearch" class="pin-search-btn">
						</div>
						<div id="frnd-srch-list-dis-blk">
						<div style="display:block;border:1px solid #222;">
						<p id="frnd-list-close" class="frnd-list-close">close</p>
						</div>
						<?php  
						if (isset($_POST['frndsearch'])) {
							$keyword =  "%{$_POST['keyword']}%";
							$query_search=$con->stmt_init();
							$query_search->prepare("SELECT uname,fname,lname,image FROM view_profile WHERE uname LIKE ?
								or fname LIKE ? or lname LIKE ? or email LIKE ?");
							$query_search->bind_param('ssss',$keyword,$keyword,$keyword,$keyword);
							$query_search->execute();
							$query_search->bind_result($user,$first,$last,$image);
							$userlist = array();
							while($query_search->fetch()){
								if($user!=$current_user){
									$frd_flg="false";
									$frd_pen_flg="false";
									$frd_app_flg="false";
									foreach($frnd_list as $val){
										if($user==$val){
											$frd_flg="true";
										}
									}
									foreach($pen_frnd_list as $val){
										if($user==$val){
											$frd_pen_flg="true";
										}
									}
									foreach($app_frnd_list as $val){
										if($user==$val){
											$frd_app_flg="true";
										}
									}
									echo "<div class='frnd-srch-usr-blk'><a class='frnd-srch-usr' href='userprofile.php?username=$user'>";
									echo "<img height = 40 class='search-usr-thmb' src='data:image/jpeg;base64," .base64_encode( $image ). "' />";
									echo "<p>$user</p>";
									echo "<p class='frnd-srch-name'>$first"." "."$last</p></a>";
									if($frd_flg=="true"){
										echo "<p class='frnd-btn-txt'>Friends</p>";
									}else if($frd_pen_flg=="true"){
										echo "<p class='pen-frnd-btn-txt'>Pending</p>";
									}else if($frd_app_flg=="true"){
										echo "<p><button type='submit' class='add-frnd-btn' name='confrnd' value='$user'>Confirm</button></p>";
									}else{
									echo "<p><button type='submit' class='add-frnd-btn' name='addfrnd' value='$user'>Add Friend</button></p>";
									}
									echo "</div>";
								}
							}
						}
						 ?>
						 </div>
					</div>
			</div>
		</div>
		<div class="pin-frnds-table-row">
			<div class="pin-table-cell">
				<span class="table-box-header">Friends</span>
				<div id="frndsearchblock" class="frndsearchblock">
				<?php 
					$query_search=$con->stmt_init();
					$query_search->prepare("SELECT uname,fname,lname,image FROM view_profile");
					$query_search->execute();
					$query_search->bind_result($user,$first,$last,$image);
					$i=0;
					while($query_search->fetch()){
						if($user!=$current_user){
							foreach($frnd_list as $val){
								if($user==$val){
									$i=1;
									echo '<div class="pin-frnd-box"><center>';
									echo "<a class='frnd-srch-usr' href='userprofile.php?username=$user'>";
									echo "<img height = 100 class='usr-thmb' src='data:image/jpeg;base64," .base64_encode( $image ). "' />";

									echo "<div>";
									echo "<p>$user</p>";
									echo "<p class='frnd-srch-name'>$first"." "."$last</p></a>";
									echo "<p><button type='submit' class='add-frnd-btn' name='delfrnd' value='$user'>Delete</button></p>";
									echo '</div>';
									echo '</center></div>';
								}
							}
						}
					}
					if($i==0){
						echo "<p class='frnd-no-result'>Sorry you have not added any friends.</p>";
					}
				 ?>
				 </div>
			</div>
		</div>
		<div class="pin-frnds-table-row">
			<div class="pin-table-cell">
				<span class="table-box-header" id="frndapphblock">Friend Requests</span>
				<div id="frndsearchblock" class="frndsearchblock">
				<?php 
					$query_search=$con->stmt_init();
					$query_search->prepare("SELECT uname,fname,lname,image FROM view_profile");
					$query_search->execute();
					$query_search->bind_result($user,$first,$last,$image);
					$i=0;
					while($query_search->fetch()){
						if($user!=$current_user){
							foreach($app_frnd_list as $val){
								if($user==$val){
									$i=1;
									echo '<div class="pin-frnd-box"><center>';
									echo "<a class='frnd-srch-usr' href='userprofile.php?username=$user'>";
									echo "<img height = 100 class='usr-thmb' src='data:image/jpeg;base64," .base64_encode( $image ). "' />";

									echo "<div>";
									echo "<p>$user</p>";
									echo "<p class='frnd-srch-name'>$first"." "."$last</p></a>";
									echo "<p><button type='submit' class='add-frnd-btn' name='confrnd' value='$user'>Confirm</button></p>";
									echo "<p><button type='submit' class='add-frnd-btn' name='delfrnd' value='$user'>Delete</button></p>";
									echo '</div>';
									echo '</center></div>';
								}
							}
						}
					}
					if($i==0){
						echo "<p class='frnd-no-result'>No pending friend requests.</p>";
					}
				 ?>
				 </div>
			</div>
		</div>
		</div>
		<div class="pin-frnds-table-row">
			<div class="pin-table-cell">
				<span class="table-box-header">Friend Suggestions</span>
				<div id="frndsearchblock" class="frndsearchblock">
				<?php 
					$query_search=$con->stmt_init();
					$query_search->prepare("SELECT uname,fname,lname,image FROM view_profile");
					$query_search->execute();
					$query_search->bind_result($user,$first,$last,$image);
					$i=0;
					while($query_search->fetch()){
						$frd_flg="false";
						$frd_pen_flg="false";
						$frd_app_flg="false";
						$frd_sug_flg="false";
						if($user!=$current_user){
							foreach($sug_frnd_list as $val){
								if($user==$val){
									$frd_sug_flg="true";
								}
							}
							foreach($frnd_list as $val){
								if($user==$val){
									$frd_flg="true";
								}
							}
							foreach($pen_frnd_list as $val){
								if($user==$val){
									$frd_pen_flg="true";
								}
							}
						}
						if(($frd_sug_flg=="true")&&($frd_flg=="false")&&($frd_pen_flg=="false")){
							$i=1;
							echo '<div class="pin-frnd-box"><center>';
							echo "<a class='frnd-srch-usr' href='userprofile.php?username=$user'>";
							echo "<img height = 100 class='usr-thmb' src='data:image/jpeg;base64," .base64_encode( $image ). "' />";

							echo "<div>";
							echo "<p>$user</p>";
							echo "<p class='frnd-srch-name'>$first"." "."$last</p></a>";
							echo "<p><button type='submit' class='add-frnd-btn' name='addfrnd' value='$user'>Add Friend</button></p>";
							echo '</div>';
							echo '</center></div>';
						}
					}
					if($i==0){
						echo "<p class='frnd-no-result'>No friend suggestions available.</p>";
					}
				 ?>
				 </div>
			</div>
		</div>
		<div class="pin-frnds-table-row">
			<div class="pin-table-cell">
				<span class="table-box-header">Friend Requests Pending For Approval</span>
				<div id="frndsearchblock" class="frndsearchblock">
				<?php 
					$query_search=$con->stmt_init();
					$query_search->prepare("SELECT uname,fname,lname,image FROM view_profile");
					$query_search->execute();
					$query_search->bind_result($user,$first,$last,$image);
					$i=0;
					while($query_search->fetch()){
						$frd_flg="false";
						$frd_pen_flg="false";
						$frd_app_flg="false";
						$frd_sug_flg="false";
						if($user!=$current_user){
							foreach($pen_frnd_list as $val){
								if($user==$val){
									$frd_pen_flg="true";
								}
							}
						}
						if(($frd_pen_flg=="true")){
							$i=1;
							echo '<div class="pin-frnd-box"><center>';
							echo "<a class='frnd-srch-usr' href='userprofile.php?username=$user'>";
							echo "<img height = 100 class='usr-thmb' src='data:image/jpeg;base64," .base64_encode( $image ). "' />";

							echo "<div>";
							echo "<p>$user</p>";
							echo "<p class='frnd-srch-name'>$first"." "."$last</p></a>";
							echo "<p><button type='submit' class='add-frnd-btn' name='delfrnd' value='$user'>Delete</button></p>";
							echo '</div>';
							echo '</center></div>';
						}
					}
					if($i==0){
						echo "<p class='frnd-no-result'>No pending friend requests.</p>";
					}
				 ?>
				 </div>
			</div>
		</div>
	</div>
	</form>
</div>
<?php
include("footer.php");
 ?>
</center>
</body>
</html>