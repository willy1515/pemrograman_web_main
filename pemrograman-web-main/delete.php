<?php
require './config/db.php';

$id = $_GET['id'];

mysqli_query($db_connect, "DELETE FROM products WHERE id=$id");

header('location:show.php');
?>
