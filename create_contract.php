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
<input type="text" name="buyer" placeholder = "buyer email">
<br>
PickUP Address:<br>
<input type="text" name="pickUpAddress" value="<?php echo $address; ?>">
<br> 
Delivery Address:<br>
<input type="text" name="deliveryAddress">
<br><br>
<input type="submit" value="Register New Contract">
</form> 

</body>
</html>

