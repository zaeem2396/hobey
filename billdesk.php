<?php
$str = 'BDSKUATY|123456799|NA|2|NA|NA|NA|INR|NA|R|bdskuaty|NA|NA|F|Andheri|Mumbai|8097517477|patelnikul321@gmail.com|NA|NA|NA|NA';
$checksum = hash_hmac('sha256',$str,'G3eAmyVkAzKp8jFq0fqPEqxF4agynvtJ', false); 
$checksum = strtoupper($checksum);
echo $checksum;
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<!--[if IE 7 ]> <html class="ie7"> <![endif]-->
<!--[if IE 8 ]> <html class="ie8"> <![endif]-->
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>BillDesk - Modal UAT Payment Flow Testing</title>
	<style type="text/css"> input#pay { padding:20px 40px; cursor:pointer; font-size:17px; letter-spacing:0.10em;} </style>
</head>
<body>

<input type="button" value="Pay with BillDesk" id="pay" disabled onclick="SubmitPay();"/>

<script type="text/javascript" src="https://services.billdesk.com/checkout-widget/src/app.bundle.js"></script>
<script type="text/javascript">
	function SubmitPay() {
		 bdPayment.initialize({
	msg :'BDSKUATY|123456799|NA|2|NA|NA|NA|INR|NA|R|bdskuaty|NA|NA|F|Andheri|Mumbai|8097517477|patelnikul321@gmail.com|NA|NA|NA|NA|<?php echo $checksum; ?>',
			callbackUrl: 'https://www.bpsmart.in/beta/billresponse.php',
options : {
				enableChildWindowPosting : true,
				enablePaymentRetry : true,
				retry_attempt_count: 2
			}	
	 }); 
	}
document.addEventListener('readystatechange', function(event) {
    if (event.target.readyState === "complete") { var button = document.getElementById('pay'); button.disabled = false; button.value="Pay with BillDesk";button.classList.remove("disabled"); }
});
</script>
</body>
</html>