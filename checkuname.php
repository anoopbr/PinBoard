<?php
    $user='root';
    $password='';
    $database='pinterest';
    $uname=$_POST['uname'];
    $con=mysqli_connect('localhost',$user,$password,$database);
    if(!$con) 
        {
            die("Unable to select database");
        }
    $query=$con->stmt_init();
    $query->prepare("SELECT count(*) FROM profile where uname=?") or die (Header ("Location : error.php"));
    $query->bind_param("s",$uname);
    $query->execute();
    $query->bind_result($user_count);
    $query->fetch();
    //$query->close();
    //echo "fetching username";
    //if yes then raise the flag
    if($user_count!=0){
        echo '<error>Sorry, the username '.$uname.' is taken.</error>';
    }
    else{
        echo '<noerror><img src="images/check.png" class="check_img">Username is avialable!</noerror>';
    }
    $query->close();
    mysqli_close($con);
?>