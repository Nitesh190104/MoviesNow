<?php
$link = mysqli_connect("localhost", "root", "");
if ($link === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}
$sql = "CREATE DATABASE contactform";
if (mysqli_query($link, $sql)) {
    echo "Database created successfully";
} else {
    echo "Error: Could not execute $sql. " . mysqli_error($link);
}
mysqli_close($link);
?>