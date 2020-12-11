<?php
//deleteaccount.php

if(!isset($_COOKIE["id"]))
{
 header("location:login.php");
}

setcookie("recovered_username", "", time()-3600);
setcookie("recovered_security_hint", "", time()-3600);
setcookie("recovered_security_phrase", "", time()-3600);
setcookie("recovered_bool", "", time()-3600);

include("database_connection.php");
$query = "
DELETE FROM user_details WHERE user_id=" . $_COOKIE["id"] . ";";
$link = mysqli_connect("sql111.unaux.com", "unaux_25455123", "submarinulnegru", "unaux_25455123_database_repository");
if(mysqli_query($link, $query)){
 $staff=$connect->prepare("SELECT count(*) FROM user_details");
 $staff->execute();
 $staffrow = $staff->fetch(PDO::FETCH_NUM);
 $cnt = $staffrow[0];
 for($i = $_COOKIE["id"]+1;$i<=$cnt + 1;$i++)
 {
  $new_id = $i - 1;
  $update="update user_details set user_id=" .$new_id. ' where user_id=' . $i . ";";
  mysqli_query($link, $update);
 }
 $delete="drop table repository_" .$_COOKIE["username"] . ";";
 mysqli_query($link, $delete);
 setcookie("id", "", time()-3600);
 setcookie("mobile_id", "", time()-3600);
 mysqli_close($link);
 header("location:login.php");
} else{
 echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
}
mysqli_close($link);

?>
