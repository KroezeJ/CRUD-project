<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/header.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <?php include '../includes/config.php' ?>
    <?php include '../includes/admincheck.php' ?>
    <title>Project3 - Edit</title>
</head>

<body>
    <?php include '../includes/navbar.php'; ?>

    <?php

    function get_primary_key($table, $conn)
    {
        $query = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['Column_name'];
    }

    $table = $_GET['table'];
    $id = $_GET['id'];
    $primaryKey = get_primary_key($table, $conn);
    $query = "SELECT * FROM $table WHERE $primaryKey = '$id'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    ?>
    <div class="edit container mt-5">
        <h2>Edit
            <?php echo $table ?>
        </h2>
        <form action="../includes/update.php" method="post">
            <input type="hidden" name="table" value="<?php echo $table; ?>">
            <input type="hidden" name="primaryKey" value="<?php echo $primaryKey; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <?php
            foreach ($result as $key => $value) {
                if ($key == $primaryKey || $key == "isadmin" || $key == "created_at") {
                    continue;
                }
                echo "<div class=\"mb-3\">";
                echo "<label for=\"$key\" class=\"form-label\">" . ucfirst($key) . "</label>";
                echo "<input type=\"text\" class=\"form-control\" id=\"$key\" name=\"$key\" placeholder=\"$key\" value=\"$value\">";
                echo "</div>";
            }
            ?>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="index.php"><button type="button" class="btn btn-primary m-2">Cancel</button></a>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>

</body>


</html>