<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/admincheck.php'; ?>
    <?php include '../includes/header.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Project3 - adminPanel</title>
</head>

<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="container-fluid">
        <div class="table-responsive">
            <?php
            $table_name = "users";

            $query = "DESCRIBE $table_name";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $column_names = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query = "SELECT * FROM $table_name";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $loggedin = $_SESSION['login_user'];
            $loggedinprivileges = "SELECT isadmin FROM users WHERE username = '$loggedin'";
            $stmt = $conn->prepare($loggedinprivileges);
            $stmt->execute();
            $loggedinprivileges = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "<h2>All users</h2>";

            echo "<table class='table table-striped table-dark'>";
            echo "<thead>";
            echo "<tr>";

            foreach ($column_names as $column) {
                echo "<th>" . htmlspecialchars($column['Field']) . "</th>";
            }
            if (isset($_SESSION['login_admin'])) {
                echo "<th class='text-center'>Actions</th>";
            }

            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach ($rows as $row) {
                echo "<tr>";
                foreach ($column_names as $column) {
                    $column_name = $column['Field'];
                    if ($column_name == "username") {
                        $temp = $row[$column_name];
                    }
                    if ($column_name == "isadmin") {
                        $tempadmin = $row[$column_name];
                    }
                    if ($column_name == "password" && !isset($_SESSION['login_superadmin'])) {
                        $hiddenpassword = strlen($row[$column_name]);
                        echo "<td>" . str_repeat("*", $hiddenpassword) . "</td>";
                    } else {
                        echo "<td>" . htmlspecialchars($row[$column_name]) . "</td>";
                    }
                }
                $first_column_value = reset($row);

                if (isset($_SESSION['login_superadmin'])) {
                    if (isset($_SESSION['login_admin']) && $temp != $_SESSION['login_user']) {
                        echo "<td class='text-center'> <a href='edit.php?table=$table_name&id=$first_column_value'><i class='fa-solid fa-pen-to-square'></i></a> <a href='delete.php?table=$table_name&id=$first_column_value'><i class='fa-solid fa-trash'></i></a> <a href='../includes/makeadmin.php?user=$temp'><i class='fa-solid fa-circle-up'></i></a> <a href='../includes/removeadmin.php?user=$temp'><i class='fa-solid fa-circle-down'></i></a></td>";
                    } else {
                        echo "<td class='text-center'> <a href='edit.php?table=$table_name&id=$first_column_value'><i class='fa-solid fa-pen-to-square'></i></a> <a class='unable'><i class='fa-solid fa-trash'></i></a> <a class='unable'><i class='fa-solid fa-circle-up'></i></a> <a class='unable'><i class='fa-solid fa-circle-down'></i></a></td>";
                    }
                } else {
                    if (isset($_SESSION['login_admin']) && $temp != $_SESSION['login_user']) {
                        echo "<td class='text-center'><a href='../includes/makeadmin.php?user=$temp'><i class='fa-solid fa-circle-up'></i></a> <a href='../includes/removeadmin.php?user=$temp'><i class='fa-solid fa-circle-down'></i></a></td>";
                    } else {
                        echo "<td class='text-center'> <a href='edit.php?table=$table_name&id=$first_column_value'><i class='fa-solid fa-pen-to-square'></i></a> <a class='unable'><i class='fa-solid fa-circle-up'></i></a> <a class='unable'><i class='fa-solid fa-circle-down'></i></a></td>";
                    }
                }

                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            ?>

        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>