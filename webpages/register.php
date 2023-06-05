<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../includes/config.php';

session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $query = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
    $statement = $conn->prepare($query);
    $result = $statement->execute([':username' => $username, ':password' => $password, ':email' => $email]);

    if ($result) {
        $_SESSION['login_user'] = $username;
        header("location: index.php");
    } else {
        $error = "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/header.php'; ?>
    <title>project3 - Register</title>
</head>

<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container-fluid text-center d-flex flex-column justify-content-center align-items-center">
        <h2>Register</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <div class="mt-2">
                <?php if ($error)
                    echo "<div class='alert alert-danger'>$error</div>"; ?>
            </div>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>

</html>