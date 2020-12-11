<?php
//login.php

include("../database_connection.php");

require_once '../mobile_detect.php';
$detect = new Mobile_Detect;

if ( (!$detect->isMobile()) and (!$detect->isTablet())) {
 header("location:../login.php");
}

if(isset($_COOKIE["mobile_id"]))
{
 header("location:index.php");
}

setcookie("mobile_recovered_username", "", time()-3600);
setcookie("mobile_recovered_security_hint", "", time()-3600);
setcookie("mobile_recovered_security_phrase", "", time()-3600);
setcookie("mobile_recovered_bool", "", time()-3600);

$message = '';

if(isset($_POST["login"]))
{
 if(empty($_POST["user_username"]) || empty($_POST["user_password"]))
 {
  $message = "<div class='alert alert-danger'>Both Fields are required</div>";
 }
 else
 {
  $query = "
  SELECT * FROM user_details
  WHERE user_username = :user_username
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    'user_username' => $_POST["user_username"]
   )
  );
  $count = $statement->rowCount();
  if($count > 0)
  {
   $result = $statement->fetchAll();
   foreach($result as $row)
   {
    if(password_verify($_POST["user_password"] , $row["user_password"]))
    {
     setcookie("mobile_id", $row["user_id"], time()+3600);
     setcookie("mobile_username", $row["user_username"], time()+3600);
     setcookie("mobile_password", $row["user_password"], time()+3600);
     setcookie("mobile_name", $row["user_name"], time()+3600);
     header("location:index.php");
    }
    else
    {
     $message = '<div class="alert alert-danger">Wrong Password</div>';
    }
   }
  }
  else
  {
   $message = "<div class='alert alert-danger'>Wrong Username</div>";
  }
 }
}
?>

<css>
</css>

<!DOCTYPE html>
<html>
 <head>
  <title>Login Page</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="icon" href="../images/icon.ico">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
 <br />
 <div class="w3-container">
  <h2 align="center" style="font-size:10vw;">Login Page</h2><br style="font-size:7vw;">
  <br />
  <div class="panel panel-default">
   <div class="panel-body">
    <span style="font-size:6vw;"><?php echo $message; ?></span>
    <form method="post">
     <div class="form-group">
      <label style="font-size:6vw;">Username</label>
      <input type="text" name="user_username" id="user_username" class="form-control" style="font-size:7vw; height: 9vw;"/>
     </div>
     <div class="form-group">
      <label style="font-size:6vw;">Password</label>
      <input type="password" name="user_password" id="user_password" class="form-control" style="font-size:7vw; height: 9vw;"/><br style="font-size:7vw;">
     </div>
     <div class="form-group">
      <center><input type="submit" name="login" id="login" class="btn btn-info" value="Login" style="font-size:7vw;"/></center><br style="font-size:7vw;">
     </div>
     <div class="from-group">
      <h2 align="center" style="font-size:6vw;"><a href="recover_form1.php"><u>Go To Recover Password Page</u></a></h2>
     </div>
	   <br style="font-size:1vw;">
     <div class="form-group">
      <h2 align="center" style="font-size:6vw;"><a href="register.php"><u>Go To Register Page</u></a></h2>
     </div>
    </form>
   </div>
  </div>
  <br />
 </div>
 </body>
</html>
