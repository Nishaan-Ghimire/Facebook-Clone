<?php
  //connect to the database
  include "_dbconnect.php";


header('Content-Type: text/json');
$data = json_decode(file_get_contents("php://input"));

$msg = $data->message;
$to = $data->to;
$from = $data->from;
echo $data;
$sql = "INSERT INTO `chats`.`$to` (`sender`, `message`) VALUES ('$from', '$msg', current_timestamp())";
$result = mysqli_query($conn,$sql);


?>