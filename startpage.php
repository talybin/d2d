<html>
<head>
</head>
<body>
<?php
$email = $_POST['email'];

$servername = "localhost";
$username = "me";
$password = "pechkin";
$dbname = "Lab2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username FROM Buyer WHERE email = '" . $email . "' AND password = '" . $_POST['passwd'] . "'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("user not found");
}

$address = $result->fetch_assoc()["address"]

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
Welcome <?php echo $row["username"]; ?><br>
</body>
</html>

