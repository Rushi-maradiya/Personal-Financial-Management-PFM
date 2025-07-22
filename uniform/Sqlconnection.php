<?php
$conn = mysqli_connect("localhost", "root", "", "Money Rush");


if (!$conn) {
    die("<br>Database Connection Problem: " . mysqli_connect_error());
}

?>