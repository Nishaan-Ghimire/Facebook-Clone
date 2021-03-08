<?php
session_start();
require '_dbconnect.php';


date_default_timezone_set("Asia/Kathmandu");
$date = date("r");
$datefor = date("F, j Y"); 
$time = date("h:i:s a");

$timestamp = $datefor . ' ' . $time;
$sender = $_GET['sender']; //
$receiver = $_GET['receiver']; //
$q = $_REQUEST["q"]; 

//  exit;

if($q == "Accept Request"){
    $sql_friend ="SELECT `user_id` FROM `messanger`.`user_detail` WHERE `username`= '$receiver'";
$sql_friend_run = mysqli_query($conn, $sql_friend);
$sql_friend_result = mysqli_fetch_assoc($sql_friend_run);
    $user_id = $sql_friend_result['user_id'];


    $sql_request = "UPDATE `friends`.`$sender` SET `request_status` = 'true' WHERE `friend_username`='$receiver'";
    $sql_request_run = mysqli_query($conn, $sql_request);
    
    $check_sql = "SELECT * FROM `friends`.`$receiver` WHERE `friend_username`= '$sender'";
    $check_sql_run = mysqli_query($conn,$check_sql);
    $check = mysqli_num_rows($check_sql_run);
if($check == 0){
    

    $sql_request = "INSERT INTO `friends`.`$receiver`(`friend_id`,`friend_username`,`request_status`,`accepted_timestamp`) VALUES ('$user_id','$sender','true','$timestamp')";
    $sql_request_run = mysqli_query($conn, $sql_request);
}
    echo "You are friends now";
}
else{
    
$sql_friend ="SELECT `user_id` FROM `messanger`.`user_detail` WHERE `username`= '$sender'";
$sql_friend_run = mysqli_query($conn, $sql_friend);
$sql_friend_result = mysqli_fetch_assoc($sql_friend_run);
    $user_id = $sql_friend_result['user_id'];


    $check_sql = "SELECT * FROM `friends`.`$receiver` WHERE `friend_username`= '$sender'";
    $check_sql_run = mysqli_query($conn,$check_sql);
    $check = mysqli_num_rows($check_sql_run);
    if($check == 0){
    
    
$sql_request = "INSERT INTO `friends`.`$receiver`(`friend_id`,`friend_username`,`request_status`) VALUES ('$user_id','$sender','false')";
$sql_request_run = mysqli_query($conn, $sql_request);

    }

echo "Request send";
exit;

}

// close the <response> element

?>