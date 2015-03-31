<?php
session_start();
// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['uid'])) {
    header('Location: index.html');
}
$seller = $_SESSION['uid'];
?>
<html>
<head>
<title>Register package(s)</title>
</head>
<body>
   Register package(s) details<br><br> 
<?php 
echo 'working with contract ' . $_GET['id'] . '!';

?>

<form action="insertPackageDetails.php" method="post">
<input type = "hidden" name ="contractID" value="<?php echo $_GET['id']; ?>"> 
<input type="text" name="price" placeholder = "price in SEK">
<input type="text" name="description" placeholder = "description of contents">
<br><br>
<input type="text" name="height" placeholder = "height">
<input type="text" name="width" placeholder = "width">
<input type="text" name="length" placeholder = "length">
<br><br>
<input type="text" name="weigth" placeholder = "weight">
<br><br>
<input type="submit" value="Register New Package">
</form> 
</body>
</html>

