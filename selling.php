<html>
<head>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<?php
include 'db/settings.php';

$email = "seller@d2d.se";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT c.contractId, buyer, pickUpAddress, deliveryAddress, " .
       "opens, signs, pays, confirms, takes, picksUp, dropsOff, d.price delPrice, " .
       "SUM(weight) totWeight, SUM(p.price) totPrice, COUNT(packageId) numItems " .
       "FROM Contract c NATURAL JOIN Package p " .
       "LEFT JOIN Delivery d ON c.contractId = d.contractId " .
       "WHERE seller = '" . $email . "' AND settled IS NULL GROUP BY c.contractId";
$result = $conn->query($sql);
?>

<ul class="nav nav-pills">
  <li role="presentation" class="active">
    <a href="#">Selling <span class="badge"><?php echo $result->num_rows; ?></span></a>
  </li>
  <li role="presentation"><a href="buying.php">Buying</a></li>
  <li role="presentation"><a href="history.php">History</a></li>
</ul>

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
    <?php
        if (!is_null($contractRow['opens']) && is_null($contractRow['signs'])) {
    ?>
    <div class="alert alert-success" role="alert">
        Please <a href="#" class="alert-link">sign</a> this contract.
    </div>
    <?php
        }
        else if (!is_null($contractRow['confirms'])) {
    ?>
    <div class="alert alert-success" role="alert">
        Buyer has confirmed the delivery. Please <a href="#" class="alert-link">setle</a> this contract.
    </div>
    <?php
        }
    ?>
    <span class="label label-success">Created</span>
    <span class="label label-<?php
        echo is_null($contractRow['signs'])?'danger':'success';?>">Signed</span>
    <span class="label label-<?php
        echo is_null($contractRow['pays'])?'danger':'success';?>">Payed</span>
    <span class="label label-<?php
        echo is_null($contractRow['confirms'])?'danger':'success';?>">Confirmed</span>
    <span class="label label-danger">Settled</span>
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
         " to <b>" . $contractRow["deliveryAddress"] . "</b>" .
         " (" . $contractRow["buyer"] . ")</b><br>\n";
    $deliveryPrice = "N/A";
    if (!is_null($contractRow["delPrice"]))
        $deliveryPrice = $contractRow["delPrice"] . " SEK";
    echo "        Price: " . $deliveryPrice . "<br><br>\n";
?>
        <span class="label label-<?php
            echo is_null($contractRow['takes'])?'danger':'success';?>">Accepted</span>
        <span class="label label-<?php
            echo is_null($contractRow['picksUp'])?'danger':'success';?>">Delivering</span>
        <span class="label label-<?php
            echo is_null($contractRow['dropsOff'])?'danger':'success';?>">Delivered</span>
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


