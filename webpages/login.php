<?php
include '../includes/config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT isadmin FROM users WHERE username = :username AND password = :password";
    $statement = $conn->prepare($query);
    $statement->execute([':username' => $username, ':password' => $password]);
    $row = $statement->fetch(PDO::FETCH_COLUMN);
    if ($row == "superadmin") {
        $_SESSION['login_superadmin'] = $username;
        $_SESSION['login_admin'] = $username;
        $_SESSION['login_user'] = $username;
        header("location: index.php");
    } else if ($row == "admin") {
        $_SESSION['login_admin'] = $username;
        $_SESSION['login_user'] = $username;
        header("location: index.php");
    } else if ($row == "no") {
        $_SESSION['login_user'] = $username;
        header("location: index.php");
    } else {
        $error = "Login failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/header.php'; ?>
    <title>project3 - Login</title>
</head>

<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container-fluid text-center d-flex flex-column justify-content-center align-items-center">
        <h2>Login</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <div class="mt-2">
                <?php if ($error)
                    echo "<div class='alert alert-danger'>$error</div>"; ?>
            </div>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>

</html>