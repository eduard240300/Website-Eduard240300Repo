<?php
//change_password.php

include("database_connection.php");

require_once 'mobile_detect.php';
$detect = new Mobile_Detect;

if ( $detect->isMobile() ) {
 header("location:mobile/change_password.php");
}

if( $detect->isTablet() ){
 header("location:mobile/change_password.php");
}

if(!isset($_COOKIE["id"]))
{
 header("location:index.php");
}

setcookie("recovered_username", "", time()-3600);
setcookie("recovered_security_hint", "", time()-3600);
setcookie("recovered_security_phrase", "", time()-3600);
setcookie("recovered_bool", "", time()-3600);

$message = '';

if(isset($_POST["change_password"]))
{
 if(empty($_POST["old_password"]) || empty($_POST["new_password"]) || empty($_POST["new_password_repeat"]))
 {
  $message = "<div class='alert alert-danger'>All Fields are required</div>";
 }
 else
 {
  if (password_verify($_POST["old_password"] , $_COOKIE["password"]))
  {
   if ($_POST["old_password"] != $_POST["new_password"])
   {
    if ($_POST["new_password"] == $_POST["new_password_repeat"])
    {
     $link = mysqli_connect("sql111.unaux.com", "unaux_25455123", "submarinulnegru", "unaux_25455123_database_repository");
     $query = '
     UPDATE user_details
     SET user_password = "' . password_hash($_POST["new_password"], PASSWORD_DEFAULT) . '"
     WHERE user_id = ' . $_COOKIE["id"] . ';';
     // Attempt update query execution
     if(mysqli_query($link, $query)){
      $message = "<div class='alert alert-danger'>Changed password successfully !</div>";
      setcookie("id", $_COOKIE["id"], time()+3600);
      setcookie("username", $_COOKIE["username"], time()+3600);
      setcookie("password", password_hash($_POST["new_password"], PASSWORD_DEFAULT), time()+3600);
      setcookie("name", $_COOKIE["name"], time()+3600);
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
  <link rel="icon" href="images/icon.ico">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
 <br />
 <div class="container">
  <h2 align="center">Change Password</h2>
  <br />
  <div class="panel panel-default">
   <div class="panel-heading">Change Password</div>
   <div class="panel-body">
    <span><?php echo $message; ?></span>
    <form method="post">
     <div class="form-group">
      <label>Old password</label>
      <input type="password" name="old_password" id="old_password" class="form-control" />
     </div>
     <div class="form-group">
      <label>New password</label>
      <input type="password" name="new_password" id="new_password" class="form-control" />
     </div>
     <div class="form-group">
      <label>Repeat new password</label>
      <input type="password" name="new_password_repeat" id="new_password_repeat" class="form-control" />
     </div>
     <div class="form-group">
      <input type="submit" name="change_password" id="change_password" class="btn btn-info" value="Change Password" />
     </div>
     <div class="from-group">
      <a href="account.php">My account</a>
     </div>
    </form>
   </div>
  </div>
  <br />
 </div>
 </body>
</html>
