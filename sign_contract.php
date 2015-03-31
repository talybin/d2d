<?php
// Setup database
$conn = new mysqli("localhost", "me", "pechkin", "Lab2");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if GET is set, so we can obtain email and contractid
if(isset($_GET) ) {
	if (isset($_GET["email"]) && !empty($_GET["email"]) ) {
		if (isset($_GET["contractid"]) && !empty($_GET["contractid"]) ) {
			$buyerid = $_GET["email"];
			$contractid = $_GET["contractid"];

			$result = $conn->query("SELECT price from Package WHERE contractID='$contractid';");
			if ($result->num_rows == 1) {
				$packageprice = $result->fetch_row()[0];
			} else die("Couldn't find price for this contract, Please try again later.");
		} else die("Please set email and contractid. E.g. ?email=buyer@d2d.se&contractid=1");
	} else die("Please set email and contractid. E.g. ?email=buyer@d2d.se&contractid=1");
}

// Check if this is an Ajax request.
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

  if(isset($_POST)) {
//		$buyer_cardnr = $_POST['cardnr']; // xxxx xxxx xxxx xxxx
//		$buyer_secode = $_POST['secode']; // xxx
//		$buyer_carddate = $_POST['carddate']; // YYYY-MM
//		$buyer_name = $_POST['name'];
				
		$sql = "UPDATE Contract
            SET pays=NOW()
						WHERE buyer='$buyerid' AND contractID='$contractid'";

		$res = $conn->query($sql);
		if ($res->num_rows > 0) {
		    die("Error: Contract not found.");
		}
		die("Done.");
//		die("Done: '$res', '$buyerid', '$contractid' ");
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
/*				background-color:#2E4272;*/
			}
			#leftborder{
				float:left;
/*				background-color:#4F628E;*/
			}
			#rightborder{
				float:left;
/*				background-color:#7887AB;*/
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
				url: "sign_contract.php?email=<?php echo $buyerid;?>&contractid=<?php echo $contractid;?>",
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
				<p><?php echo $packageprice; ?> SEK</p>
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