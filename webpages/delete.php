<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../includes/header.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <?php include '../includes/config.php' ?>
    <title>Project3- Delete</title>
</head>

<body>
    <div class="delete">
        <h1>Are you sure you want to delete this entry?</h1>
        <div class="buttons">
            <a href="index.php"><button type="button" class="btn btn-danger">No, go back.</button></a>
            <a href="../includes/deleteaction.php?<?php echo "table=" . $_GET['table'] . "&id=" . $_GET['id'] ?>"><button
                    type="button" class="btn btn-success">Yes, delete.</button></a>
        </div>
    </div>
</body>

</html>