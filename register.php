<?php
//register.php

include("database_connection.php");

require_once 'mobile_detect.php';
$detect = new Mobile_Detect;

if ( $detect->isMobile() ) {
 header("location:mobile/register.php");
}

if( $detect->isTablet() ){
 header("location:mobile/register.php");
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

if(isset($_POST["register"]))
{
 if(empty($_POST["user_name"]) || empty($_POST["user_username"]) || empty($_POST["user_password"]) || empty($_POST["user_password_repeat"]) || empty($_POST["user_security_hint"]) || empty($_POST["user_security_phrase"]))
 {
  $message = "<div class='alert alert-danger'>All Fields are required</div>";
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
  $staff=$connect->prepare("SELECT count(*) FROM user_details");
  $staff->execute();
  $staffrow = $staff->fetch(PDO::FETCH_NUM);
  $cnt = $staffrow[0];
  $cnt = $cnt + 1;
  if($count > 0)
  {
   $message = "<div class='alert alert-danger'>Username already exists !</div>";
  }
  else
  {
   if ($_POST["user_password"] == $_POST["user_password_repeat"])
   {
    $link = mysqli_connect("sql111.unaux.com", "unaux_25455123", "submarinulnegru", "unaux_25455123_database_repository");
    $query2 = '
    INSERT INTO `user_details` (`user_id`, `user_username`, `user_password`, `user_name`, `user_security_hint`, `user_security_phrase`) VALUES(' . $cnt . ', "'. $_POST["user_username"] . '", "' . password_hash($_POST["user_password"], PASSWORD_DEFAULT) . '", "' . $_POST["user_name"] . '", "' . $_POST["user_security_hint"] . '", "' . password_hash($_POST["user_security_phrase"], PASSWORD_DEFAULT) . '");';
    // Attempt insert query execution
    if(mysqli_query($link, $query2)){
     $message = "<div class='alert alert-danger'>Account created successfully !</div>";
     $sql = "
     CREATE TABLE IF NOT EXISTS `repository_" . $_POST["user_username"] . "` (
      `id` int(11) NOT NULL,
      `type` varchar(200) NOT NULL,
      `name` varchar(200) NOT NULL,
      `page_or_time` varchar(200) NOT NULL
     )";
     $link->query($sql);
     mysqli_close($link);
    } else{
     $message = "<div class='alert alert-danger'>Account not created successfully !</div>";
    }
   }
   else {
    $message = "<div class='alert alert-danger'>Password fields should match</div>";
   }
  }
 }
}
?>

<!DOCTYPE html>
<html>
 <head>
  <title>Register Page</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="icon" href="images/icon.ico">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <div class="container">
   <h2 align="center">Register</h2>
   <br />
   <div class="panel panel-default">
   <div class="panel-heading">Register</div>
    <div class="panel-body">
     <span><?php echo $message; ?></span>
    <form method="post">
    <div class="form-group">
     <label>Full Name</label>
     <input type="text" name="user_name" id="user_name" class="form-control" />
    </div>
    <div class="form-group">
     <label>Username</label>
     <input type="text" name="user_username" id="user_username" class="form-control" />
    </div>
    <div class="form-group">
     <label>Password</label>
     <input type="password" name="user_password" id="user_password" class="form-control" />
   </div>
   <div class="form-group">
    <label>Repeat password</label>
    <input type="password" name="user_password_repeat" id="user_password_repeat" class="form-control" />
   </div>
   <div class="form-group">
    <label>Security Hint</label>
    <input type="text" name="user_security_hint" id="user_security_hint" class="form-control" />
   </div>
   <div class="form-group">
    <label>Security Phrase</label>
    <input type="text" name="user_security_phrase" id="user_security_phrase" class="form-control" />
   </div>
   <div class="form-group">
    <input type="submit" name="register" id="register" class="btn btn-info" value="Register" />
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
