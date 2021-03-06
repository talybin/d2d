<?php
session_start();
// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['uid'])) {
    header('Location: index.html');
}
$email = $_SESSION['uid'];

include 'db/settings.php';


// Check if GET is set, so we can obtain email and contractid
if(isset($_GET) ) {
    if (!empty($email)) {
        if (isset($_GET["contractid"]) && !empty($_GET["contractid"]) ) {
            $buyerid = $email;
            $contractid = $_GET["contractid"];

            $result = $conn->query("select sum(p.price),d.price from Package p inner join Delivery d on p.contractID = d.contractID where p.contractID='$contractid';");
            if ($result->num_rows == 1) {
                $row = $result->fetch_row();
                $packageprice = $row[0];
                $deliveryprice = $row[1];
            } else die("Couldn't find price for this contract, Please try again later.");
        } else die("Please set email and contractid. E.g. ?email=buyer@d2d.se&contractid=1");
    } else die("Please set email and contractid. E.g. ?email=buyer@d2d.se&contractid=1");
}

// Check if this is an Ajax request.
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

  if(isset($_POST)) {
//      $buyer_cardnr = $_POST['cardnr']; // xxxx xxxx xxxx xxxx
//      $buyer_secode = $_POST['secode']; // xxx
//      $buyer_carddate = $_POST['carddate']; // YYYY-MM
//      $buyer_name = $_POST['name'];
                
        $sql = "UPDATE Contract
            SET pays=NOW()
                        WHERE buyer='$buyerid' AND contractID='$contractid'";
        $res = $conn->query($sql);

        $conn->query("UPDATE Delivery SET picksUp=NOW(), " .
                     "dropsOff=NOW() WHERE contractID='$contractid'");


        //if ($res->num_rows > 0) {
        //    die("Error: Contract not found.");
        //}
//      die("Done: '$res', '$buyerid', '$contractid' ");
        echo "<a href=\"buying.php\">Back</a>";
        die;
    }
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign Contract</title>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <style type='text/css'>
            div {
                padding: 0px 5px 0px 0px;
            }
            #container{
/*              background-color:#2E4272;*/
            }
            #leftborder{
                float:left;
/*              background-color:#4F628E;*/
            }
            #rightborder{
                float:left;
/*              background-color:#7887AB;*/
            }
        </style>        
</head>
<body>
<script>
    $(document).ready(function () {
        $("#submit").on("click", function(){
            //$("#result").html("clicked!");
            if ($('#betala')[0].checkValidity()) {
            $.ajax({
                type: "POST",
                url: "buyer_pay.php?contractid=<?php echo $contractid;?>",
                data: $('#betala').serialize(),
                success: function (data) {
                    if (data == "Done.") {
                        $("#submit").prop('disabled', true);
                        $('#betala').find("p").children(':input').attr('disabled', true);
                    }
                    $("#result").html(data);
                }
            });
            return false;}
        });
    });
</script>
<div id="content">
    <b>Fyll i uppgifterna nedan och klicka på 'Utför betalning' för att genomföra din betalning.</b>
    <form id="betala" action="" method="post">
        <div id="container">
            <div id="leftborder">
                <p>Summa:</p>
                <p>Kreditkortsnummer:</p>
                <p>Säkerhetskod (3 siffror):</p>
                <p>Slutdatum kort (MM/ÅÅ):</p>
                <p>Namn kortinnehavare (Förnamn / Efternamn):</p>
            </div>
            <div id="rightborder">
                <p><?php echo $packageprice . " + " . $deliveryprice . " = ". ($packageprice+$deliveryprice); ?> SEK</p>
        <p><input type="text" name="cardnr" placeholder="xxxx xxxx xxxx xxxx" pattern="[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}" required></p>
                <p><input type="text" name="secode" placeholder="xxx" pattern="[0-9]{3}" required></p>
                <p><input type="month" name="carddate" required></p>
                <p><input type="text" name="name" placeholder="John Doe" required></p>
            </div>
        </div>
        <!-- couldn't find a better solution to move the button below the form -->
        <br><br><br><br><br><br><br><br><br><br><br><br>
        <button id="submit">Utför betalning</button>
    </form>
</div>
<div id="result" class="result"></div>

</body>
</html>

