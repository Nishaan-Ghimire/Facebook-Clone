

<?php 

if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin'] == true){
  
    $username = $_SESSION['username'];

  
    $user_check_sql = "SELECT `profilepic` FROM `messanger`.`user_detail` WHERE `username` = '$username'";
    $user_check_sql_run = mysqli_query($conn,$user_check_sql);
    $user_img= mysqli_fetch_assoc($user_check_sql_run);
    


if($username != ""){
    $sql_get_friends = "SELECT `request_status` FROM `friends`.`$username`WHERE `request_status` ='false'";
    $run_friends_sql = mysqli_query($conn,$sql_get_friends);
    $no_of_friends = mysqli_num_rows($run_friends_sql);
  } 
  $get_friends = "SELECT `friend_username` FROM `friends`.`$username`WHERE `request_status` ='true'";
    $friends_sql = mysqli_query($conn,$get_friends);
    $friends = mysqli_fetch_assoc($friends_sql);

  echo
  '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <span style="margin-right: 65px;"><a class="navbar-brand" href="/messanger/profile.php?user='.$username.'">WeChat</a></span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
      <span style="margin-right: 65px;">  <a class=" mr-5" href="/messanger/home.php?user='.$username.'"><img style="filter: invert(100%);" class="rounded-circle" src="img/home.png" height="50px"> </a></span>
    </li>

        <li class="nav-item">
        <span style="margin-right: 65px;">  <a class=" mr-5" href="/messanger/friends.php?user='.$username.'"><img style="filter: invert(100%);" class="rounded-circle" src="img/friend.png" height="50px">';
        
        if($no_of_friends > 0){

echo '<span class="badge badge-danger "> '. $no_of_friends.'</span>';

        }
        
        echo'
      </a></span>
      </li>
      <li class="nav-item">
      <span style="margin-right: 65px;">  <a class=" mr-5" href="/messanger/messanger.php?user='.$friends["friend_username"].'"><img style="filter: invert(100%);" class="rounded-circle" src="img/messanger.png" height="50px"></a></span>
        </li>
       
      </ul>
      <li class="nav-item ">
      <span style="margin-right: 65px;">
      <a  href="/messanger/profile.php?user='.$username.'"><img class="rounded-circle" src="partials/'.$user_img["profilepic"].'" height="50px"></a></span> </a>
    </li>
      <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
      <form class="form-inline my-2 my-lg-0" action="/messanger/logout.php">
       
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" >log out</button>
      </form>
    </div>
  </nav>';
  


}else{
echo
'<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/messanger/">WeChat</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
    <a class="nav-link" href="/messanger/profile.php">Home <span class="sr-only">(current)</span></a>
  </li>
      <li class="nav-item">
        <a class="nav-link" href="/messanger/login.php">Login </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="/messanger/signup.php">Sign up</a>
      </li>
      
     
    </ul>
   
  </div>
</nav>';
}
?>