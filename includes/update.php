<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'admincheck.php';
include 'config.php';
$tablesQuery = "SHOW TABLES";
$tablesStmt = $conn->prepare($tablesQuery);
$tablesStmt->execute();

$tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

$table = $_POST['table'];
$primaryKey = $_POST['primaryKey'];
$id = $_POST['id'];

$query = "UPDATE $table SET ";
foreach ($_POST as $key => $value) {
    if ($key == "table" || $key == "primaryKey" || $key == "id") {
        continue;
    }
    if ($value == "") {
        continue;
    }
    $query .= "$key = '$value', ";
}
$query = substr($query, 0, -2);
$query .= " WHERE $primaryKey = $id";

$stmt = $conn->prepare($query);
$stmt->execute();

header("Location: ../webpages/index.php");