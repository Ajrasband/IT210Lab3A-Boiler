<?php
error_reporting(-1);
session_start();
include '../config/settings.php'; //DB Connect Function Defined Here

$_SESSION['logged_in'] = 'No';

$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);

$sql_update_id = 'UPDATE Users SET logged_in = 0 WHERE username = ?';
$stmt = $conn->prepare($sql_update_id);
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$stmt->close();

unset($_SESSION['username']);
unset($_SESSION['id']);

header("Location:../login.php", TRUE, 302);
exit;
