<script type="text/javascript" src="js/actions.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script>
 	$().ready(function() {
		$('#add-elements-form').validate({ // initialize the plugin
	        rules: {
	            url: {
	                required: true,
	                minlength: 6
	            },
	            title: {
	                required: true,
	                minlength: 6
	            },
	            website: {
	            	required: true,
	            	minlength:6
	            },
	            webtags: {
	            	required: true,
	            	minlength: 2
	            },
	            comptags: {
	            	required: true,
	            	minlength: 2
	            },
	            message:{
	            	required: true,
	            	minlength: 6
	            },
	            boardname:{
	            	required: true,
	            	minlength: 6
	            },
	            desc:{
	            	required: true,
	            	minlength: 10
	            },
	            followtag:{
	            	required: true,
	            	minlength: 2
	            },
	            image:{
	            	required: true
	            },
	            streamname:{
	            	required: true,
	            	minlength: 6
	            },
	            streamdesc:{
	            	required: true,
	            	minlength: 10
	            }
	        },
	        messages: {
	        	url:{
	        		required: "<error>url is required</error>",
	        		minlength: jQuery.format("<error>At least 6 characters required!</error>")
	        	},
	        	title:{
	        		required: "<error>title is required</error>",
	        		minlength: jQuery.format("<error>At least 6 characters required!</error>")
	        	},
	        	website:{
	        		required: "<error>website is required</error>",
	        		minlength: jQuery.format("<error>At least 6 characters required!</error>")
	        	},
	        	webtags:{
	        		required: "<error>Tag is required</error>",
	        		minlength: jQuery.format("<error>At least 2 characters required!</error>")
	        	},
	            comptags: {
	        		required: "<error>Tag is required</error>",
	        		minlength: jQuery.format("<error>At least 2 characters required!</error>")
	            },
	            message:{
	        		required: "<error>message  is required</error>",
	        		minlength: jQuery.format("<error>At least 6 characters required!</error>")
	            },
	            boardname:{
	        		required: "<error>Board name is required</error>",
	        		minlength: jQuery.format("<error>At least 6 characters required!</error>")
	            },
	            desc:{
	        		required: "<error>Description is required</error>",
	        		minlength: jQuery.format("<error>At least 10 characters required!</error>")
	            },
	            followtag:{
	        		required: "<error>Tag is required</error>",
	        		minlength: jQuery.format("<error>At least 2 characters required!</error>")
	            },image:{
	            	required: "<error>Image is required</error>"
	            },
	            streamname:{
	        		required: "<error>Description is required</error>",
	        		minlength: jQuery.format("<error>At least 6 characters required!</error>")
	            },
	            streamdesc:{
	        		required: "<error>Description is required</error>",
	        		minlength: jQuery.format("<error>At least 10 characters required!</error>")
	            }
	        }

	    });
});

</script>
<form method="POST" id="add-elements-form"style="height:auto;" enctype="multipart/form-data">
<div class="pin-header-block">
	<?php 
	include("fetchuserdetails.php");
	include("fetchfriendlists.php");
	include("fetchuserboards.php");
	include("uploadfromweb.php");
	include("uploadfromcomp.php");
	include("addboard.php");
	include("addstream.php");
	include("fetchstream.php");
	include("fetchotherboards.php");
	include("addstreamtag.php");
	include("getnotification.php");
	$current_user=$_SESSION['username'];
	$frnd_req_pending=$_SESSION['frnd_req_pending'];
	$notifications_array=$_SESSION['notifications_array'];
	$not_cnt=count($notifications_array);
	$image=$_SESSION['image'];
	if (isset($_POST['search'])){
		$searchkey =$_POST['keyword'];
		Header("Location: search.php?keyword=$searchkey");
	}
	echo "<a href='profile.php?username=$current_user'><img src='images/logo.png' class='pin-logo'></a>";
	 ?>
	<a href="Index.php" class="pin-hd-btn">logout</a>
	<?php
	echo "<a href='editprofile.php?username=$current_user'  class='pin-hd-btn'>
	<img width = 20 class='usr-thmb' src='data:image/jpeg;base64," .base64_encode( $image ). "' />$current_user</a>";
	if($frnd_req_pending>0){
		$msg="You have ".$frnd_req_pending." pending friend requests";
		echo "<a href='fetchfriend.php'  class='pin-hd-btn' title='$msg'>friends
		<span class='pin-hd-btn-hl'>$frnd_req_pending</span></a>";
	}else{
		echo "<a href='fetchfriend.php'  class='pin-hd-btn'>friends</a>";
	}
	if($not_cnt>0){
		$msg="You have ".$not_cnt." new notifications";
		echo "<a href='#'  class='pin-hd-btn' id='not-btn' title='$msg'><img src='images/notific.png' height='20px'>
		<span class='pin-hd-btn-hl2'>$not_cnt</span></a>";
	}else{
		echo "<a href='#'  class='pin-hd-btn'><img src='images/notific.png' height='20px'></a>";
	}
	 ?>
	 <a href='#' class='pin-hd-btn' id="add-pin"><img src='images/add.png' height="20px"></a>
	 <a href="userboard.php" class="pin-hd-btn">my items</a>
	<div id="searchblock" class="searchblock">
			<input type="text" id="keyword" name="keyword" class="pin-search-box">
			<input type="submit" value="" name="search" id="search" class="pin-search-btn">
	</div>
