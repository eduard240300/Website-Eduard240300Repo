<?php
//recover_form3.php

include("database_connection.php");

require_once 'mobile_detect.php';
$detect = new Mobile_Detect;

if ( $detect->isMobile() ) {
 header("location:mobile/recover_form3.php");
}

if( $detect->isTablet() ){
 header("location:mobile/recover_form3.php");
}

if(isset($_COOKIE["id"]))
{
 header("location:index.php");
}
if (!isset($_COOKIE["recovered_username"]))
{
  header("location:recover_form1.php");
}
if (!isset($_COOKIE["recovered_bool"]))
{
  header("location:recover_form2.php");
}

$message = '';

if(isset($_POST["recover_form3"]))
{
 if(empty($_POST["new_password"]) || empty($_POST["new_password_repeat"]))
 {
  $message = "<div class='alert alert-danger'>All Fields are required</div>";
 }
 else
 {
  if ($_POST["new_password"] == $_POST["new_password_repeat"])
  {
   $link = mysqli_connect("sql111.unaux.com", "unaux_25455123", "submarinulnegru", "unaux_25455123_database_repository");
   $query = '
   UPDATE user_details
   SET user_password = "' . password_hash($_POST["new_password"], PASSWORD_DEFAULT) . '"
   WHERE user_username = "' . $_COOKIE["recovered_username"] . '";';
   // Attempt update query execution
   if(mysqli_query($link, $query)){
    $message = "<div class='alert alert-danger'>Changed password successfully !</div>";
    setcookie("recovered_username", "", time()-3600);
    setcookie("recovered_security_hint", "", time()-3600);
    setcookie("recovered_security_phrase", "", time()-3600);
    setcookie("recovered_bool", "", time()-3600);
   } else{
    $message = "<div class='alert alert-danger'>Not changed password successfully !</div>";
   }
  } else {
   $message = "<div class='alert alert-danger'>The new password fields don't match !</div>";
  }
 }
}
?>

<!DOCTYPE html>
<html>
 <head>
  <title>Recover Account Page</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="icon" href="images/icon.ico">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
 <br />
 <div class="container">
  <h2 align="center">Recover Account</h2>
  <br />
  <div class="panel panel-default">
   <div class="panel-heading">Recover Account</div>
   <div class="panel-body">
    <span><?php echo $message; ?></span>
    <form method="post">
     <div class="form-group">
      <label>New password</label>
      <input type="password" name="new_password" id="new_password" class="form-control" />
     </div>
     <div class="form-group">
      <label>Repeat new password</label>
      <input type="password" name="new_password_repeat" id="new_password_repeat" class="form-control" />
     </div>
     <div class="form-group">
      <input type="submit" name="recover_form3" id="recover_form3" class="btn btn-info" value="Recover Account" />
     </div>
     <div class="from-group">
      <a href="login.php">Login</a>
     </div>
    </form>
   </div>
  </div>
  <br />
 </div>
 </body>
</html>
