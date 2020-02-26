<?php
error_reporting(-1);
session_start();
include '../config/settings.php'; //DB Connect Function Defined Here

$id = $_POST['task_id'];
$done;

$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);

$sql_isdone = 'SELECT done FROM Tasks WHERE id = ?';
$stmt = $conn->prepare($sql_isdone);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($done);
$stmt->fetch();
$stmt->close();

if ($done === 1) {
    $done = 0;
} else if ($done === 0) {
    $done = 1;
}

$sql = 'UPDATE Tasks SET done = ? WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $done, $id);
$stmt->execute();
$stmt->close();
$conn->close();

header('Location:../index.php',TRUE,302);
