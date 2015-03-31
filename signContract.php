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

$sql = "UPDATE Contract SET signs = now() WHERE contractID=" . $_GET['id'];

if ($conn->query($sql) === TRUE) {
    	$contractID = $conn->insert_id;
	echo "New contract " . $_GET['id'] ." signed successfully !";

	echo "<br><br><a href = selling.php>Back to first page</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
</body>
</html>
