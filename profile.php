<?php 
$imgpath =""; //considering image path to be empty to overcome warning
session_start();
$user_id = $_SESSION['user_id'];


require 'partials/_dbconnect.php';
require 'partials/_nav.php';

// require 'partials/_dbconnect_friends.php';
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
   
   }

//for profile pic


 if(!isset($_SESSION['profile']) || $_SESSION['profile'] == false){

  




    
   
    
    $sql_get_pic = "SELECT `profilepic` FROM `messanger`.`user_detail` WHERE `username` = '$usr_name'";
    $run_sql = mysqli_query($conn,$sql_get_pic);

    
    $get_profile_pic = mysqli_fetch_assoc($run_sql);
    
  
    if($get_profile_pic['profilepic'] != ""){
     
  $imgpath = $get_profile_pic['profilepic'];
  
  }else{
  $imgpath = "profileimg/userdefault.png";
  }

        }else{
          $imgpath = $_SESSION['imgpath'];
 
   

        $sql = "UPDATE `messanger`.`user_detail` SET `profilepic` = '$imgpath' WHERE `messanger`.`user_detail`.`username` = $usr_name";
        $update_profile_pic = mysqli_query($conn,$sql);
        
     
       }









//for cover pic

if(!isset($_SESSION['profilecover']) || $_SESSION['profilecover'] == false){
    
  $sql_get_pic = "SELECT `coverpic` FROM `messanger`.`user_detail` WHERE `username` = '$usr_name'";
  $run_sql = mysqli_query($conn,$sql_get_pic);
  
  $get_friends_pic = mysqli_fetch_assoc($run_sql);

  if($get_friends_pic['coverpic'] != ""){
$coverimgpath = $get_friends_pic['coverpic'];
}else{
$coverimgpath = "coverimg/cover.png";
}
     }else{
        $coverimgpath = $_SESSION['coverimgpath'];
 
      $sql = "UPDATE `messanger`.`user_detail` SET `coverpic` = '$coverimgpath' WHERE `messanger`.`user_detail`.`username` = $usr_name";
      $update_friends_pic = mysqli_query($conn,$sql);
      
 

     }


$sql_get_friend ="SELECT `first_name`,`last_name` FROM `messanger`.`user_detail` WHERE `username`= '$usr_name'";
$sql_get_friend_run = mysqli_query($conn, $sql_get_friend);
$sql_get_friend_result = mysqli_fetch_assoc($sql_get_friend_run);
    


