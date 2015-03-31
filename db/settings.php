<?php

$servername = "localhost";
$username = "me";
$password = "pechkin";
$dbname = "Lab2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

