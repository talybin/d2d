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
</head>
<body>
<?php

$buyer = $_POST['buyer'];
$pickUpAddress = $_POST['pickUpAddress'];
$deliveryAddress = $_POST['deliveryAddress'];

$sql = "INSERT INTO Contract (seller, buyer, pickUpAddress, deliveryAddress) VALUES( '" . $seller ."','". $buyer . "','". $pickUpAddress . "','" . $deliveryAddress . "')";

if ($conn->query($sql) === TRUE) {
    	$contractID = $conn->insert_id;
	echo "New contract " . $contractID . " created successfully";

	echo "<br><br>Do you want to register a package for this contract?";
	echo "<br> <br> <a href='registerPackage.php?id=".$contractID ."'>Register Package</a>  <a href='selling.php'>Back to first page</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
</body>
</html>
