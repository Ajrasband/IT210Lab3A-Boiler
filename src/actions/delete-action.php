<?php
error_reporting(-1);
session_start();
include '../config/settings.php'; //DB Connect Function Defined Here

$id = $_POST['delete'];

$conn = new mysqli($servername, $mysql_user, $mysql_password, $mysql_database);


$sql_delete = 'DELETE FROM Tasks WHERE id = ?';
$stmt = $conn->prepare($sql_delete);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();
$conn->close();

header('Location:../index.php',TRUE,302);