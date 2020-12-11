<?php
//account.php

require_once 'mobile_detect.php';
$detect = new Mobile_Detect;

if ( $detect->isMobile() ) {
 header("location:mobile/account.php");
}

if( $detect->isTablet() ){
 header("location:mobile/account.php");
}

if(!isset($_COOKIE["id"]))
{
 header("location:login.php");
}

setcookie("recovered_username", "", time()-3600);
setcookie("recovered_security_hint", "", time()-3600);
setcookie("recovered_security_phrase", "", time()-3600);
setcookie("recovered_bool", "", time()-3600);

?>
<!DOCTYPE html>
<html>
 <head>
  <title>Account of <?php echo $_COOKIE["name"] ?></title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="icon" href="images/icon.ico">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <div class="container">
   <br />
   <div align="right">
    <a href="index.php">My Repository</a>
    <a href="account.php">My Account</a>
    <a href="logout.php">Logout</a>
    <img src="images/standard.png" width="40" height="40">
    <?php
     echo $_COOKIE["name"];
    ?>
   </div>
   <br />
   <?php
   if(isset($_COOKIE["id"]))
   {
    echo '<h2 align="center">Account of ' . $_COOKIE["name"] . '</h2>';
   }
   ?>
   <h2> </h2>
   <h2></h2>
   <h4>
   <style type="text/css">
    td {
     padding: 10px 10px 10px 10px;
     align: center;
    }
   </style>
   <table align="center">
    <tr>
     <td><input type="button" onclick="location.href='change_password.php';" value="Change Password" /></td>
     <td><input type="button" onclick="location.href='change_security.php';" value="Change Security Phrase" /></td>
     <td><input type="button" onclick="location.href='delete_account.php';" value="Delete Account" /></td>
     <td><input type="button" onclick="location.href='logout.php';" value="Logout" /></td>
    </tr>
   </table>
   </h4>
   <?php $conn = null; ?>
  </div>
 </body>
</html>
