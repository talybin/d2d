<?php
session_start();
// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['uid'])) {
    header('Location: index.html');
}
$email = $_SESSION['uid'];
?>

<html>
<head>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<?php
include 'db/settings.php';

$sql = "SELECT c.contractId, seller, buyer, pickUpAddress, deliveryAddress, " .
       "opens, signs, pays, confirms, takes, picksUp, dropsOff, d.price delPrice, " .
       "SUM(weight) totWeight, SUM(p.price) totPrice, COUNT(packageId) numItems " .
       "FROM Contract c NATURAL JOIN Package p " .
       "LEFT JOIN Delivery d ON c.contractId = d.contractId " .
       "WHERE (seller = '". $email . "' OR buyer = '" . $email . "') " .
       "AND settled IS NOT NULL GROUP BY c.contractId";
$result = $conn->query($sql);
?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.html">D2D</a>
    </div>

    <ul class="nav navbar-nav">
        <li role="presentation"><a href="selling.php">Selling</a></li>
        <li role="presentation"><a href="buying.php">Buying</a></li>
        <li role="presentation" class="active">
            <a href="#">History <span class="badge"><?php echo $result->num_rows; ?></a>
        </li>
    </ul>
    <p class="navbar-text navbar-right">Signed in as <?php echo $email; ?></p>

</div>
</nav>


<?php
while ($contractRow = $result->fetch_assoc()) {
?>
<br>
<div class="panel panel-info">
  <div class="panel-heading">
    <?php
        echo $contractRow["numItems"] . " item(s), " .
             $contractRow["totWeight"] . " kg, Value: " .
             $contractRow["totPrice"] . " SEK";
    ?>
  </div>

  <div class="panel-body">
    <span class="label label-success">Created</span>
    <span class="label label-success">Signed</span>
    <span class="label label-success">Payed</span>
    <span class="label label-success">Confirmed</span>
    <span class="label label-success">Settled</span>
    <br><br>

    <table class="table">
    <thead>
    <tr>
        <th>Item</th>
        <th>Price</th>
        <th>Width</th>
        <th>Height</th>
        <th>Length</th>
        <th>Weight</th>
    </tr>
    </thead>
    <tbody>
<?php
    $sql = "SELECT * FROM Package " .
           "WHERE contractId = " . $contractRow["contractId"];
    $packages = $conn->query($sql);
    while ($row = $packages->fetch_assoc()) {
        echo "    <tr>\n";
        echo "        <td>" . $row["description"] . "</td>\n";
        echo "        <td>" . $row["price"] . "</td>\n";
        echo "        <td>" . $row["width"] . "</td>\n";
        echo "        <td>" . $row["height"] . "</td>\n";
        echo "        <td>" . $row["length"] . "</td>\n";
        echo "        <td>" . $row["weight"] . "</td>\n";
        echo "    </tr>\n";
    }
?>
    </tbody>
    </table>

  </div>
  <ul class="list-group">
    <li class="list-group-item disabled">Delivery</li>
    <li class="list-group-item">
    <p style="font-size: 13px">
<?php
    echo "        From <b>" . $contractRow["pickUpAddress"] . "</b>" .
         " (" . $contractRow["seller"] . ")" .
         " to <b>" . $contractRow["deliveryAddress"] . "</b>" .
         " (" . $contractRow["buyer"] . ")<br>\n";
    $deliveryPrice = "N/A";
    if (!is_null($contractRow["delPrice"]))
        $deliveryPrice = $contractRow["delPrice"] . " SEK";
    echo "        Price: " . $deliveryPrice . "<br><br>\n";
?>
        <span class="label label-success">Accepted</span>
        <span class="label label-success">Delivering</span>
        <span class="label label-success">Delivered</span>
    </p>
    </li>
  </ul>
</div>
<?php
}
$conn->close();
?>
</body>
</html>


