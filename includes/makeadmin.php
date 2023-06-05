<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
        echo "<script>alert('You can't change your own privileges.');
        window.location.href='../webpages/adminpanel.php';</script>";
    } else {
        $loggedinUserIsSuperadmin = $loggedinprivileges['isadmin'] == "superadmin";
        $userIsAdmin = $privileges['isadmin'] == "admin";
        $userIsSuperadmin = $privileges['isadmin'] == "superadmin";
        $userIsNoAdmin = $privileges['isadmin'] == "no";
        if ($loggedinUserIsSuperadmin) {
            if ($userIsAdmin) {
                $query = "UPDATE users SET isadmin = 'superadmin' WHERE username = '$user'";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                echo "<script>alert('Superadmin privileges granted to $user.');
                window.location.href='../webpages/adminpanel.php';</script>";
            } elseif ($userIsSuperadmin) {
                echo "<script>alert('Superadmin privileges already granted to $user.');
                window.location.href='../webpages/adminpanel.php';</script>";
            } elseif ($userIsNoAdmin) {
                $query = "UPDATE users SET isadmin = 'admin' WHERE username = '$user'";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                echo "<script>alert('Admin privileges granted to $user.');
                window.location.href='../webpages/adminpanel.php';</script>";
            }
        } else {
            if ($userIsSuperadmin) {
                echo "<script type='text/javascript'>
                alert('You don\\'t have the privileges to perform this action.');
                window.location.href='../webpages/adminpanel.php';
            </script>";
            } elseif ($userIsAdmin) {
                echo "<script>alert('$user is already an admin.');
                window.location.href='../webpages/adminpanel.php';</script>";
            } elseif ($userIsNoAdmin) {
                $query = "UPDATE users SET isadmin = 'admin' WHERE username = '$user'";
                $stmt = $conn->prepare($query);
                $stmt->execute();
                echo "<script>alert('Admin privileges granted to $user.');
                window.location.href='../webpages/adminpanel.php';</script>";
            } else {
                echo "<script type='text/javascript'>
                alert('You don\\'t have the privileges to perform this action.');
                window.location.href='../webpages/adminpanel.php';
            </script>";
            }
        }
    }
}

?>
