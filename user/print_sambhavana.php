<?php
session_start();
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

$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceValues['date']));
$output = '';
$output .= '
<html>
<head>
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
	<b>RECEIVER (BILL TO)</b><br />
	Name : '.$invoiceValues['name'].'<br /> 
	House Number : '.$invoiceValues['houseNumber'].'<br />
	Zone : '.$invoiceValues['zone'].'<br />
	</td>
	<td width="35%">         
	Invoice No. : '.$invoiceValues['sambhavanaId'].'<br />
	Last Updated Date : '.$invoiceDate.'<br />
	</td>
	</tr>
	</table>
	<br />
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">Sr No.</th>
	<th align="left">Item Code</th>
	<th align="left">Item Name</th>
	<th align="left">Quantity</th>
	<th align="left">Price</th>
	<th align="left">Actual Amt.</th> 
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
	<td align="right" colspan="5"><b>Sub Total</b></td>
	<td align="left"><b>'.$invoiceValues['amountOffered'].'</b></td>
	</tr>
	
	
	<tr>
	<td align="right" colspan="5">Total: </td>
	<td align="left">'.$invoiceValues['amountOffered'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Amount Paid:</td>
	<td align="left">'.$invoiceValues['amountReceived'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>Amount Due:</b></td>
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
	<th align="left">Sr No.</th>
	<th align="left">ID.</th>
	<th align="left">Receipt No.</th>
	<th align="left">Event</th>
	<th align="left">Date</th>
	<th align="left">Amount</th>
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
								<td align="left">'.$paymentDetail['updated_at'].'</td>
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