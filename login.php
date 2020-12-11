<?php
//login.php

include("database_connection.php");

require_once 'mobile_detect.php';
$detect = new Mobile_Detect;

if ( $detect->isMobile() ) {
 header("location:mobile/login.php");
}

if( $detect->isTablet() ){
 header("location:mobile/login.php");
}

if(isset($_COOKIE["id"]))
{
 header("location:index.php");
}

setcookie("recovered_username", "", time()-3600);
setcookie("recovered_security_hint", "", time()-3600);
setcookie("recovered_security_phrase", "", time()-3600);
setcookie("recovered_bool", "", time()-3600);

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
     setcookie("id", $row["user_id"], time()+3600);
     setcookie("username", $row["user_username"], time()+3600);
     setcookie("password", $row["user_password"], time()+3600);
     setcookie("name", $row["user_name"], time()+3600);
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

<!DOCTYPE html>
<html>
 <head>
  <title>Login Page</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="icon" href="images/icon.ico">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
 <br />
 <div class="container">
  <h2 align="center">Login</h2>
  <br />
  <div class="panel panel-default">
   <div class="panel-heading">Login</div>
   <div class="panel-body">
    <span><?php echo $message; ?></span>
    <form method="post">
     <div class="form-group">
      <label>Username</label>
      <input type="text" name="user_username" id="user_username" class="form-control" />
     </div>
     <div class="form-group">
      <label>Password</label>
      <input type="password" name="user_password" id="user_password" class="form-control" />
     </div>
     <div class="form-group">
      <input type="submit" name="login" id="login" class="btn btn-info" value="Login" />
     </div>
     <div class="from-group">
      <a href="recover_form1.php">Recover password</a>
     </div>
     <div class="from-group">
      <a href="register.php">Register</a>
     </div>
    </form>
   </div>
  </div>
  <br />
 </div>
 </body>
</html>
