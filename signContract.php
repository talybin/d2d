<?php
session_start();
// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['uid'])) {
    header('Location: index.html');
}
$seller = $_SESSION['uid'];

include 'db/settings.php';
?>
<html>
<head>
<title>Sig contract</title>
</head>
<body>

<?php 

$sql = "insert into Delivery (contractID,driverID,price) select contractID,1,sum(height*width*length)/1000 from Package where contractID=". $_GET['id'];
$conn->query($sql);

$sql = "UPDATE Contract SET signs = now() WHERE contractID=" . $_GET['id'];

if ($conn->query($sql) === TRUE) {
    header('Location: selling.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	echo "<br><br><a href = selling.php>Back to first page</a>";
}

$conn->close();
?>
</body>
</html>
