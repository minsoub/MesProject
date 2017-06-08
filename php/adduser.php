<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// Set session variables
$_SESSION['counter']=0;
$_SESSION['user'] = 'abc';
$_SESSION['password'] = 'abc';
$_SESSION['dbname'] = 'BOM';
$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Session variables are set.<br>";

$hash = password_hash($_SESSION["password"], PASSWORD_DEFAULT);
$_SESSION['hash']=$hash;
print_r($hash);

if (password_verify($_SESSION['password'], $hash)) {
    // Success!
	echo "<br>password verify success!!!<br>";
}
else {
	echo "<br>password verify failed!!!<br>";
    // Invalid credentials
}
echo "hashed password: " . $hash . "<br><br>";

?>
<br>
<a href="demo_show_session_variables.php">demo_show_session_variables.php</a>
<br>
<a href="demo_change_session_variables.php">demo_change_session_variables.php</a>
<br>
<a href="demo_destroy_session_variables.php">demo_destroy_session_variables.php</a>
</body>
</html> 