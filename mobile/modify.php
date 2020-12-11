<?php
//modify.php

include("../database_connection.php");

require_once '../mobile_detect.php';
$detect = new Mobile_Detect;

if ( (!$detect->isMobile()) and (!$detect->isTablet())) {
 header("location:../modify.php");
}

if(!isset($_COOKIE["mobile_id"]))
{
 header("location:login.php");
}

setcookie("mobile_recovered_username", "", time()-3600);
setcookie("mobile_recovered_security_hint", "", time()-3600);
setcookie("mobile_recovered_security_phrase", "", time()-3600);
setcookie("mobile_recovered_bool", "", time()-3600);

$message = "";

if(isset($_POST["modify"]))
{
 if(empty($_POST["id"]) || empty($_POST["page_or_time"]))
 {
  $message = "<div class='alert alert-danger'>All Fields are required</div>";
 }
 else
 {
  $connect->exec("SET CHARACTER SET utf8");      // Sets encoding UTF-8
  $sql = "SELECT `id`, `type`, `name`, `page_or_time` FROM `repository_" . $_COOKIE["mobile_username"] . "`";
  $result = $connect->query($sql);
  $cnt_1 = 0;
  $ID_INT = $_POST["id"] + 1;
  $ID_INT = $ID_INT - 1;
  foreach ($result as $row) {
   if ($ID_INT == $row["id"])
   {
    $cnt_1++;
   }
  }
  if($cnt_1 > 0)
  {
   $link = mysqli_connect("sql111.unaux.com", "unaux_25455123", "submarinulnegru", "unaux_25455123_database_repository");
   $query2 = '
   UPDATE repository_' . $_COOKIE["mobile_username"] . '
   SET page_or_time = "' . $_POST["page_or_time"] . '"
   WHERE id = ' . $ID_INT . ';';
   // Attempt update query execution
   if(mysqli_query($link, $query2)){
    $message = "<div class='alert alert-danger'>Modified successfully !</div>";
    header("location:index.php");
   } else{
    $message = "<div class='alert alert-danger'>Not modified successfully !</div>";
   }
  }
  else
  {
   $message = '<div class="alert alert-danger">Does not exist !</div>';
  }
 }
}
else{
 $message = "";
}


?>
<!DOCTYPE html>
<html>
 <head>
  <title>Repository of <?php echo $_COOKIE["mobile_name"] ?></title>
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
    echo '<h2 align="center" style="font-size:7vw;">Modify Entry of Repository of </h2><h2 align="center" style="font-size:7vw;">' . $_COOKIE["mobile_name"] . '</h2>';
   }
   ?>
   <h4 align="center" style="font-size:6vw;"><a href="index.php">Back to Repository</a></h4>
   </div>
   <br />
   <div class="w3-container">
    <br />
    <div class="panel panel-default">
     <div class="panel-body">
      <span style="font-size:6vw;"><?php echo $message; ?></span>
      <form method="post">
       <div class="form-group">
        <label style="font-size:6vw;">ID</label>
        <input type="text" name="id" id="id" class="form-control" style="font-size:7vw; height: 9vw;" />
       </div>
       <div class="form-group">
        <label style="font-size:6vw;">Data</label>
        <input type="text" name="page_or_time" id="page_or_time" class="form-control" style="font-size:7vw; height: 9vw;" />
       </div>
       <div class="form-group">
        <center><input type="submit" name="modify" id="modify" class="btn btn-info" value="Modify" style="font-size:7vw;"/></center>
       </div>
      </form>
     </div>
    </div>
    <br />
  </div>
 </body>
</html>
