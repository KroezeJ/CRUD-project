<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

$table = $_GET['table'];
$id = $_GET['id'];

$getname = "SELECT column_name
FROM information_schema.columns
WHERE table_name = '$table' AND table_schema = 'project3'";
$stmt = $conn->prepare($getname);
$stmt->execute();
$column_name = $stmt->fetch(PDO::FETCH_ASSOC);
$columnname = $column_name['column_name'];


$query = "DELETE FROM $table WHERE $columnname = $id";
$stmt2 = $conn->prepare($query);
$stmt2->execute();


header("Location: ../webpages/index.php");

?>