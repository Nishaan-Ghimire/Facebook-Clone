<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    
session_unset();
session_destroy();
  header("Location: login.php");
  }else{
    include '_dbconnect.php';
      $caption = $_POST['caption'];
      $usr_id = $_SESSION['user_id'];
      $username = $_SESSION['username'];
      $target_dir = "post_img/";
      $target_file = $target_dir . basename($_FILES["postfileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      echo $target_file."<br>";
     
      if (move_uploaded_file($_FILES["postfileToUpload"]["tmp_name"], $target_file)) {
          
          echo "The file ".basename( $_FILES["postfileToUpload"]["name"]). " has been uploaded.";
$postsql = "INSERT INTO `users`.`$username` (`user_id`, `user_caption`, `user_post`, `user_like_num`, `timestamp`) VALUES ('$usr_id', '$caption', '$target_file', '20', current_timestamp())";
$runsql = mysqli_query($conn, $postsql);

if($runsql){

    echo "ok";
  
    header("Location: /messanger/profile.php?user=$username");    
}else{

    echo $error; 
   
    // header("Location: /messanger/profile.php?$username&&post=fail");
}



        $_SESSION['postimgpath'] = $target_file;
       
        header("Location: /messanger/profile.php?user=$username");
        exit();
        } 
  }



  ?>