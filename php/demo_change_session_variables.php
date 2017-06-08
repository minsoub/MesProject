<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// to change a session variable, just overwrite it 
$_SESSION["favcolor"] = "yellow";

   if( isset( $_SESSION['counter'] ) ) {
      $_SESSION['counter'] += 1;
   }else {
      $_SESSION['counter'] = 1;
   }
 if (isset($_SESSION['user'])) {
    echo "<br>user logged :in HTML and code here";
 } else {
    echo "<br>user not logged :in HTML and code here";
 }	
   
   $msg = "<br>You have visited this page ".  $_SESSION['counter'];
   $msg .= " in this session.<br>";
   echo $msg;
   
print_r($_SESSION);
?>
<br>
<a href="demo_show_session_variables.php">demo_show_session_variables.php</a>
<br>
<a href="demo_destroy_session_variables.php">demo_destroy_session_variables.php</a>

</body>
</html> 