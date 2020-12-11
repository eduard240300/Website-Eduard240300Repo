<?php
//change_security.php

include("../database_connection.php");

require_once '../mobile_detect.php';
$detect = new Mobile_Detect;

if ( (!$detect->isMobile()) and (!$detect->isTablet())) {
 header("location:../change_security.php");
}

if(!isset($_COOKIE["mobile_id"]))
{
 header("location:index.php");
}

setcookie("mobile_recovered_username", "", time()-3600);
setcookie("mobile_recovered_security_hint", "", time()-3600);
setcookie("mobile_recovered_security_phrase", "", time()-3600);
setcookie("mobile_recovered_bool", "", time()-3600);

$message = '';

if(isset($_POST["change_security"]))
{
 if(empty($_POST["user_security_hint"]) || empty($_POST["user_security_phrase"]))
 {
  $message = "<div class='alert alert-danger'>All Fields are required</div>";
 }
 else
 {
  $link = mysqli_connect("sql111.unaux.com", "unaux_25455123", "submarinulnegru", "unaux_25455123_database_repository");
  $query = '
  UPDATE user_details
  SET user_security_hint = "' . $_POST["user_security_hint"] . '"
  WHERE user_id = ' . $_COOKIE["mobile_id"] . ';';
  // Attempt update query execution
  mysqli_query($link, $query);
  $query = '
  UPDATE user_details
  SET user_security_phrase = "' . password_hash($_POST["user_security_phrase"], PASSWORD_DEFAULT) . '"
  WHERE user_id = ' . $_COOKIE["mobile_id"] . ';';
  // Attempt update query execution
  if(mysqli_query($link, $query)){
   $message = "<div class='alert alert-danger'>Changed successfully !</div>";
   header("location:account.php");
  } else{
   $message = "<div class='alert alert-danger'>Not changed successfully !</div>";
  }
 }
}
?>

<!DOCTYPE html>
<html>
 <head>
  <title>Change Security</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="icon" href="../images/icon.ico">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
 <br />
 <div class="w3-container">
  <h2 align="center" style="font-size:10vw;">Change Security</h2><h2 align="center" style="font-size:10vw;">Page</h2>
  <br />
  <div class="panel panel-default">
   <div class="panel-body">
    <span style="font-size:6vw;"><?php echo $message; ?></span>
    <form method="post">
     <div class="form-group">
      <label style="font-size:6vw;">New security hint</label>
      <input type="text" name="user_security_hint" id="user_security_hint" class="form-control" style="font-size:7vw; height: 9vw;"/>
     </div>
     <div class="form-group">
      <label style="font-size:6vw;">New security phrase</label>
      <input type="text" name="user_security_phrase" id="user_security_phrase" class="form-control" style="font-size:7vw; height: 9vw;"/><br style="font-size:7vw;">
     </div>
     <div class="form-group">
      <center><input type="submit" name="change_security" id="change_security" class="btn btn-info" value="Change" style="font-size:7vw;"/></center><br style="font-size:7vw;">
     </div>
     <div class="from-group">
      <h2 align="center" style="font-size:6vw;"><a href="account.php"><u>Go To My Account</u></a></h2>
     </div>
    </form>
   </div>
  </div>
  <br />
 </div>
 </body>
</html>
