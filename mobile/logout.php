<?php
//logout.php

if(!isset($_COOKIE["mobile_id"]))
{
 header("location:login.php");
}

setcookie("mobile_recovered_username", "", time()-3600);
setcookie("mobile_recovered_security_hint", "", time()-3600);
setcookie("mobile_recovered_security_phrase", "", time()-3600);
setcookie("mobile_recovered_bool", "", time()-3600);

setcookie("mobile_id", "", time()-3600);
setcookie("mobile_username", "", time()-3600);
setcookie("mobile_password", "", time()-3600);
setcookie("mobile_name", "", time()-3600);
header("location:login.php");

?>
