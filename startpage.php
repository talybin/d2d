<html>
<head>
</head>
<body>
<?php
$email = $_POST['email'];

$servername = "localhost";
$username = "root";
$password = "Spaceman1260";
$dbname = "Lab2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT address FROM User WHERE email = '" . $email . "' AND password = '" . $_POST['passwd'] . "'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("user not found");
}

$row = $result->fetch_assoc();

$sql = "SELECT * FROM Contract WHERE seller = '" . $email . "' OR buyer = '" . $email . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {

}

$conn->close();
?>
Welcome <?php echo $row["address"]; ?><br>
</body>
</html>

