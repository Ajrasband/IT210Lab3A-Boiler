<?php
error_reporting(-1);
session_start();

if (isset($_SESSION['sort'])) {
    if ($_SESSION['sort'] === 'sort') {
        $_SESSION['sort'] = 'unsort';
    } else if ($_SESSION['sort'] === 'unsort') {
        $_SESSION['sort'] = 'sort';
    }
} else {
    $_SESSION['sort'] = 'sort';
}

header('Location:../index.php',TRUE,302);
