<?php
//index.php

require_once 'mobile_detect.php';
$detect = new Mobile_Detect;

if ( $detect->isMobile() ) {
 header("location:mobile/index.php");
}

if( $detect->isTablet() ){
 header("location:mobile/index.php");
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
  <title>Repository of <?php echo $_COOKIE["name"] ?></title>
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
    echo '<h2 align="center">Repository of ' . $_COOKIE["name"] . '</h2>';
   }
   ?>
   <h2> </h2>
   <?php
    $conn = new PDO("mysql:host=sql111.unaux.com;dbname=unaux_25455123_database_repository", "unaux_25455123", "submarinulnegru");
    $staff=$conn->prepare("SELECT count(*) FROM user_details");
    $staff->execute();
    $staffrow = $staff->fetch(PDO::FETCH_NUM);
    $cnt = $staffrow[0];
    $conn->exec("SET CHARACTER SET utf8");      // Sets encoding UTF-8
    $sql = "SELECT `id`, `type`, `name`, `page_or_time` FROM `repository_" . $_COOKIE["username"] . "` ORDER BY `id` ASC";
    $result = $conn->query($sql);
   ?>
   <?php if ($cnt > 0): ?>
   <h4>
   <style type="text/css">
    td {
    padding: 10px 10px 10px 10px;
    align: center;
   }
   </style>
   <table align="center" border="1">
    <thead>
     <tr>
      <td><b><center>ID</center></b></td>
      <td><b><center>Type</center></b></td>
      <td><b><center>Name</center></b></td>
      <td><b><center>Data</center></b></td>
     </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row): array_map('htmlentities', $row); ?>
     <tr>
      <td><b><center><?php echo $row["id"]; ?></center></b></td>
      <td><center><?php echo $row["type"]; ?></center></td>
      <td><center><?php echo $row["name"]; ?></center></td>
      <td><center><?php echo $row["page_or_time"]; ?></center></td>
     </tr>
     <?php endforeach; ?>
    </tbody>
   </table>
   <?php endif; ?>
   </h4>
   <h2></h2>
   <h4>
   <table align="center">
    <tr>
     <td><input type="button" onclick="location.href='add.php';" value="Add Entry" /></td>
     <td><input type="button" onclick="location.href='delete.php';" value="Delete Entry" /></td>
     <td><input type="button" onclick="location.href='modify.php';" value="Modify Entry" /></td>
    </tr>
   </table>
   </h4>
   <?php $conn = null; ?>
  </div>
 </body>
</html>
