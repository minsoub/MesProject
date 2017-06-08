<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
?>
<br>
<a href="demo_make_session.php">demo_make_session.php</a>

<br>
<a href="demo_show_session_variables.php">demo_show_session_variables.php</a>
<br>
<a href="demo_destroy_session_variables.php">demo_destroy_session_variables.php</a>

</body>
</html> 