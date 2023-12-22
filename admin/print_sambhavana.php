<?php
session_start();
if(!isset($_SESSION['username'])) 
  {
    echo 'Session variable not set.';
    header("Location:index.php");
  }
  else{
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	
	$invoiceValues = $invoice->getSambhavanaInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getSambhavanaByID($_GET['invoice_id']);	
	$eventID = $invoiceValues['eventId'];
	$eventName = $invoiceValues['eventName'];
	$zone = $invoiceValues['zone'];
	$houseNumber = $invoiceValues['houseNumber'];
	$paymentDetails = $invoice->getSambhavanaPaymentStatus($_GET['invoice_id'],$eventID);	

$invoiceDate = date("d-m-Y", strtotime($invoiceValues['date']));
$output = '';
$output .= '
<html>
<head>
<title>Print Sambhavana Receipt | SARVAH</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anek+Malayalam&display=swap" rel="stylesheet">
<link rel="stylesheet" href="print.css" type="text/css">
<link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
<link rel="stylesheet" href="print.css" type="text/css">
</head>
<body>
<table width="100%" border="1" cellpadding="5" cellspacing="0" >
	<tr>
	<td colspan="2" align="center" style="font-size:16px"><b>കിഴുത്തുള്ളി ശ്രീ മഹാവിഷ്ണു ക്ഷേത്രം നെടുമ്പാൾ<br>സംഭാവന രശീതി - '.$invoiceValues['eventName'].'</b></td>

	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellpadding="5">
	<tr>
	<td width="65%">
	To,<br />
	
	പേര് : '.$invoiceValues['name'].'<br /> 
	വിലാസം : '.$invoiceValues['houseNumber'].'<br />
	സോൺ : '.$invoiceValues['zone'].'<br />
	</td>
	<td width="35%">         
	രശീതി നമ്പർ : '.$invoiceValues['sambhavanaId'].'<br />
	പുതുക്കിയ തീയതി : '.$invoiceDate.'<br />
	</td>
	</tr>
	</table>
	<br />
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">ക്രമ നമ്പർ</th>
	<th align="left">ഇനം കോഡ്</th>
	<th align="left">ഇനം</th>
	<th align="left">എണ്ണം</th>
	<th align="left">നിരക്ക്</th>
	<th align="left">തുക</th>
	</tr>';
$count = 0;   
foreach($invoiceItems as $invoiceItem){
	$count++;
	$output .= '
	<tr>
	<td align="left">'.$count.'</td>
	<td align="left">'.$invoiceItem["item_code"].'</td>
	<td align="left">'.$invoiceItem["item_name"].'</td>
	<td align="left">'.$invoiceItem["order_item_quantity"].'</td>
	<td align="left">'.$invoiceItem["order_item_price"].'</td>
	<td align="left">'.$invoiceItem["order_item_final_amount"].'</td>   
	</tr>';
}
$output .= '
	<tr>
	<td align="right" colspan="5">Sub Total</td>
	<td align="left">'.$invoiceValues['amountOffered'].'</td>
	</tr>
	
	
	<tr>
	<td align="right" colspan="5"><b>ആകെ തുക: </b></td>
	<td align="left"><b>'.$invoiceValues['amountOffered'].'</b></td>
	</tr>
	<tr>
	<td align="right" colspan="5">നൽകിയ തുക:</td>
	<td align="left">'.$invoiceValues['amountReceived'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>കുടിശ്ശിക തുക:</b></td>
	<td align="left">'.$invoiceValues['amountPending'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>Status:</b></td>
	<td align="left">'.$invoiceValues['status'].'</td>
	</tr>';
$output .= '
	</table>
	</td>
	</tr>
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">ക്രമ നമ്പർ</th>
	<th align="left">ID.</th>
	<th align="left">രശീതി നമ്പർ</th>
	<th align="left">പരിപാടി</th>
	<th align="left">തീയതി</th>
	<th align="left">തുക</th>
	</tr>';
	$count = 0;
							
							foreach($paymentDetails as $paymentDetail){
								$count++;
								$output .= '
								<tr>
								<td align="left">'.$count.'</td>
								<td align="left">'.$paymentDetail['id'].'</td>
								<td align="left">'.$paymentDetail['sambhavanaId'].'</td>
								<td align="left">'.$paymentDetail['eventName'].'</td>
								<td align="left">'.date("d-m-Y", strtotime($paymentDetail['updated_at'])).'</td>
								<td align="left">'.$paymentDetail['amount'].'</td>   
								</tr>';


							}

	
							$output .= '
	</table>
	<p class="right">സെക്രട്ടറി</p>
	<button id="print" onclick="printInvoice()">Print Invoice</button>
	<button id="print" onclick="goBack()">Go Back</button>
	</body>
	</html>
	
	
	'
	
	;
	
	echo $output;
	
}
?>   
   <script>
        function printInvoice() {
            window.print();
        }
		function goBack() {
            window.history.back();
        }
    </script>

	<?php
  }
  ?>