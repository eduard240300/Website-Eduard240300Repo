<?php
$link = mysqli_connect("sql111.unaux.com", "unaux_25455123", "submarinulnegru", "unaux_25455123_database_repository");
$query2 = "
CREATE TABLE IF NOT EXISTS `user_details` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_security_hint` varchar(200) NOT NULL,
  `user_security_phrase` varchar(200) NOT NULL
);";
echo $query2;
// Attempt insert query execution
if(mysqli_query($link, $query2)){
 echo "Added successfully !";
} else{
 echo "Added no successfully !";
}
?>
