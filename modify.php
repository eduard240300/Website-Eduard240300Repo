<?php
//modify.php

include("database_connection.php");

require_once 'mobile_detect.php';
$detect = new Mobile_Detect;

if ( $detect->isMobile() ) {
 header("location:mobile/modify.php");
}

if( $detect->isTablet() ){
 header("location:mobile/modify.php");
}

if(!isset($_COOKIE["id"]))
{
 header("location:login.php");
}

setcookie("recovered_username", "", time()-3600);
setcookie("recovered_security_hint", "", time()-3600);
setcookie("recovered_security_phrase", "", time()-3600);
setcookie("recovered_bool", "", time()-3600);

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
  $sql = "SELECT `id`, `type`, `name`, `page_or_time` FROM `repository_" . $_COOKIE["username"] . "`";
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
   UPDATE repository_' . $_COOKIE["username"] . '
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
    echo '<h2 align="center">Modify Entry of Repository of ' . $_COOKIE["name"] . '</h2>';
   }
   ?>
   <h4 align="center"><a href="index.php">Back to Repository</a></h4>
   </div>
   <br />
   <div class="container">
    <h2 align="center">Modify Entry</h2>
    <br />
    <div class="panel panel-default">
     <div class="panel-heading">Modify Entry</div>
     <div class="panel-body">
      <span><?php echo $message; ?></span>
      <form method="post">
       <div class="form-group">
        <label>ID</label>
        <input type="text" name="id" id="id" class="form-control" />
       </div>
       <div class="form-group">
        <label>Data</label>
        <input type="text" name="page_or_time" id="page_or_time" class="form-control" />
       </div>
       <div class="form-group">
        <input type="submit" name="modify" id="modify" class="btn btn-info" value="Modify" />
       </div>
      </form>
     </div>
    </div>
    <br />
  </div>
 </body>
</html>
