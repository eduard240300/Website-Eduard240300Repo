<?php
//recover_form2.php

include("../database_connection.php");

require_once '../mobile_detect.php';
$detect = new Mobile_Detect;

if ( (!$detect->isMobile()) and (!$detect->isTablet())) {
 header("location:../recover_form2.php");
}

if(isset($_COOKIE["mobile_id"]))
{
 header("location:index.php");
}
if (!isset($_COOKIE["mobile_recovered_username"]))
{
  header("location:recover_form1.php");
}

setcookie("mobile_recovered_bool", "", time()-3600);

$message = '';

if(isset($_POST["recover_form2"]))
{
 if(empty($_POST["security_phrase"]))
 {
  $message = "<div class='alert alert-danger'>The Field is required</div>";
 }
 else
 {
  if(password_verify($_POST["security_phrase"], $_COOKIE["mobile_recovered_security_phrase"]))
  {
    setcookie("mobile_recovered_bool", "true", time()+3600);
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
  <link rel="icon" href="../images/icon.ico">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
 <br />
 <div class="w3-container">
  <h2 align="center" style="font-size:10vw;">Recover Account Page</h2>
  <br />
  <div class="panel panel-default">
   <div class="panel-body">
    <span style="font-size:6vw;"><?php echo $message; ?></span>
    <form method="post">
     <div class="from-group">
      <label style="font-size:6vw;">Security Hint : <?php echo($_COOKIE["mobile_recovered_security_hint"]); ?></label>
     </div>
     <div class="form-group">
      <label style="font-size:6vw;">Security Phrase</label>
      <input type="text" name="security_phrase" id="security_phrase" class="form-control" style="font-size:7vw; height: 9vw;" /><br style="font-size:7vw;">
     </div>
     <div class="form-group">
      <center><input type="submit" name="recover_form2" id="recover_form2" class="btn btn-info" value="Next" style="font-size:7vw;"/></center><br style="font-size:7vw;">
     </div>
     <div class="from-group">
      <h2 align="center" style="font-size:6vw;"><a href="login.php"><u>Login</u></a></h2>
     </div>
    </form>
   </div>
  </div>
  <br />
 </div>
 </body>
</html>