</div>

<div id="add-notification" class="add-notification">
	<?php 
		foreach ($notifications_array as $msg) {
			echo '<div class="add-selection-blck">'.$msg.'</div>';
		}
	 ?>
</div>

<div id="add-selection" class="add-selection">
	<div class="add-selection-blck" id="add-upload">upload pin</div>
	<div class="add-selection-blck" id="add-web">Add from a website</div>
	<div class="add-selection-blck" id="add-follow">Add to follow Stream</div>
	<div class="add-selection-blck" id="add-board">Add board</div>
	<div class="add-selection-blck" id="add-stream">Add follow stream</div>
</div>
<center>
<div id="add-upload-form" class="add-forms">
	<div class="close-blck">
		<span class="close-btn" id="close-upload-form">X</span>
	</div>
	<h1>Upload an image</h1> 
	<?php 
		$cnt= count($bid_list);
		if($cnt>1){
	 ?>
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
	<p id="phup">Click browse button to choose photo:<br /><input type="file" name="image" /></p>
	<textarea id="message"  name="message" maxlenght="350"  rows="2" col="200" class="pin-input-area" ></textarea>
	<br />
	<div class="pin-table-row">
		<div class="pin-table-cell">
			Board
		</div>
		<div class="pin-table-cell">
			<?php 
			echo "<select name='compboards' id='compboards'>";
			foreach ($bid_list as $key => $value) {
				if($key!=0){
					echo "<option value='$key'>$value</option>";
				}
			}
			echo "</select>";
			 ?>
		</div>
	</div>
	<p><h4>Enter tags seperated by ','. Only alpahbtes and numbers are allowed.</h4></p>
	<div class="pin-table-row">
		<div class="pin-table-cell">
			Tags
		</div>
		<div class="pin-table-cell">
			<textarea name="comptags" id="comptags" class="pin-input-area" rows="5"></textarea>
		</div>
		</div>
	<input type="submit" name="upload" value="upload here" size="15" />
	<?php 
		}
		else{
			echo "<p><h4>Please create a board to start uploading.</h4></p>";
		}
	 ?>
</div>

<div id="add-web-form" class="add-forms">
	<div class="close-blck">
		<span class="close-btn" id="close-web-form">X</span>
	</div>
	<h1>Add a pin from a website</h1>
	<?php 
		$cnt= count($bid_list);
		if($cnt>1){
	 ?>
	<div class="pin-table">
		<div class="pin-table-head-row">
			<div class="pin-table-cell">
				URL:
			</div>
			<div class="pin-table-cell">
				<input name="url" id="url" type="text" class="pin-input-box">
			</div>
		</div>
		<div class="pin-table-row">
			<div class="pin-table-cell">
				Title
			</div>
			<div class="pin-table-cell">
				<input name="title" id="title" type="text" class="pin-input-box">
			</div>
		</div>
		<div class="pin-table-row">
			<div class="pin-table-cell">
				Board
			</div>
			<div class="pin-table-cell">
				<?php 
				echo "<select name='boards' id='boards'>";
				foreach ($bid_list as $key => $value) {
					if($key!=0){
						echo "<option value='$key'>$value</option>";
					}
				}
				echo "</select>";
				 ?>
			</div>
		</div>
		<div class="pin-table-row">
			<div class="pin-table-cell">
				Website
			</div>
			<div class="pin-table-cell">
				<input name="website" id="website" type="text" class="pin-input-box">
			</div>
		</div>
		<div class="pin-table-row">
			<div class="pin-table-cell">
				Tags
			</div>
			<div class="pin-table-cell">
				<p><h4>Enter tags seperated by ','. Only alpahbtes and numbers are allowed.</h4></p>
				<textarea name="webtags" id="webtags" class="pin-input-area" rows="5"></textarea>
			</div>
		</div>
	</div>
	<div>
	<p><input type="submit" value="Create pin" class="pin-btn-long" name="download"></p>
	</div>
	<?php 
		}
		else{
			echo "<p><h4>Please create a board to start uploading.</h4></p>";
		}
	 ?>
</div>

