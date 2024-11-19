<?php
$host = "localhost";
$dbuser = "root";
$dbPassword = "";
$dbname = "login_register";

$conn = mysqli_connect($host, $dbuser, $dbPassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connection successful!";
?>