?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="partials/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Profile -
        <?php echo $usr_name;?>
    </title>
    <style>
        body {
            background-color: #1c1e21;
        }
        
        .profile_container {
            background-color: #282828;
        }
        
        .profile {
            background-image: url("partials/<?php echo $coverimgpath;?>");
            background-repeat: no-repeat;
            background-size: cover;
            display: block;
            margin: auto;
            width: 70%;
            height: 40%;
        }
        
        .profile_pic {
            display: block;
            width: 100px;
            margin: auto;
        }
        
        .profile_pic img {
            width: 200px;
            z-index: 1;
            border-radius: 12px;
        }
        
        h3 {
            text-align: center;
        }
        
        ._intro {
            display: block;
            text-align: center;
        }
        
        .friends .friend {
            display: inline;
        }
        
        .friends .friend img {
            width: 50px;
        }
        
        label {
            margin-top: 15px;
        }
        
        .nav-link {
            font-family: var(--font-family-segoe)!important;
            border-bottom: 5px solid transparent;
            background-color: #1c1e21;
            color: #b0b3b8;
            font-weight: 600;
            font-size: .9375rem;
        }
        
        .nav-link:active {
            border-bottom: 5px solid blue;
        }
        
        .nav-link:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>




    <div class="profile-container mt-0">
        <div class="profile_container">

            <!-- for uploading profile pic -->
            <div class="profile">

                <div class="profile_pic"><img src="<?php echo "partials/".$imgpath;?>"></div>


            </div>

        </div>

    </div>
    <div class="container">
        <h3 class="text-light">
            <?php echo $sql_get_friend_result['first_name'].' '. $sql_get_friend_result['last_name'];?> </h3>
    </div>




    <?php if($real_user == true){
echo '  <!-- Button trigger cover modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#covermodal">
    Upload Cover pic
</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#profile">
    Upload Profile pic
</button>
<img class="rounded-circle" style="margin-left: 35px;" src="partials/'.$imgpath.'" height="60px"> 
  <!-- Button trigger modal for post -->
  <button style="margin-left: 35px; border-radius: 20px; width: 400px; opacity: 0.8;" type="button" class="btn btn-dark" data-toggle="modal" data-target="#postmodal">
           What';
           echo "'s";
           echo ' on your Mind? 
        </button>';


}else{


            //getting name of friend to whom request is send
            $friend = $_GET['user'];

            //getting the name of user  who has send request
            $user_name_sql = "SELECT * FROM `messanger`.`user_detail` WHERE `user_id` = '$user_id'";
            $user_name_run = mysqli_query($conn,$user_name_sql);
            $user_name_take = mysqli_fetch_assoc($user_name_run);
            $username = $user_name_take['username'];

            //checking status if request on table of friend to who request is send
            $friend_req_status_sql = "SELECT * FROM `friends`.`$friend` WHERE `friend_username` = '$username'";
            $friend_req_status_run = mysqli_query($conn,$friend_req_status_sql);
            $req_status = mysqli_fetch_assoc($friend_req_status_run);

            

        

            $friend_req_confi_sql = "SELECT * FROM `friends`.`$username` WHERE `friend_username` = '$friend'";
            
            if($friend_req_confi_run = mysqli_query($conn,$friend_req_confi_sql))
            {
                $req_confi_status = mysqli_fetch_assoc($friend_req_confi_run);
                        echo '<div class="container">';
                    if($req_status['request_status'] == 'true' && $req_confi_status['request_status'] == 'true'){
                        echo ' 
                        <button type="submit" id="'.$username.'" class = "btn btn--light txt-dark friend disabled">Friend</button>

                        <input type="hidden" id="username" value="'.$username.'">';
                    }elseif($req_status['request_status'] == 'false') {
                        echo ' <button type="submit" id="'.$username.'" class = "btn btn-light txt-dark friend disabled">Request send</button>
                        <input type="hidden" id="username" value="'.$username.'">';
                    }
                    elseif ($req_confi_status['request_status'] == 'false' && $req_status['request_status'] == '') {
                        echo ' <button type="submit" id="'.$username.'" class = "btn btn-light txt-dark friend">Accept Request</button>
                        <input type="hidden" id="username" value="'.$username.'">';
                    }
                    elseif($req_confi_status['request_status'] == 'true' && $req_status['request_status'] == 'true'){
                        echo ' <button type="submit" id="'.$username.'" class = "btn btn-light txt-dark friend">Add Friend</button>
                        <input type="hidden" id="username" value="'.$username.'">';
                    }

                    else{
                        $rc = $req_confi_status['request_status'];
                        $r =  $req_status['request_status'];
                        echo ' <button type="submit" id="'.$username.'" class = "btn btn-primary friend">Add Friend</button>
                        <input type="hidden" id="username" value="'.$username.$r.$rc.'">';

                    }

                    echo '</div>';
             }
         else{
            echo ' <button type="submit" id="'.$username.'" class = "btn btn-light txt-dark friend">Add Friend</button>
            <input type="hidden" id="username" value="'.$username.'">';
             }


            }
