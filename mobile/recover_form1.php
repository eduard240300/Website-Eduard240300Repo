<?php
//recover_form1.php

include("../database_connection.php");

require_once '../mobile_detect.php';
$detect = new Mobile_Detect;

if ( (!$detect->isMobile()) and (!$detect->isTablet())) {
 header("location:../recover_form1.php");
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

if(isset($_POST["recover_form1"]))
{
 if(empty($_POST["recovered_username"]))
 {
  $message = "<div class='alert alert-danger'>The Field is required</div>";
 }
 else
 {
  $query = "
  SELECT * FROM user_details
  WHERE user_username = :recovered_username
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    'recovered_username' => $_POST["recovered_username"]
   )
  );
  $count = $statement->rowCount();
  if($count > 0)
  {
   $result = $statement->fetchAll();
   foreach($result as $row)
   {
    setcookie("mobile_recovered_username", $_POST["recovered_username"], time()+3600);
    setcookie("mobile_recovered_security_hint", $row["user_security_hint"], time()+3600);
    setcookie("mobile_recovered_security_phrase", $row["user_security_phrase"], time()+3600);
    header("location:recover_form2.php");
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
     <div class="form-group">
      <label style="font-size:6vw;">Username</label>
      <input type="text" name="recovered_username" id="recovered_username" class="form-control" style="font-size:7vw; height: 9vw;" /><br style="font-size:7vw;">
     </div>
     <div class="form-group">
      <center><input type="submit" name="recover_form1" id="recover_form1" class="btn btn-info" value="Next" style="font-size:7vw;"/></center><br style="font-size:7vw;">
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
