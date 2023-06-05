<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['login_admin'])) {
    header("location: ../webpages/index.php");
    exit();
}
?>