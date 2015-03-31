<?php
include 'db/settings.php';

$sql = "SELECT 1 FROM User WHERE email='" . $_POST["uid"] . "' AND password='" . $_POST["pwd"] . "'";
$result = $conn->query($sql);
if ($result->num_rows != 1) {
    header('Location: index.html');
}
else {
    session_start();
    $_SESSION['uid'] = $_POST["uid"];

    header('Location: selling.php');
}
?>

