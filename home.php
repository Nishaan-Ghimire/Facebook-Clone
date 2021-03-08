<?php 
session_start();
$user_id = $_SESSION['user_id'];
require 'partials/_dbconnect.php';
require 'partials/_nav.php';
$real_user = false;


// checking user registration status
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
  
  session_unset();
  session_destroy();
  header("Location: login.php");
}

$usr_name = $_GET['user'];
$user_check_sql = "SELECT `username` FROM `messanger`.`user_detail` WHERE `user_id` = '$user_id'";
$user_check_sql_run = mysqli_query($conn,$user_check_sql);
$user_check_sql_result = mysqli_fetch_assoc($user_check_sql_run);

if($usr_name == $user_check_sql_result['username']){
$real_user = true;
}else{
  $real_user = false;
}




?>

<!DOCTYPE html>
<html>
<title>News Feed</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/like_button.js"></script>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="partials/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style>
    html,
    body,
    h1,
    h2,
    h3,
    h4,
    h5 {
        font-family: "Open Sans", sans-serif
    }
    
    body {
        background-color: #282828;
    }
</style>

<body class="w3-theme-l5">

    <!-- Middle Column -->
    <div class="container mt-6 ml-6">
        <div class="w3-col m7">

            <?php if($real_user == true){
echo '<img class="rounded-circle" style="margin-left: 35px;" src="partials/'.$user_img['profilepic'].'" height="60px"> 
  <!-- Button trigger modal for post -->
  <button style="margin-left: 35px; border-radius: 20px; width: 400px; opacity: 0.8;" type="button" class="btn btn-dark" data-toggle="modal" data-target="#postmodal">
           What';
           echo "'s";
           echo ' on your Mind? 
        </button>';


}
?>


            <!-- modal starts -->

            <!-- Modal -->
            <div class="modal fade" id="postmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="background-color: #1c1e21 !important;">
                        <div class="modal-header">
                            <!-- for caption -->
                            <form action="partials/_post.php" method="post" enctype="multipart/form-data">
                                <div class="input-group mb-3">
                                    <input type="text" style="border-radius: 20px; background-color: #343a40; width: 80%; color: white;" name="caption" class="form-control" placeholder="Write your caption..." aria-label="caption" aria-describedby="basic-addon2">
                                </div>
                        </div>
                        <p><input type="file" accept="image/*" name="postfileToUpload" id="post" onchange="loadFile(event)" style="display: none;"></p>
                        <label for="post" style="cursor: pointer;" type="button" class="btn btn-primary ">select
                            image</label>
                        <div class="modal-body">
                            <div class="card" id="hidemodal" style="width: 18rem; visibility: hidden;">

                                <div class="card-body">
                                    <p><img id="output" width="200" onload="showw()" /></p>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" value="POST" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>


            </form>
        </div>

        <!-- modal ends -->


        <!-- posts -->


        <div class="container">
            <?php


$sql_get_friends = "SELECT * FROM `friends`.`$usr_name`";
$run_friends_sql = mysqli_query($conn,$sql_get_friends);
$no_of_friends = mysqli_num_rows($run_friends_sql);

if($no_of_friends > 0)
{
    while($get_friends = mysqli_fetch_assoc($run_friends_sql))
    {
        $is_friend = $get_friends['request_status'];
        if($is_friend == "true")
        {
            $friend_username = $get_friends['friend_username'];

            $friends_detail_sql = "SELECT * FROM `messanger`.`user_detail` WHERE `username`='$friend_username'";
            $friends_detail_run = mysqli_query($conn, $friends_detail_sql);
            $friends_detail = mysqli_fetch_assoc($friends_detail_run);
            $imgpath = $friends_detail['profilepic'];


            $sql_get_post = "SELECT * FROM `users`.`$friend_username`";
            $run_post_sql = mysqli_query($conn,$sql_get_post);
            $no_of_post = mysqli_num_rows($run_post_sql);
            if($no_of_post > 0)
            {
                while($get_post = mysqli_fetch_assoc($run_post_sql))
                {
                    $postpath = $get_post['user_post'];
                    $post_id = $get_post['post_id'];
                    $date = $get_post["timestamp"];
                    $like = $get_post["user_like_num"];
                   
                    echo '<div class="container" style="color: #1c1e21;
                    background-color: #1C1C1C;
                    direction: ltr;
                    line-height: 1.34; margin-top: 18px; ">';
                    echo '<h4 class="text-light" style="text-align: left; margin-bottom: -12px; "><img class="rounded-circle" src="partials/'.$imgpath.'" height="60px">'.'  '.$friend_username.'</h4><label class="text-light mt-5">'.$date.'</label>';
                    echo '<br>';
                    echo '<h2 class="text-light">'.$get_post["user_caption"].'</h2>';
                    echo '<img class="likers" height="400px" src="partials/'.$postpath.'">';
                    //  echo "<h1 style='color: white;'>".$post_id."</h1>";
                    // exit();
                    echo '<h4 class="text-light" style="margin-top: 15px;"><button id="'.$friend_username.'" name="'.$post_id.'" class="btn btn-primary like_btn"><input type="hidden" id="'.$friend_username.'_like" value="'.$like.'"><input type="hidden" id="'.$friend_username.'_post" value="'.$post_id.'" > Like '.$like.'</button></h4>';  
                    // echo "<h1 style='color: white;'>".$post_id."</h1>";
                 }
            }
        }
    }
}
            ?>


</body>
<script>
    var like_id;
    var like_rq_btn;
    var post, post_id;
    var check;
    like_btn = document.getElementsByClassName('like_btn');
    Array.from(like_btn).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log(e.target);
            console.log(e.target.id);
            like_id = e.target.id;
            like_rq_btn = e.target;
            post_id = e.target.name;
            console.log(check);
         

         
            likepost();
        })


    })

    function likepost() {

        console.log(like_id);
        // let post= document.getElementById(like_id+'_post');



        let likeno = document.getElementById(like_id + "_like");
        let likes = likeno.value;
        console.log(likes);

        const xhreq = new XMLHttpRequest();
        xhreq.open('GET', "partials/_like.php?like=" + likes + "&user=<?php echo $usr_name;?>&postowner=" + like_id + "&post_id=" + post_id + "&user_id=<?php echo $user_id;?>&q=", true);

        xhreq.onprogress = () => {

            like_rq_btn.innerHTML = " wait.....";
        }

        xhreq.onload = () => {
            if (xhreq.status === 200) {

                Response = xhreq.responseText;
                like_rq_btn.innerHTML = Response;
                like_rq_btn.setAttribute("class", "btn btn-danger disabled");



            }
        }
        xhreq.send();
    }
</script>

</html>