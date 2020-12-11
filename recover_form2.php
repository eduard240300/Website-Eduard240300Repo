<?php
//recover_form2.php

include("database_connection.php");

require_once 'mobile_detect.php';
$detect = new Mobile_Detect;

if ( $detect->isMobile() ) {
 header("location:mobile/recover_form2.php");
}

if( $detect->isTablet() ){
 header("location:mobile/recover_form2.php");
}

if(isset($_COOKIE["id"]))
{
 header("location:index.php");
}
if (!isset($_COOKIE["recovered_username"]))
{
  header("location:recover_form1.php");
}

setcookie("recovered_bool", "", time()-3600);

$message = '';

if(isset($_POST["recover_form2"]))
{
 if(empty($_POST["security_phrase"]))
 {
  $message = "<div class='alert alert-danger'>The Field is required</div>";
 }
 else
 {
  if(password_verify($_POST["security_phrase"], $_COOKIE["recovered_security_phrase"]))
  {
    setcookie("recovered_bool", "true", time()+3600);
    header("location:recover_form3.php");
  }
  else
  {
   $message = "<div class='alert alert-danger'>Wrong Security Phrase !</div>";
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
     <div class="from-group">
      <h2><label>Security Hint : <?php echo($_COOKIE["recovered_security_hint"]); ?></label></h2>
     </div>
     <div class="form-group">
      <label>Security Phrase</label>
      <input type="text" name="security_phrase" id="security_phrase" class="form-control" />
     </div>
     <div class="form-group">
      <input type="submit" name="recover_form2" id="recover_form2" class="btn btn-info" value="Next" />
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
