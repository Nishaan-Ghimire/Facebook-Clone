<?php
require '_dbconnect.php';
$q = $_REQUEST["q"];
$like = $_GET['like']; // no of likes
$username = $_GET['user']; // a person who is liking the post
$post_id = $_GET['post_id']; // unique name of post 
$user_id = $_GET['user_id']; // user id of person who is liking the post
$post_owner = $_GET['postowner']; // who has posted the post


//now for making sure one person only likes the same post we have to verify username and post_id(same post of same person)
$sql_check = "SELECT * FROM `likes`.`$post_owner` WHERE `liker_username`='$username' && `post_id`='$post_id'";
$sql_check_result = mysqli_query($conn, $sql_check);

while($sql_check_get_results=mysqli_fetch_assoc($sql_check_result)){

$current_user = $sql_check_get_results['liker_username'];
$current_post = $sql_check_get_results['post_id'];
 echo "<h1 style='color:white;'>" .$current_post." </h1>";
 echo "<h1 style='color:white;'>" .$post_id." </h1>";
 echo "<h1 style='color:white;'>" .$current_user." </h1>";
 echo "<h1 style='color:white;'>" .$username." </h1>";

 
if($current_user != $username && $post_id != $current_post){
    $like = $like + 1;
    $sql="INSERT INTO `likes`.`$post_owner` (`like_id`, `post_id`, `liker_username`, `liker_id`, `timestamp`) VALUES (NULL, '$post_id', '$username', '$user_id', current_timestamp())";
    
    
    $result = mysqli_query($conn,$sql);
        
    
    $sql_user="UPDATE `users`.`$post_owner` SET `user_like_num` = '$like' WHERE `users`.`$post_owner`.`post_id` = '$post_id'";
    // $sql_user = "SELECT `user_like_num` FROM `users`.`$post_owner` WHERE `post_id`='$post_id'";
    $result_user = mysqli_query($conn,$sql_user); 
 
}



}





 echo "Like ".$like;


?>