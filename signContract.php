<html>
<head>
<title>Sig contract</title>
</head>
<body>

<?php 


$servername = "localhost";
$username = "root";
$password = "Spaceman1260";
$dbname = "Lab2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE Contract SET signs = now() WHERE contractID=" . $_GET['id'];

if ($conn->query($sql) === TRUE) {
    	$contractID = $conn->insert_id;
	echo "New contract " . $_GET['id'] ." signed successfully !";

	echo "<br><br><a href = start.html>Back to first page</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
</body>
</html>
