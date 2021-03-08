<?php
session_start();
echo "Hi";
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    
session_unset();
session_destroy();
  header("Location: login.php");
  }
  $username = $_SESSION['username'];
$target_dir = "coverimg/";
$target_file = $target_dir . basename($_FILES["coverfileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
echo $target_file."<br>";
if (move_uploaded_file($_FILES["coverfileToUpload"]["tmp_name"], $target_file)) {
    
    echo "The file ".basename( $_FILES["coverfileToUpload"]["name"]). " has been uploaded.";
  $_SESSION['coverimgpath'] = $target_file;
  $_SESSION['profilecover'] = true;
  
  header("Location: /messanger/profile.php?user=$username");
  exit();

  } 
?>
 