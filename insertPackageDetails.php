<html>
<head>
</head>
<body>
<?php
$contractID = $_POST['id'];
$price = $_POST['price'];
$description = $_POST['description'];
$height = $_POST['height'];
$width = $_POST['width'];
$length = $_POST['length'];
$weight = $_POST['weigth'];

$servername = "localhost";
$username = "root";
$password = "Spaceman1260";
$dbname = "Lab2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO Package (contractID, price, height, width, length, weight, description) 
VALUES( '" . $contractID ."','". $price . "','". $height . "','" . $width . "','" . $length . "','" . $weight . "','" . $description . "')";

if ($conn->query($sql) === TRUE) {
    	$packageID;
	$packageID = $conn->insert_id;
	echo "contract nummer 	is:  " . $contractID;
echo "<br> Package with ".$packageID ." created successfully for contract " .$contractID ;

	echo "<br><br>Do you want to register another package?";
	echo "<br> <br> <a href = registerPackage.php?id=" .$contractID . ">Register 	Package</a>  <a href = start.html>Back to first page</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
</body>
</html>
