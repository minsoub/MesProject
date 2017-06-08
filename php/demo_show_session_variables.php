<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// Echo session variables that were set on previous page
echo "start_hash:" . $_SESSION['hash'] . "<br>";
$hash = password_hash($_SESSION["password"], PASSWORD_DEFAULT);
echo "new_hash" . $hash . "<br>";
if (password_verify($_SESSION['password'], $_SESSION['hash'])) {
    // Success!
	echo "<br>start hashed password verify success!!!<br>";
}
else {
	echo "<br>start hashed password verify failed!!!<br>";
    // Invalid credentials
}
if (password_verify($_SESSION['password'], $hash)) {
    // Success!
	echo "<br>new hashed password verify success!!!<br>";
}
else {
	echo "<br>new hashed password verify failed!!!<br>";
    // Invalid credentials
}
echo "hashed password: " . $hash . "<br><br>";
echo "hashed password info: <br>" . print_r(password_get_info($hash));


echo "<br><br>";
print_r($_SESSION);

?>
<br>
<a href="demo_change_session_variables.php">demo_change_session_variables.php</a>
<br>
<a href="demo_destroy_session_variables.php">demo_destroy_session_variables.php</a>

</body>
</html> 