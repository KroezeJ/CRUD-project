<?php

session_start();
include 'config.php';
$user = $_GET['user'];
$loggedin = $_SESSION['login_user'];
$currentprivileges = "SELECT isadmin FROM users WHERE username = '$user'";
$loggedinprivileges = "SELECT isadmin FROM users WHERE username = '$loggedin'";
$stmt = $conn->prepare($currentprivileges);
$stmt->execute();
$privileges = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $conn->prepare($loggedinprivileges);
$stmt->execute();
$loggedinprivileges = $stmt->fetch(PDO::FETCH_ASSOC);

if (!isset($_SESSION['login_admin'])) {
    header("location: ../webpages/index.php");
} else {
    if ($user == $loggedin) {
        echo "<script>alert('You cant remove your own admin privileges.');
        window.location.href='../webpages/index.php';</script>";
    } else {
        if ($privileges['isadmin'] == "superadmin") {
            if ($loggedinprivileges['isadmin'] == "superadmin") {
                $query = "UPDATE users SET isadmin = 'admin' WHERE username = '$user'";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                echo "<script>alert('Superadmin privileges revoked from $user.');
                window.location.href='../webpages/adminpanel.php';</script>";
            } else {
                echo "<script>alert('You dont have the privileges to revoke superadmin privileges from $user.');
                window.location.href='../webpages/adminpanel.php';</script>";
            }
        } else {
            if ($privileges['isadmin'] == "no") {
                echo "<script>alert('$user is not an admin.');
                window.location.href='../webpages/adminpanel.php';</script>";
            } else {
                $query = "UPDATE users SET isadmin = 'no' WHERE username = '$user'";
                $stmt = $conn->prepare($query);
                $stmt->execute();    
                echo "<script>alert('Admin privileges revoked from $user.');
                window.location.href='../webpages/adminpanel.php';</script>";
            }
        }
    }  
}

?>