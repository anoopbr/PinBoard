<?php
    $user='root';
    $password='';
    $database='pinterest';
    $email=$_POST['email'];
    $con=mysqli_connect('localhost',$user,$password,$database);
    if(!$con) 
        {
            die("Unable to select database");
        }
    $query=$con->stmt_init();
    $query->prepare("SELECT count(*) FROM profile where email=?") or die (Header ("Location : error.php"));
    $query->bind_param("s",$email);
    $query->execute();
    $query->bind_result($user_count);
    $query->fetch();
    //$query->close();
    //echo "fetching username";
    //if yes then raise the flag
    if($user_count!=0){
        echo '<error>Sorry, the email '.$email.' is already registerd.</error>';
    }
    $query->close();
    mysqli_close($con);
?>