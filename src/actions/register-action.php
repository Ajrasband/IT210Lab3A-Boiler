<?php
error_reporting(0);
session_start();
include '../config/settings.php'; //DB Connect Function Defined Here

$username = $_POST["username"];
$password = $_POST["password"];
$confirm = $_POST["confirm"];

if ($password !== $confirm) {
    // pwds don't match
    $_SESSION["pass_error"] = "Passwords must match";
    header("Location:../register.php", TRUE, 302);
    exit;
} else {
    $password = hash('sha256', $password);
    $conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);

    $sql_user = "SELECT username FROM Users WHERE username = ?";
    $user;
    $stmt = $conn->prepare($sql_user);
    $stmt->bind_param('s', $username);
    $stmt->bind_result($user);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    $sql_id = 'SELECT id FROM Users WHERE username = ? AND password = ?';
    $id;
    $stmt = $conn->prepare($sql_id);
    $stmt->bind_param('ss', $username, $password);
    $stmt->bind_result($id);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
    
    if ($username === $user) {
        $_SESSION["user_error"] = "Username is already taken.";
        header("Location:../register.php", TRUE, 302);
        exit;
    } else {
        $_SESSION["newuser"] = "Welcome $username";
        $_SESSION['logged_in'] = 'Yes';
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;
        $sql = "INSERT INTO Users (username, password, logged_in) VALUES (?,?,1)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $stmt->close();
        }
        $conn->close();
        header("Location:../index.php", TRUE, 302);
    }
}
