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
<title>Insert Package details</title>
</head>
<body>
<?php
$contractID = $_POST['contractID'];
$price = $_POST['price'];
$description = $_POST['description'];
$height = $_POST['height'];
$width = $_POST['width'];
$length = $_POST['length'];
$weight = $_POST['weigth'];

$sql = "INSERT INTO Package (contractID, price, height, width, length, weight, description) 
VALUES( '" . $contractID ."','". $price . "','". $height . "','" . $width . "','" . $length . "','" . $weight . "','" . $description . "')";

if ($conn->query($sql) === TRUE) {
    	$packageID;
	$packageID = $conn->insert_id;
	
echo "<br> Package nr ".$packageID ." created successfully for contract " .$contractID ;

	echo "<br><br>Do you want to register another package?";
	echo "<br> <br> <a href = registerPackage.php?id=" .$contractID . ">Register 	Package</a>"  ;

	echo"<br><br> Do you want to sign contract " .$contractID . "?";
	echo"<br><br> <a href = signContract.php?id=" .$contractID . ">Sign Contract</a>";
	echo"<br><br>   <a href = selling.php>Back to first page</a>"    ;                                

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
</body>
</html>
