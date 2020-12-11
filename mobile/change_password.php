<?php
//change_password.php

include("../database_connection.php");

require_once '../mobile_detect.php';
$detect = new Mobile_Detect;

if ( (!$detect->isMobile()) and (!$detect->isTablet())) {
 header("location:../change_password.php");
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

if(isset($_POST["change_password"]))
{
 if(empty($_POST["old_password"]) || empty($_POST["new_password"]) || empty($_POST["new_password_repeat"]))
 {
  $message = "<div class='alert alert-danger'>All Fields are required</div>";
 }
 else
 {
  if (password_verify($_POST["old_password"] , $_COOKIE["mobile_password"]))
  {
   if ($_POST["old_password"] != $_POST["new_password"])
   {
    if ($_POST["new_password"] == $_POST["new_password_repeat"])
    {
     $link = mysqli_connect("sql111.unaux.com", "unaux_25455123", "submarinulnegru", "unaux_25455123_database_repository");
     $query = '
     UPDATE user_details
     SET user_password = "' . password_hash($_POST["new_password"], PASSWORD_DEFAULT) . '"
     WHERE user_id = ' . $_COOKIE["mobile_id"] . ';';
     // Attempt update query execution
     if(mysqli_query($link, $query)){
      $message = "<div class='alert alert-danger'>Changed password successfully !</div>";
      setcookie("mobile_id", $_COOKIE["mobile_id"], time()+3600);
      setcookie("mobile_username", $_COOKIE["mobile_username"], time()+3600);
      setcookie("mobile_password", password_hash($_POST["new_password"], PASSWORD_DEFAULT), time()+3600);
      setcookie("mobile_name", $_COOKIE["mobile_name"], time()+3600);
      header("location:account.php");
     } else{
      $message = "<div class='alert alert-danger'>Not changed password successfully !</div>";
     }
    }
    else {
     $message = "<div class='alert alert-danger'>The new password fields don't match !</div>";
    }
   }
   else {
    $message = "<div class='alert alert-danger'>Old password should not be the same with new password !</div>";
   }
  }
  else {
    $message = "<div class='alert alert-danger'>Old password should match the account password !</div>";
  }
 }
}
?>

<!DOCTYPE html>
<html>
 <head>
  <title>Change Password</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="icon" href="../images/icon.ico">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
 <br />
 <div class="w3-container">
  <h2 align="center" style="font-size:10vw;">Change Password Page</h2>
  <br />
  <div class="panel panel-default">
   <div class="panel-body">
    <span style="font-size:6vw;"><?php echo $message; ?></span>
    <form method="post">
     <div class="form-group">
      <label style="font-size:6vw;">Old password</label>
      <input type="password" name="old_password" id="old_password" class="form-control" style="font-size:7vw; height: 9vw;"/>
     </div>
     <div class="form-group">
      <label style="font-size:6vw;">New password</label>
      <input type="password" name="new_password" id="new_password" class="form-control" style="font-size:7vw; height: 9vw;"/>
     </div>
     <div class="form-group">
      <label style="font-size:6vw;">Repeat new password</label>
      <input type="password" name="new_password_repeat" id="new_password_repeat" class="form-control" style="font-size:7vw; height: 9vw;"/><br style="font-size:7vw;">
     </div>
     <div class="form-group">
      <center><input type="submit" name="change_password" id="change_password" class="btn btn-info" value="Change Password" style="font-size:7vw;"/></center><br style="font-size:7vw;">
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
