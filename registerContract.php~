<html>
<head>
</head>
<body>
<?php

$seller = $_POST['seller'];
$buyer = $_POST['buyer'];
$pickUpAddress = $_POST['pickUpAddress'];
$deliveryAddress = $_POST['deliveryAddress'];

$servername = "localhost";
$username = "root";
$password = "Spaceman1260";
$dbname = "Lab2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO Contract (seller, buyer, pickUpAddress, deliveryAddress) VALUES( '" . $seller ."','". $buyer . "','". $pickUpAddress . "','" . $deliveryAddress . "')";

if ($conn->query($sql) === TRUE) {
    	$contractID = $conn->insert_id;
	echo "New contract " . $contractID . " created successfully";

	echo "<br><br>Do you want to register a package for this contract?";
	echo "<br> <br> <a href = registerPackage.php?id=".$contractID .">Register Package</a>  <a href = start.html>Back to first page</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
</body>
</html>
