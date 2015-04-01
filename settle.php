<?php
session_start();
// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['uid'])) {
    header('Location: index.html');
}
$email = $_SESSION['uid'];
$cid = $_GET['cid'];

include 'db/settings.php';

$sql = "UPDATE Contract SET settled = NOW() WHERE contractid = $cid";
$conn->query($sql);
header('Location: selling.php');
?>

