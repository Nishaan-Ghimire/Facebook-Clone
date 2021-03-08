
<?php 
//conditional variable for showing error condition
$showError = false;
$showAlert = false;
$exist = false;
$empty = false;

//checking request method
if($_SERVER['REQUEST_METHOD']  == 'POST'){
  include 'partials/_dbconnect.php';                                         //connect to database containing user detail
  //  include 'partials/_dbconnectfriends.php';

               //getting input from user and storing in variable
      $first_name = $_POST['fname'];
      $last_name = $_POST['lname'];
      $email = $_POST['email'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $cpassword = $_POST['cpassword'];
      $gender = $_POST['sex'];
      $date_of_birth = $_POST['dob'];



                // check if the form is empty or not
    if(empty($username) || empty($password) || empty($cpassword) || empty($email) || empty($first_name) || empty($last_name) || empty($gender) || empty($date_of_birth)){
      $empty = true;                                                         //give error if form is empty 
    }else{

                  //run the query in the database
                  $sqlcheck =  "SELECT * FROM `messanger`.`user_detail`"; 
                  $sqlcheck_result = mysqli_query($conn, $sqlcheck);
                  $ui = 0;
                  while($sql_result = mysqli_fetch_assoc($sqlcheck_result)){
                      if($sql_result['username'] == $username){
                          $ui = $ui + 1; //checking whether username exit or not
                      }
                  }
                  if($ui > 0){
                          $exist = true;
                   }else{
                        // if username is unique verifying password and confirmed password 
                      if(($password == $cpassword) && $exist == false){
                        $hash = password_hash($password, PASSWORD_DEFAULT); 
                        // query for inserting  detail into database
                          $sql = "INSERT INTO `messanger`.`user_detail`( `first_name`, `last_name`, `username`, `email`, `password`, `gender`, `date_of_birth`, `timestamp`,`profilepic`,`coverpic`) VALUES ('$first_name', '$last_name', '$username', '$email', '$hash', '$gender', '$date_of_birth', current_timestamp(), 'profileimg/userdefault.png','coverimg/cover.png')";
                          $result = mysqli_query($conn,$sql);

          
                          if($result){
                            // creating user table for storing their post and their friends list and status
$postsql = "CREATE TABLE `users`.`$username` ( `post_id` INT(12) NOT NULL AUTO_INCREMENT ,  `user_id` INT(12) NOT NULL ,  `user_caption` VARCHAR(255) NOT NULL ,  `user_post` VARCHAR(255) NOT NULL ,  `user_like_num` INT(12) NOT NULL ,  `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY  (`post_id`)) ENGINE = InnoDB";
$run_query = mysqli_query($conn,$postsql);
$friend_table_sql = "CREATE TABLE `friends`.`$username` (`friend_no`INT(12) NOT NULL AUTO_INCREMENT, `friend_id` INT(12) NOT NULL ,`friend_username` VARCHAR(255) NOT NULL ,`request_status` TEXT NOT NULL ,`request_timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `accepted_timestamp` DATETIME NOT NULL ,PRIMARY KEY  (`friend_no`)) ENGINE = InnoDB";
$run_query_friend = mysqli_query($conn,$friend_table_sql);   
$msg_table = "CREATE TABLE `chats`.`$username` ( `chat_id` INT(12) NOT NULL AUTO_INCREMENT ,  `sender` VARCHAR(255) NOT NULL ,  `message` VARCHAR(255) NOT NULL ,  `time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,    PRIMARY KEY  (`chat_id`)) ENGINE = InnoDB";
$msg_table_run = mysqli_query($conn,$msg_table); 

$like_table = "CREATE TABLE `likes`.`$username` ( `like_id` INT(24) NOT NULL AUTO_INCREMENT ,  `post_id` INT(64) NOT NULL ,  `liker_username` VARCHAR(255) NOT NULL ,  `liker_id` INT(24) NOT NULL ,  `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,PRIMARY KEY  (`like_id`)) ENGINE = InnoDB;";
$like_table_run = mysqli_query($conn,$like_table)
                              //creating table for storing their likes

                            header("Location: start_friend.php?user=$username");
                            exit();
                              $showAlert = true;
                          }
                      }else{
                          $showError = true;
                      }

                  }
    }

}



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

    <title>Sign up</title>
  </head>
  <body>
  <?php require 'partials/_nav.php'?>

  <?php
  
  if($showAlert){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Congratulation !</strong>   You have created your account.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  $login = true;
                               
  // Work to be done after user detail is right
 session_start();
$_SESSION['loggedin'] = true;
$_SESSION['profile'] = false;
$_SESSION['user_id'] = $sql_result['user_id'];
$_SESSION['username'] = $username;
$_SESSION['first_name']  = $first_name;
$_SESSION['last_name']  = $last_name;
$_SESSION['gender'] = $gender;
$_SESSION['date_of_birth'] = $date_of_birth;
$_SESSION['profile'] = false;
$_SESSION['profilecover'] = false;
                                
header("Location: profile.php?user=$username");
exit();
  }
  if($exist){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Sorry !</strong> This username already exists. Please try another one.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

 }
  if($showError){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error !</strong> Please enter same password.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

 }
  if($empty){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error !</strong> Please fill all detail.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

 }
  
  ?>

 

<div class="container">
<h1 class="text-center">Sign Up in Our Website</h1>
<form action='signup.php' method='POST'>
 <!-- For name -->
  <div class="form-row">
    <div class="col">
      <input type="text" class="form-control" placeholder="First name" name='fname'>
    </div>
    <div class="col">
      <input type="text" class="form-control" placeholder="Last name" name='lname'>
    </div>
  </div>
   <!-- For email and password -->
  <div class="form-row my-4">
    <div class="form-group col-md-6">
      <input type="text" class="form-control" id="inputEmail4" placeholder='Username' name='username' >
    </div>
    <div class="form-group col-md-6">
      <input type="email" class="form-control" id="inputEmail4" placeholder='Email' name='email'>
    </div>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" maxlength='23' class="form-control" id="password" placeholder="Password" name='password'>
  </div>
  <div class="form-group">
    <label for="cpassword"> Confirm Password</label>
    <input type="password" maxlength='23' class="form-control" id="cpassword" placeholder="Confirm Password" name='cpassword'>
    <small id="emailHelp" class="form-text text-muted">Make sure you type same Password.</small>
  </div>

  
  <div class="form-group">
  <label for="gender"> Gender :</label>
   <span> <input type="radio" id="male"  name='sex' value='male'> male</span>
   <span> <input type="radio" id="female"  name='sex' value='female' >female </span>
   </div>
   
  <div class="form-group">
  <label for="dob"> Date of Birth :</label>
    <input type="date"   id="dob"  name='dob'>
   
   </div>
   
 <input type="submit" class='btn btn-primary' value="Submit" name="submit">
</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="partials/js/jquery.min.js"></script>
    <script src="partials/js/popper.min.js"></script>
    <script src="partials/js/bootstrap.min.js"></script>

  </body>
</html>