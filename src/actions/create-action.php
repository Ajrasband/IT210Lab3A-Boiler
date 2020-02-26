<?php
error_reporting(-1);
session_start();
include '../config/settings.php'; //DB Connect Function Defined Here

$task = $_POST['task'];
$due_date = $_POST['duedate'];
$user_id;

$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);

$sql_get_user = 'SELECT id FROM Users WHERE logged_in = 1';
$stmt = $conn->prepare($sql_get_user);
$stmt->bind_result($user_id);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$sql_insert = "INSERT INTO Tasks (user_id, task, due_date, done) VALUES (?,?,?,0)";
$stmt = $conn->prepare($sql_insert);
$stmt->bind_param('iss', $user_id, $task, $due_date);
$stmt->execute();
$stmt->close();
$conn->close();

header('Location:../index.php',TRUE,302);
