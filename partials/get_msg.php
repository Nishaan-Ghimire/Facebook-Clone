<?php
session_start();
include "_dbconnect.php";
$to = $_POST['to'];
$msg_no = $_POST['msg_no'];
$my_chats = $_SESSION['username'];

$msg = 0;

$sql = "SELECT `message`, `time`, `sender` FROM `chats`.`$my_chats` WHERE `sender` = '$to'";
$res = "";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result) > $msg_no){
  
    while ($row = mysqli_fetch_assoc($result)) {

      

if ($row['sender'] != $_SESSION['username']) {
   
$user = $row["sender"];

    $sql_get_pic = "SELECT `profilepic` FROM `messanger`.`user_detail` WHERE `username` = '$user'";
    $run_sql = mysqli_query($conn,$sql_get_pic);
    $get_profile_pic = mysqli_fetch_assoc($run_sql);
       
       $res = '<div class="d-flex justify-content-end mb-4">
     
       <div class="msg_cotainer_send">';

       $res = $res .$row['message'];
       $res = $res . '</div>
       <div class="img_cont_msg">
       <img src="partials/'.$get_profile_pic["profilepic"].'" class="rounded-circle user_img_msg">';
       
      $res = $res .'<strong>'. $row['sender'].'</strong>
    </div>  </div><p style="text-align: right; margin-top: 10px;">'. $row["time"].'</p>';

                 }else{
      
    $user = $_SESSION['username'];
    $sql_get_pic = "SELECT `profilepic` FROM `messanger`.`user_detail` WHERE `username` = '$user'";
    $run_sql = mysqli_query($conn,$sql_get_pic);
    $get_profile_pic = mysqli_fetch_assoc($run_sql);
                    $res = '<div class="d-flex justify-content-start mb-4">
                    <div class="img_cont_msg">
                    <img src="partials/'.$get_profile_pic["profilepic"].'" class="rounded-circle user_img_msg">';
                    $res = $res .'<strong>'. $row['sender'].'</strong>
                   </div> </div>';
                    $res = $res .'<strong>'. $row['sender'].'</strong>
                    <div class="msg_cotainer">';
                    $res = $res .$row['message'];
                    $res = $res . '<p style="text-align: left; margin-top: 10px;">'. $row["time"].'</p>
                    </div>
                   ';





                 }
        }
    } 

echo $res;


?>