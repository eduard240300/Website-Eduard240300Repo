<?php
//add.php

include("../database_connection.php");

require_once '../mobile_detect.php';
$detect = new Mobile_Detect;

if ( (!$detect->isMobile()) and (!$detect->isTablet())) {
 header("location:../add.php");
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

if(isset($_POST["add"]))
{
 if(empty($_POST["type"]) || empty($_POST["name"]) || empty($_POST["page_or_time"]))
 {
  $message = "<div class='alert alert-danger'>All Fields are required</div>";
 }
 else
 {
  $staff=$connect->prepare("SELECT count(*) FROM user_details");
  $staff->execute();
  $staffrow = $staff->fetch(PDO::FETCH_NUM);
  $cnt = $staffrow[0];
  $connect->exec("SET CHARACTER SET utf8");      // Sets encoding UTF-8
  $sql = "SELECT `id`, `type`, `name`, `page_or_time` FROM `repository_" . $_COOKIE["mobile_username"] . "`";
  $result = $connect->query($sql);
  $cnt_1 = 0;
  foreach ($result as $row) {
   if ($_POST["name"] == $row["name"])
   {
    $cnt_1++;
   }
  }
  if($cnt_1 == 0)
  {
   if(!empty($_POST["type"]))
   {
    $staff=$connect->prepare("SELECT count(*) FROM repository_" . $_COOKIE["mobile_username"]);
    $staff->execute();
    $staffrow = $staff->fetch(PDO::FETCH_NUM);
    $cnt = $staffrow[0];
    $cnt = $cnt + 1;
    $link = mysqli_connect("sql111.unaux.com", "unaux_25455123", "submarinulnegru", "unaux_25455123_database_repository");
    $query2 = '
    INSERT INTO `repository_' . $_COOKIE["mobile_username"] . '` (`id`, `type`, `name`, `page_or_time`) VALUES (' . $cnt . ', "'. $_POST["type"] . '", "'. $_POST["name"] . '", "'. $_POST["page_or_time"] . '");';
    // Attempt insert query execution
    if(mysqli_query($link, $query2)){
     $message = "<div class='alert alert-danger'>Added successfully !</div>";
     header("location:index.php");
    } else{
     $message = "<div class='alert alert-danger'>Not added successfully !</div>";
    }
   }
   else {
    $message = "<div class='alert alert-danger'>Type not correct !</div>";
   }
  }
  else
  {
   $message = '<div class="alert alert-danger">Already exists !</div>';
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
    echo '<h2 align="center" style="font-size:7vw;">Add Entry to Repository of </h2><h2 align="center" style="font-size:7vw;">' . $_COOKIE["mobile_name"] . '</h2>';
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
        <label style="font-size:6vw;">Type</label>
        <input type="text" name="type" id="type" class="form-control" style="font-size:7vw; height: 9vw;" />
       </div>
       <div class="form-group">
        <label style="font-size:6vw;">Name</label>
        <input type="text" name="name" id="name" class="form-control" style="font-size:7vw; height: 9vw;" />
       </div>
       <div class="form-group">
        <label style="font-size:6vw;">Data</label>
        <input type="text" name="page_or_time" id="page_or_time" class="form-control" style="font-size:7vw; height: 9vw;" />
       </div>
       <div class="form-group">
        <center><input type="submit" name="add" id="add" class="btn btn-info" value="Add" style="font-size:7vw;"/></center>
       </div>
      </form>
     </div>
    </div>
    <br />
  </div>
 </body>
</html>