<div id="add-board-form" class="add-forms">
	<div class="close-blck">
		<span class="close-btn" id="close-board-form">X</span>
	</div>
	<h1>Create board</h1>
	  <div id="create-board-blk">
	  	<div class="pin-table" id="basic-info">
			<div class="pin-table-head-row">
				<div class="pin-table-cell">
					Name
				</div>
				<div class="pin-table-cell">
					<input name="boardname" id="boardname" type="text" class="pin-input-box">
					<span id = "uname_status"> </span>
				</div>
			</div>
			<div class="pin-table-head-row">
				<div class="pin-table-cell">
					Category
				</div>
				<div class="pin-table-cell">
					<?php  
					if(!isset($catList) || !isset($catList)){
						echo" No Categories";
					}
					else{
						echo "<select name='category' id='category'>";
						foreach($catList as $key => $val)
						{
						echo "<option value='$key'>$val</option>";
						}
						echo "</select>";
					}
					?>
					<span id = "uname_status"> </span>
				</div>
			</div>
			<div class="pin-table-head-row">
				<div class="pin-table-cell">
					Description
				</div>
				<div class="pin-table-cell">
					<textarea name="desc" id="desc" class="pin-input-area" rows="5"></textarea>
				</div>
			</div>
			<div class="pin-table-head-row">
				<div class="pin-table-cell">
					Secret
				</div>
				<div class="pin-table-cell">
				  <div id="secret-radio">
				    <input type="radio" id="secret-radio" name="secret-radio" value="Y"><label for="radio1">Y</label>
				    <input type="radio" id="secret-radio" name="secret-radio" value="N" checked="checked"><label for="radio2">N</label>
				  </div>
				</div>
			</div>
			<div class="pin-table-head-row">
				<div class="pin-table-cell">
					Privileged
				</div>
				<div class="pin-table-cell">
				  <div id="comment-radio">
				    <input type="radio" id="comment-radio" name="comment-radio" value="Y"><label for="radio1">Y</label>
				    <input type="radio" id="comment-radio" name="comment-radio" value="N" checked="checked"><label for="radio2">N</label>
				  </div>
				</div>
			</div>
		</div>
		<input type="submit" id="add-board" value="Create Board" name="addboard" class="pin-btn-long">
	</div>
</div>

<div id="add-stream-form" class="add-forms">
	<div class="close-blck">
		<span class="close-btn" id="close-stream-form">X</span>
	</div>
	<h1>Create follow stream</h1>
  	<div class="pin-table" id="basic-info">
		<div class="pin-table-head-row">
			<div class="pin-table-cell">
				Name
			</div>
			<div class="pin-table-cell">
				<input name="streamname" id="streamname" type="text" class="pin-input-box">
				<span id = "uname_status"> </span>
			</div>
		</div>
		<div class="pin-table-head-row">
			<div class="pin-table-cell">
				Description
			</div>
			<div class="pin-table-cell">
				<input name="streamdesc" id="streamdesc" type="text" class="pin-input-box">
				<span id = "uname_status"> </span>
			</div>
		</div>
	</div>
	<input type="submit" id="add-strem" value="Create Stream" name="addstream" class="pin-btn-long">
</div>

<div id="add-follow-form" class="add-forms">
	<div class="close-blck">
		<span class="close-btn" id="close-follow-form">X</span>
	</div>
	<h1>Add to follow stream</h1>
	<?php 
		$cnt= count($streamList);
		$cnt2= count($o_bid_list);
		if($cnt>0&&$cnt2>1){
	 ?>
	<div class="pin-tab">
		<span class="pin-tab-btn" id="see-stream-tag">Tags</span>
		<span class="pin-tab-btn" id="see-stream-board">Boards</span>
	</div>
		<div class="pin-table-head-row">
			<div class="pin-table-cell">
				Follow Stream
			</div>
			<div class="pin-table-cell">
				<?php  
				if(!isset($streamList) || !isset($streamList)){
					echo" You have not created any follow stream.";
				}
				else{
					echo "<select name='stream' id='stream' class='pin-select-box'>";
					foreach($streamList as $key => $val)
					{
					echo "<option value='$key'>$val</option>";
					}
					echo "</select>";
				}
				?>
			</div>
		</div>
	<div id="pin-stream-tag">
		<p><h4>Enter tags seperated by ','. Only alpahbtes and numbers are allowed.</h4></p>
		<div class="pin-table-head-row">
			<div class="pin-table-cell">
				Tag
			</div>
			<div class="pin-table-cell">
				<input name="followtag" id="followtag" type="text" class="pin-input-box">
				<span id = "uname_status"> </span>
			</div>
		</div>
		<input type="submit" id="add-stream" value="Add tag to Stream" name="addstreamtag" class="pin-btn-long">
	</div>
	<div id="pin-stream-board">
		<div class="pin-table-head-row">
			<div class="stream-checkbox-block">
				<?php  
				if(!isset($o_bid_list) || !isset($o_bid_list)){
					echo"No Board to select";
				}
				else{
					foreach($o_bid_list as $key => $val)
					{
							if($key!=0){
								echo '<div style="width:100px; display:inline-block;" class="checkbox-block">';
								echo '<img width=100 height=100 src="data:image/jpeg;base64,' .base64_encode( $val['boardimage'] ). '" />';
								echo '<input type="checkbox" name="followstreamboard[]" value="'.$key .'">';
								echo '<p>'.$val['bname'].'</p>';
								echo '<p>'.$val['description'].'</p>';
								echo '</div>';
							}
					}
				}
				?>
			</div>
		</div>
		<input type="submit" id="add-stream" value="Add boards to Stream" name="addstreamboard" class="pin-btn-long">
	</div>
	<?php 
		}
		else{
			echo "<p><h4>Please create a follow stream.</h4></p>";
		}
	 ?>
</div>

</center>
</form>
