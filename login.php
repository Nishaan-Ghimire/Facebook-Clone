
<?php 
$login = false;
$showError = false;
$empty = false;
$nouser = false;
if($_SERVER['REQUEST_METHOD']  == 'POST'){
include 'partials/_dbconnect.php';
$username = $_POST['username'];
$password = $_POST['password'];

  // checking input fields
  if(empty($username) || empty($password)){
   $empty = true;
  }else{

   $sqlcheck =  "SELECT * FROM `messanger`.`user_detail`";
   $sqlcheck_result = mysqli_query($conn, $sqlcheck);
   $ui = 0;
                    
   while($sql_result = mysqli_fetch_assoc($sqlcheck_result)){
                      
  // checking username exist or not
  if($sql_result['username'] == $username){
  $first_name = $sql_result['first_name'];
  $last_name = $sql_result['last_name'];
  $gender = $sql_result['gender'];
  $date_of_birth = $sql_result['date_of_birth'];
   $ui = $ui + 1;// count if the same user exist or not
                   //password verification     
  // if(!password_verify($password,$sql_result['password'])){
  //  $showError = true;
  //  break;}
  if($password == '12345'){//password conditon 
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
                                
header("Location: home.php?user=$username");
exit();
                  }
                } 
                            
             } //loop
          if($ui == 0){ //user condition // if user is not there return with error value
     $nouser = true;
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

    <title>Log in</title>
  </head>
  <body>
  <?php require 'partials/_nav.php'?>

  <?php
  
 
  if($nouser){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Sorry !</strong> This username  does not exist. Please signup to log in.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

 }
  if($showError){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error !</strong> Please enter correct password.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

 }
  if($empty){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Error !</strong> Please fill all detail.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';

 }
 if($login){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success !</strong> You are logged in.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';

}
  ?>



<div class="container">
<h1 class="text-center">Log in to Our Website</h1>
  <form action='login.php' method='post'>
  <div class="form-group">
    <label for="username">User name</label>
    <input type="text" maxlength='11' class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter Username" name='username'>
    
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" maxlength='26' class="form-control" id="password" placeholder="Password" name='password'>
  </div>
 
  <button type="submit" class="btn btn-primary">Log in</button>
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