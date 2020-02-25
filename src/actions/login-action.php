<?php
error_reporting(-1);
session_start();
include '../config/settings.php'; //DB Connect Function Defined Here

$username = $_POST["username"];
$password = hash("sha256", $_POST["password"]);

$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);
$sql_user = 'SELECT username FROM Users WHERE username = ?';
$sql_pass = 'SELECT password FROM Users WHERE password = ?';
$sql_id = 'SELECT id FROM Users WHERE username = ? AND password = ?';
$user;
$pass;
$id;

//Check for the same username. Will returnt the value into $user
$stmt = $conn->prepare($sql_user);
$stmt->bind_param('s', $username);
$stmt->bind_result($user);
$stmt->execute();
$stmt->fetch();
$stmt->close();

//Check for the same password. Will return the value into $pass
$stmt = $conn->prepare($sql_pass);
$stmt->bind_param('s', $password);
$stmt->bind_result($pass);
$stmt->execute();
$stmt->fetch();
$stmt->close();

//Get user ID
$stmt = $conn->prepare($sql_id);
$stmt->bind_param('ss', $username, $password);
$stmt->bind_result($id);
$stmt->execute();
$stmt->fetch();
$stmt->close();

if ($username === $user && $password === $pass) {
    $_SESSION["login_user"] = "Welcome back $username";
    $_SESSION['logged_in'] = 'Yes';
    $_SESSION['username'] = $username;
    $_SESSION['id'] = $id;

    $sql_update_id = 'UPDATE Users SET logged_in = 1 WHERE username = ?';
    $stmt = $conn->prepare($sql_update_id);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->close();

    $conn->close();
    header("Location:../index.php", TRUE, 302);
    exit;
} else {
    $_SESSION["login_error"] = "Invalid Credentials";
    $conn->close();
    header("Location:../login.php", TRUE, 302);
    exit;
}
