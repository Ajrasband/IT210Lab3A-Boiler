<?php
error_reporting(-1);
session_start();
include '../config/settings.php'; //DB Connect Function Defined Here

$username = $_POST["username"];
$password = hash("sha256", $_POST["password"]);

$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);
$sql_user = 'SELECT username FROM Users WHERE username = ?';
$sql_pass = 'SELECT password FROM Users WHERE password = ?';
$user;
$pass;

//Check for the same username. Will returnt the value into $user
$stmt = $conn->prepare($sql_user);
$stmt->bind_param('s', $username);
$stmt->bind_result($user);
$stmt->execute();
$stmt->fetch();
echo "$user";
$stmt->close();

//Check for the same password. Will return the value into $pass
$stmt = $conn->prepare($sql_pass);
$stmt->bind_param('s', $password);
$stmt->bind_result($pass);
$stmt->execute();
$stmt->fetch();
echo "$pass";
$stmt->close();

$conn->close();
