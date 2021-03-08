<?php
session_start();
require 'partials/_dbconnect.php';
require 'partials/_nav.php';



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

        <title>Friends</title>
        <style>
        
        body{

            background-color: #282828;

        }
        
        
        </style>
    </head>

    <body>
        
           
            <?php

$sugg_friend_sql = "SELECT * FROM `messanger`.`user_detail`";
$sugg_friend_sql_result = mysqli_query($conn, $sugg_friend_sql);
$user = $_GET['user'];

// loop for displaying friends form database messanger
while($friends= mysqli_fetch_assoc($sugg_friend_sql_result)){
  $username = $friends['username'];
//   for sending request
// SELECT * FROM `friends`.`Hari` WHERE `friend_username` = 'nishan'
  $friend_req_status_sql = "SELECT * FROM `friends`.`$username` WHERE `friend_username` = '$user'";
  $friend_req_status_run = mysqli_query($conn,$friend_req_status_sql);
  $req_status = mysqli_fetch_assoc($friend_req_status_run);

  //for request confirmation
  $friend_req_confi_sql = "SELECT * FROM `friends`.`$user` WHERE `friend_username` = '$username'";
  $friend_req_confi_run = mysqli_query($conn,$friend_req_confi_sql);
  $req_confi = mysqli_fetch_assoc($friend_req_confi_run);
  $request_received = $req_confi['request_status'];
  
  

$request  = $req_status['request_status'];
  $profile_img_path = $friends['profilepic'];
  
 if($user != $username){
//    echo $user.' is user<br>';  
//    echo $username.' is username<br>';
   
  

   
if($request == 'true' && $request_received= "true"){
    echo '<div class="container">';
    echo '<h3>Friends</h3>';
    echo '<div class="jumbotron"  style="color: #1c1e21;
    background-color: #1C1C1C;
    direction: ltr;
    line-height: 1.34; margin-top: 18px; ">


    <h4> <img class="rounded-circle" src="partials/'.$profile_img_path.'" height="80px"><a href="profile.php?user='.$username.'">'.'  '.$username.'</a><div class="col-md-12 text-right">
    <span id="reponse">';
    echo ' <button type="submit" id="'.$username.'" class="btn btn-primary friend disabled">Friend</button></div></div>';
}


elseif($request_received == 'false'){
    echo '<div class="container">';
    echo '<h3>Friend Request</h3>';
    echo '<div class="jumbotron"  style="color: #1c1e21;
    background-color: #1C1C1C;
    direction: ltr;
    line-height: 1.34; margin-top: 18px; ">
    <h4> <img class="rounded-circle" src="partials/'.$profile_img_path.'" height="80px"><a href="profile.php?user='.$username.'">'.'  '.$username.'</a><div class="col-md-12 text-right">
    <span id="reponse">';
    echo ' <button type="submit" id="'.$username.'" class = "btn btn-secondary friend" onclick="this.disabled=true;">Accept Request</button>
    <button type="button" class="btn btn-warning">Cancel</button></div></div>';
}

elseif($request == 'false' && $request_received == ''){
    echo '<div class="container">';
    echo '<h3>Friend suggestions</h3>';
    echo '<div class="jumbotron"  style="color: #1c1e21;
    background-color: #1C1C1C;
    direction: ltr;
    line-height: 1.34; margin-top: 18px; ">
    <h4> <img class="rounded-circle" src="partials/'.$profile_img_path.'" height="80px"><a href="profile.php?user='.$username.'">'.'  '.$username.'</a><div class="col-md-12 text-right">
    <span id="reponse">';
    echo ' <button type="submit" id="'.$username.'" class = "btn btn-primary friend disabled">Request Send</button>
    <button type="button" class="btn btn-warning">Cancel</button></div></div>';
}

else{
    echo '<div class="container">';
    echo '<h3>Friend suggestions</h3>';
    echo '<div class="jumbotron"  style="color: #1c1e21;
    background-color: #1C1C1C;
    direction: ltr;
    line-height: 1.34; margin-top: 18px; ">
<h4> <img class="rounded-circle" src="partials/'.$profile_img_path.'" height="80px"><a href="profile.php?user='.$username.'">'.'  '.$username.'</a><div class="col-md-12 text-right">
    <span id="reponse">';
 echo ' <button type="submit" id="'.$username.'" class="btn btn-primary friend" onclick="this.disabled=true;">Add Friend</button>
 <button type="button" class="btn btn-warning">Cancel</button></div></div>';
}
echo '
</span>
<input type="hidden" id="username" value="'.$username.'">

</div></h4>


</div>';
 }
  }
  
?>
                <!-- <form action="partials/_friend_request.php" method="get">
<input type="hidden" value="'.$_GET['user'].'" name="sender">
<input type="hidden" value="'.$username.'" name="receiver"> -->

        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="partials/js/jquery.min.js"></script>
        <script src="partials/js/popper.min.js"></script>
        <script src="partials/js/bootstrap.min.js"></script>
        <script src="partials/js/friend.js"></script>
        <script>
        var id;
var rq_btn;
btn = document.getElementsByClassName('friend');
Array.from(btn).forEach((element) => {
    element.addEventListener("click", (e) => {
        console.log(e.target);
        console.log(e.target.id);
        id = e.target.id;
        rq_btn = e.target;

        if (rq_btn.innerText == 'Add Friend' || rq_btn.innerText == 'Accept Request') {

            request();
        }

    })
})


function request() {
   


    console.log("inside" + id);
    const xhreq = new XMLHttpRequest();
    xhreq.open('GET', "partials/_friend_request.php?sender=<?php echo $_GET['user'];?>&receiver=" + id + "&q=" + rq_btn.innerText, true);
    console.log("partials/_friend_request.php?sender=<?php echo $_GET['user'];?>&receiver=" + id);
    xhreq.onprogress = () => {

        rq_btn.innerHTML = "sending.....";
    }
    xhreq.onload = () => {
        if (xhreq.status === 200) {
            // xmlResponse = xhreq.responseXML;
            Response = xhreq.responseText;
            // xmlDocumentElement = xmlResponse.documentElement;
            // // get the text message, which is in the first child of
            // // the the document element
            // Message = xmlDocumentElement.firstChild.data;

            // display the data received from the server

            rq_btn.innerHTML = Response;
            rq_btn.setAttribute("class", "btn btn-primary disabled");



        } else {
            document.getElementById('answer').innerHTML = "sorry some error occured";
        }
    }
    xhreq.send();
}
        
        
        
        </script>
    </body>

    </html>