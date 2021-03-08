

<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    
session_unset();
session_destroy();
  header("Location: login.php");
  }
  $username = $_SESSION['username'];
$target_dir = "profileimg/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
echo $target_file."<br>";
echo basename($_FILES["fileToUpload"]["name"]). "is the file";
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    
    echo "The file ".basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
  $_SESSION['imgpath'] = $target_file;
  $_SESSION['profile'] = true;
  echo $target_file;
  header("Location: /messanger/profile.php?user=$username");
  exit();

  } else{
    echo "cannot be uploaded";
  }
?>
 