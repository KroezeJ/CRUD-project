<?php
session_start();
session_destroy();
header("location: ../webpages/index.php");
?>