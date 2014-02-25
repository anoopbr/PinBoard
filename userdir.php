<?php
//use this to upload pics when the user logs in for the first time.
	
	if(!is_dir("./images/$current_user")){
		if(!mkdir("./images/$current_user")){
			echo "dir not made";
		}
	}
	
?>
