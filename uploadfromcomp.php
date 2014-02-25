<?php 
$user='root';
$password='';
$database='pinterest';
$con=mysqli_connect('localhost',$user,$password,$database);
if(!$con) 
    {
        die("Unable to select database");
    }
$query=$con->stmt_init();


if (isset($_POST['upload']))
    {
    $boardid = $_POST['compboards'];
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
    $filename = './userdir/'.$current_user.'/'. $name;
    $img= file_get_contents($_FILES['image']['tmp_name']);
    file_put_contents($filename, $img);
    $query = "INSERT INTO picture (picid,picurl, image) VALUES ('$pid','{$filename}', '{$image}')";
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
    if($_POST['comptags']!=""||$_POST['comptags']!=null){
        $tags=$_POST['comptags'];
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
      Header("Location: fetchimage.php?pinid=$pin&boardid=$boardid");
    }
    mysqli_close($con);
 ?>