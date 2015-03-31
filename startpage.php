<html>
<head>
</head>
<body>
<?php
// Inialize session
session_start();
$email = $_POST['email'];

$servername = "localhost";
$username = "me";
$password = "pechkin";
$dbname = "Lab2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT email, address FROM User WHERE email = '" . $email . "' AND password = '" . $_POST['passwd'] . "'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("user not found");
}

$_SESSION['username'] = $result->fetch_assoc()["email"]; // Set login user. (assume num_rows was above 0.)
$address = $result->fetch_assoc()["address"];
	
# Get contracts
$sql = "SELECT * FROM Contract WHERE seller = '" . $email . "' OR buyer = '" . $email . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
?>
    <table>
        <tr><th>Contract</th><th>Buy/Sell</th><th>Status</th></tr>
    </table>
<?php
}


$conn->close();
?>
Welcome <?php echo $_SESSION['username']; ?><br>
</body>
</html>

