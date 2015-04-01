<?php
session_start();
// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['uid'])) {
    header('Location: index.html');
}
$email = $_SESSION['uid'];

include 'db/settings.php';

$sql = "SELECT address FROM User WHERE email = '" . $email . "'";
$result = $conn->query($sql);
if ($row = $result->fetch_assoc()) {
    $address = $row["address"];
}
$result = $conn->query("SELECT email FROM Buyer");
?>

<!DOCTYPE html>
<html>
<head>
<title>Welcome to D2D</title>
</head>
<body>
   Register new contract below <br><br> 
<form action="registerContract.php" method="post">
Buyer:<br>
<select name="buyer">
<?php
    while ($row = $result->fetch_assoc()) {
        $m = $row["email"];
        echo "<option value=\"$m\">$m</option>\n";
    }
?>
</select>
<!--<input type="text" name="buyer" placeholder = "buyer email">-->
<br><br>
PickUP Address:<br>
<input type="text" name="pickUpAddress" value="<?php echo $address; ?>">
<br><br>
Delivery Address:<br>
<input type="text" name="deliveryAddress">
<br><br>
<input type="submit" value="Register New Contract">
</form> 

</body>
</html>

