<?php
session_start();
$user_id = $_SESSION['user_id'];
require 'partials/_dbconnect.php';
require 'partials/_nav.php';





// checking user registration status
 if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
  
        session_unset();
        session_destroy();
        header("Location: login.php");
   }


?>

<!DOCTYPE html>
<html>
	<head>
    <title>Chat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" href="partials/css/messanger.css">
<link rel="stylesheet" href="partials/css/bootstrap.min.css">

	</head>
	
	<body>
		<div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
			<!-- contacts -->
				<div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
					<div class="card-header">
						<div class="input-group">
							<input type="text" placeholder="Search..." name="" class="form-control search">
							<div class="input-group-prepend">
								<span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
							</div>
						</div>
					</div>
					<div class="card-body contacts_body">
						<ui class="contacts">
						
						
						
						<?php
						$usr_name = $_SESSION['username'];
                $sql_get_friends = "SELECT * FROM `friends`.`$usr_name`";
                $run_friends_sql = mysqli_query($conn,$sql_get_friends);
                $no_of_friends = mysqli_num_rows($run_friends_sql);
        
            if($no_of_friends > 0){
            while($get_friends = mysqli_fetch_assoc($run_friends_sql)){
                $is_friend = $get_friends['request_status'];
                if($is_friend == "true"){
                $friend_username = $get_friends['friend_username'];

            $friends_detail_sql = "SELECT * FROM `messanger`.`user_detail` WHERE `username`='$friend_username'";
            $friends_detail_run = mysqli_query($conn, $friends_detail_sql);
            $friends_detail = mysqli_fetch_assoc($friends_detail_run);
            $imgpath = $friends_detail['profilepic'];
                
            echo '
			<li class="active">
			<a  role="link" href="messanger.php?user='.$friend_username.'" >
				<div class="d-flex bd-highlight">
					<div class="img_cont">
					<img class="rounded-circle" src="partials/'.$imgpath.'" height="60px">
						<span class="online_icon"></span>
					</div>
					<div class="user_info">
						<span>'.$friend_username.'</span>
						<p>'.$friend_username.' is online</p>
					</div>
				</div>
				</a>
			</li>';
           
            }else{
                echo '<h3 class="text-muted"> No Friends  </h3>';
			}
			


        }

        }else{
            echo '<h3 class="text-muted"> No Friends  </h3>';
        }
            ?>


						</ui>
					</div>
					<div class="card-footer"></div>
				</div></div>