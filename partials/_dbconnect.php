<?php 
$servername = "localhost";
$username = "root";
$password = "";

 $conn = mysqli_connect($servername,$username,$password);
 if(!$conn){
     echo "Sorry !! Connection cannot be established . Please try again !!";
     die();
 }







?>