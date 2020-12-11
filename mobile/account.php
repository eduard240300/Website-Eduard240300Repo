<?php
//account.php

require_once '../mobile_detect.php';
$detect = new Mobile_Detect;

if ( (!$detect->isMobile()) and (!$detect->isTablet())) {
 header("location:../account.php");
}

if(!isset($_COOKIE["mobile_id"]))
{
 header("location:login.php");
}

setcookie("mobile_recovered_username", "", time()-3600);
setcookie("mobile_recovered_security_hint", "", time()-3600);
setcookie("mobile_recovered_security_phrase", "", time()-3600);
setcookie("mobile_recovered_bool", "", time()-3600);

?>
<!DOCTYPE html>
<html>
 <head>
  <title>Account of <?php echo $_COOKIE["mobile_name"] ?></title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="icon" href="../images/icon.ico">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <style type="text/css">
   td {
   padding: 20px 20px 20px 20px;
   align: center;
  }
  </style>
  <br />
  <div class="w3-container">
   <br />
   <div>
    <table align="center" style="font-size:6vw;">
     <tr>
      <td><a href="index.php">My Repo</a></td>
      <td><a href="account.php">My Account</a></td>
      <td><a href="logout.php">Logout</a></td>
     </tr>
    </table>
   </div>
   <br />
   <?php
   if(isset($_COOKIE["mobile_id"]))
   {
    echo '<h2 align="center" style="font-size:7vw;">Account of</h2><h2 align="center" style="font-size:7vw;">' . $_COOKIE["mobile_name"] . '</h2>';
   }
   ?>
   <h2><br style="font-size:7vw;"></h2>
   <h2><br style="font-size:7vw;"></h2>
   <center><input type="button" onclick="location.href='change_password.php';" value="Change Password" style="font-size:7vw;"/><h2><br style="font-size:7vw;"></h2></center>
   <center><input type="button" onclick="location.href='change_security.php';" value="Change Security Phrase" style="font-size:7vw;"/><h2><br style="font-size:7vw;"></h2></center>
   <center><input type="button" onclick="location.href='delete_account.php';" value="Delete Account" style="font-size:7vw;"/><h2><br style="font-size:7vw;"></h2></center>
   <center><input type="button" onclick="location.href='logout.php';" value="Logout" style="font-size:7vw;"/></center>
   <?php $conn = null; ?>
  </div>
 </body>
</html>
