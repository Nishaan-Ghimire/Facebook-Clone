<?php require 'contacts.php';
$me = $_SESSION['username'];
$user = $_GET['user'];

$message_sql = "SELECT `message`,`time`,`sender` FROM `chats`.`$me`";
$message_sql_run = mysqli_query($conn, $message_sql);
$message_no = mysqli_num_rows($message_sql_run);

//me detail
$me_detail_sql = "SELECT `username`,`profilepic` FROM `messanger`.`user_detail` WHERE `username`='$me'";
$me_detail_run = mysqli_query($conn, $me_detail_sql);
$me_detail = mysqli_fetch_assoc($me_detail_run);

$my_img = $me_detail['profilepic'];

// detail
$user_detail_sql = "SELECT `username`,`profilepic` FROM `messanger`.`user_detail`  WHERE `username`='$user'";
$user_detail_run = mysqli_query($conn, $user_detail_sql);
$user_detail = mysqli_fetch_assoc($user_detail_run);

$friends_img = $user_detail['profilepic'];

?>


<div class="col-md-8 col-xl-6 chat">
    <div class="card">

        <div class="card-header msg_head">
            <div class="d-flex bd-highlight">
                <div class="img_cont">
                    <img src="partials/<?php echo $friends_img;?>" class="rounded-circle user_img">
                    <span class="online_icon"></span>
                </div>
                <div class="user_info">




                    <?php echo' <span id="name">'.$user.'</span>' ?>
                    <p>
                        <?php echo$message_no;?> Messages</p>
                </div>
                <div class="video_cam">
                    <span><i class="fas fa-video"></i></span>
                    <span><i class="fas fa-phone"></i></span>
                </div>
            </div>
            <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
            <div class="action_menu">
                <ul>
                    <li><i class="fas fa-user-circle"></i> View profile</li>
                    <li><i class="fas fa-users"></i> Add to close friends</li>
                    <li><i class="fas fa-plus"></i> Add to group</li>
                    <li><i class="fas fa-ban"></i> Block</li>
                </ul>
            </div>
        </div>
        <div class="card-body msg_card_body">
            <div class="tab-pane mymsg" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                <?php 
		

if($message_no == 0){
	echo "<h3>Start Conversation</h3>";
	exit;
}


		while ($message = mysqli_fetch_assoc($message_sql_run)) {
           
            
if($message['sender'] ==  lcfirst( $_GET['user'] )){	

echo '<div class="d-flex justify-content-end mb-4">

<div class="msg_cotainer_send">
'. $message["message"].'

</div> 
<div class="img_cont_msg">

<img class="rounded-circle" src="partials/'.$friends_img.'" height="60px">

	<strong>'.$message['sender'].'</strong>
</div>


</div><p style="text-align: right; margin-top: 40px;">'. $message["time"].'</p>	';



}if($message['sender'] == lcfirst($_SESSION['username'])){

    echo '<div class="d-flex justify-content-start mb-4">
    <div class="img_cont_msg">
    <img class="rounded-circle" src="partials/'.$my_img.'" height="60px">
    <strong>'.$message['sender'].'</strong>
        
    </div>
    <div class="msg_cotainer">
    '. $message["message"].'
    
    
    </div> 
   
    
    
    </div><p style="text-align: right; margin-top: 10px;">'. $message["time"].'</p>	';
    


}
	
		}
		
	
		
		?>

            </div>
        </div>



        <div class="card-footer">
            <div class="input-group">
                <div class="input-group-append">
                    <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                </div>

                <textarea name="msg" id='usermsg' class="form-control type_msg" placeholder="Type your message..."></textarea>

                <div class="input-group-append">

                    <span role="button" onclick="send()" type="submit" id="submitmsg" class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>




                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<script src="partials/js/jquery.min.js"></script>
    <script src="partials/js/popper.min.js"></script>
    <script src="partials/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#action_menu_btn').click(function() {
            $('.action_menu').toggle();
        });
    });

function send() {
    let rev = document.getElementById('txt');
    let txt = document.getElementById('usermsg');

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "_post_msg.php", false);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onprogress = () => {
        console.log("Loading.....");

    }
    xhr.onload = () => {
       
    }

    params = {message: txt.value,to: '<?php echo $_GET["user"]; ?>',from: '<?php echo $_SESSION["username"]; ?>'};
    xhr.send(JSON.stringify(params));

}
    
console.log("send");



</script>
</body>
</html>