?>









    <!-- Cover Modal -->
    <div class="modal fade" id="covermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <!-- for caption -->
                <form action="partials/_coverpic.php" method="post" enctype="multipart/form-data">


                    <p><input type="file" accept="image/*" name="coverfileToUpload" id="file" onchange="loadFile(event)" style="display: none;"></p>
                    <label for="file" style="cursor: pointer;" type="button" class="btn btn-primary ">select
                        image</label>
                    <div class="modal-body">
                        <div class="card" style="width: 18rem;">

                            <div class="card-body">


                                <p><img id="coverimg" width="200" /></p>

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

    </div>




    <!-- for profile pic -->
    <!-- profile Modal -->
    <div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">


                <form action="partials/_profilepic.php" method="post" enctype="multipart/form-data">


                    <p><input type="file" accept="image/*" name="fileToUpload" id="profileinput" onchange="loadFile(event)" style="display: none;"></p>
                    <label for="profileinput" style="cursor: pointer;" type="button" class="btn btn-primary ">select
                        image</label>
                    <div class="modal-body">
                        <div class="card" style="width: 18rem;">

                            <div class="card-body">


                                <p><img id="profileimg" width="200" /></p>

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

    </div>







    <div class="bdy-container">


        <!-- for introduction using collapse -->


        <!-- for posts -->
        <div class="container">





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

    </div>



    <!-- for tabs -->

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pills-home-tab" href="profile.php?user=<?php echo $usr_name;?>" role="tab" aria-controls="pills-home" aria-selected="true">Timeline</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link " id="pills-profile-tab" href="about.php?user=<?php echo $usr_name;?>" role="tab" aria-controls="pills-profile" aria-selected="false">About</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="pills-contact-tab" href="friend.php?user=<?php echo $usr_name;?>" role="tab" aria-controls="pills-contact" aria-selected="false">Friends</a>
        </li>
    </ul>



    <div class="container">
        <?php
            
            $sql_get_post = "SELECT * FROM `users`.`$usr_name`";
            $run_post_sql = mysqli_query($conn,$sql_get_post);
            $no_of_post = mysqli_num_rows($run_post_sql);
            if($no_of_post > 0)
            {
                    while($get_post = mysqli_fetch_assoc($run_post_sql)){
                    $postpath = $get_post['user_post'];
                    $caption = $get_post['user_caption'];
                    $date = $get_post['timestamp'];
                    $like = $get_post['user_like_num'];
                    echo '<div class="container" style="color: #1c1e21;
                    background-color: #1C1C1C;
                    direction: ltr;
                    line-height: 1.34; margin-top: 18px; ">';
                    echo '<h4 class="text-light" style="text-align: left; margin-bottom: -12px; "><img class="rounded-circle" src="partials/'.$imgpath.'" height="60px">'.'  '.$usr_name.'</h4><label class="text-light">'.$date.'</label>';
                    echo '<br>';
                    echo '<h2 class="text-light">'.$caption.'</h2>';
                    echo '<img class="likers" height="400px" src="partials/'.$postpath.'">';
                    echo '<h4 class="text-light" style="margin-top: 15px;"><button class="btn btn-primary" onclick="likepost()">Like<span class="likeit"> '.$like.'</span></button></h4>';
                    }
            }
        else{
            echo '<h3 class="text-muted"> No Post Available </h3>';
            }
            ?>

    </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="partials/js/jquery.min.js"></script>
    <script src="partials/js/popper.min.js"></script>
    <script src="partials/js/bootstrap.min.js"></script>
    <script src="partials/js/profile.js"></script>
    <script>
        var id;
        var rq_btn;
        btn = document.getElementsByClassName('friend');
        Array.from(btn).forEach((element) => 
                    {
                                element.addEventListener("click", (e) => 
                                {
                                    console.log(e.target);
                                    console.log(e.target.id);
                                    id = e.target.id;
                                    rq_btn = e.target;

                                    if (rq_btn.innerText == 'Add Friend' || rq_btn.innerText == 'Accept Request') 
                                    {

                                        request();
                                    }

                                })
                    })

     

        function likepost() 
        {

            let likeno = document.getElementById('likeit');
            let likes = likeno.innerHTML;
            alert(likes);
            const xhreq = new XMLHttpRequest();
            xhreq.open('GET', "partials/_like.php?like=" + likes + "&user=<?php echo $user_id;?>&q=", true);

            xhreq.onprogress = () => 
            {

                likeno.innerHTML = " adding.....";
            }

            xhreq.onload = () => 
            {
                if (xhreq.status === 200) 
                {

                    Response = xhreq.responseText;
                    likeno.innerHTML = Response;
                    likeno.setAttribute("class", "btn btn-primary disabled");



                }
            }
            xhreq.send();



        }

        function request() 
        {

            const xhreq = new XMLHttpRequest();
            xhreq.open('GET', "partials/_friend_request.php?receiver=<?php echo $_GET['user'];?>&sender=" + id + "&q=" + rq_btn.innerText, true);
            console.log("partials/_friend_request.php?receiver=<?php echo $_GET['user'];?>&sender=" + id);
            xhreq.onprogress = () => 
            {

                rq_btn.innerHTML = "sending.....";
            }
            xhreq.onload = () => {
                if (xhreq.status === 200) {
                    // xmlResponse = xhreq.responseXML;
                    Response = xhreq.responseText;

                    rq_btn.innerHTML = Response;
                    rq_btn.setAttribute("class", "btn btn-primary disabled");



                } else {
                    document.getElementById('answer').innerHTML = "sorry some error occured";
                }
            }
            xhreq.send();
        }
function showw(){
document.getElementById('hidemodal').style.visibility = "visible";

}
    </script>
</body>

</html>