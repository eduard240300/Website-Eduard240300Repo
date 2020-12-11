<?php
//logout.php

if(!isset($_COOKIE["id"]))
{
 header("location:login.php");
}

setcookie("recovered_username", "", time()-3600);
setcookie("recovered_security_hint", "", time()-3600);
setcookie("recovered_security_phrase", "", time()-3600);
setcookie("recovered_bool", "", time()-3600);

setcookie("id", "", time()-3600);
setcookie("username", "", time()-3600);
setcookie("password", "", time()-3600);
setcookie("name", "", time()-3600);
header("location:login.php");

?>
