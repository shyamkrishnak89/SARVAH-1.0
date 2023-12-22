<?php 
// ob_start();
session_start();
if(!isset($_SESSION['username'])) 
  {
    echo 'Session variable not set.';
    header("Location:index.php");
  }
  else{
include('../inc/header.php');
include 'Invoice.php';
$invoice = new Invoice();

$invoice->checkLoggedIn();
if(!empty($_POST['eventName']) && $_POST['zone']&& $_POST['houseNumber']&& $_POST['totalAftertax']&& $_POST['amountPaid']) {	
	$invoice->updateSambhavanaInvoice($_POST);
	
	header("Location:create_sambhavana.php");	
}
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	$invoiceValues = $invoice->getSambhavanaInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getSambhavanaByID($_GET['invoice_id']);	
	$eventID = $invoiceValues['eventId'];
	$eventName = $invoiceValues['eventName'];
	$zone = $invoiceValues['zone'];
	$houseNumber = $invoiceValues['houseNumber'];
	$paymentDetails = $invoice->getSambhavanaPaymentStatus($_GET['invoice_id'],$eventID);	
		
}
?>

<script src="js/invoice.js"></script>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>View Sambhavana Invoice</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link rel="stylesheet" href="vendor_css.css">
</head>

<?php 
$itemList = $invoice->getItems();
$items_json = json_encode($itemList);

echo "
<script>
var items_array = $items_json;
console.log(items_array[0].itemid);
</script>";
foreach($itemList as $itemDetails){

			
	echo '
	  <tr>
		<td>'.$itemDetails["itemid"].'</td>
		<td>'.$itemDetails["itemname"].'</td>
		<td>'.$itemDetails["itemrate"].'</td>
		
	  </tr>
	';
} 

?>
<body>
<!-- ======= Header & Sidebar ======= -->
<?php
    include 'header.php';
    include 'sidebar.php';
  ?>
  <!-- ======= Header & Sidebar Ends ======= -->

<main id="main" class="main">

<div class="pagetitle">
  <h1>View Sambhavana Invoice</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
	  <li class="breadcrumb-item">Forms</li>
	  <li class="breadcrumb-item active">Layouts</li>
	</ol>
  </nav>
</div><!-- End Page Title -->
<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Update Invoice</h5>

		
	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Update Details</h5>
		   <!-- Floating Labels Form -->
		  <!-- <form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">  -->
		  <form class="row g-3" action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="text" value="<?php echo $invoiceValues['eventName']; ?>" class="form-control" id="eventName" name="eventName" placeholder="Event Name" autocomplete="off" readonly>
				<label for="eventName">Event</label>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="form-floating">
				<input type="text" value="<?php echo $invoiceValues['zone']; ?>" class="form-control" id="zone" name="zone" placeholder="Zone" autocomplete="off" readonly>
				<label for="zone">Zone</label>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="form-floating">
				<input type="text" value="<?php echo $invoiceValues['houseNumber']; ?>" class="form-control" id="houseNumber" name="houseNumber" placeholder="houseNumber" autocomplete="off" readonly>
				<label for="houseNumber">House #</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="text" value="<?php echo $invoiceValues['name']; ?>" class="form-control" id="name" name="name" placeholder="Devotee Name" readonly>
				<label for="name">Name of member</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="text" value="<?php echo $invoiceValues['sambhavanaId']; ?>" class="form-control" id="receiptnumber" name="receiptnumber" placeholder="Receipt Number" readonly>
				<label for="receiptnumber">Receipt Number</label>
			  </div>
			</div>

			<div class="col-12">
			<table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>
                <tbody>
				<?php 
							$count = 0;
							foreach($invoiceItems as $invoiceItem){
								$count++;
							?>		
                  <tr>
					
				  <td><?php echo $invoiceItem["item_code"]; ?></td>
							
							<td><?php echo $invoiceItem["item_name"]; ?></td>			
							<td><?php echo $invoiceItem["order_item_quantity"]; ?></td>
							<td><?php echo $invoiceItem["order_item_price"]; ?></td>
							<td><?php echo $invoiceItem["order_item_final_amount"]; ?></td>
							<input type="hidden" value="<?php echo $invoiceItem['order_item_id']; ?>" class="form-control" name="itemId[]">
						</tr>
						<?php } ?>	
						<tr>
						<td colspan="4" ALIGN=RIGHT>Total Offering: </td>
						<td><b>Rs. <?php echo $invoiceValues["amountOffered"]; ?></b></td>	
						</tr>
						<tr>
						<td colspan="4" ALIGN=RIGHT>Amount Paid: </td>
						<td><b>Rs. <?php echo $invoiceValues["amountReceived"]; ?></b></td>	
						</tr>
						<tr>
						<td colspan="4" ALIGN=RIGHT>Due Amount: </td>
						<td><b>Rs. <?php echo $invoiceValues["amountPending"]; ?></b></td>	
						</tr>
                </tbody>
              </table>
				<div class="form-floating">
				
				</div>
				<div class="row">
				
			</div>
			</div>
			<div class="col-12">
				Notes: <?php echo $invoiceValues['note']; ?>
				<p style="text-align:center"><b>Payment Details</b></p>
				<table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Receipt Number</th>
                    <th scope="col">Event</th>
                    <th scope="col">Date</th>
                    <th scope="col">Amount</th>
                  </tr>
                </thead>
                <tbody>
				<?php 
							$count = 0;
							
							foreach($paymentDetails as $paymentDetail){
								$count++;
							?>		
                  <tr>
					
				  <td><?php echo $paymentDetail['id']; ?></td>
							
							<td><?php echo $paymentDetail['sambhavanaId']; ?></td>			
							<td><?php echo $paymentDetail['eventName']; ?></td>
							<td><?php echo $paymentDetail['updated_at']; ?></td>
							<td><?php echo $paymentDetail['amount']; ?></td>
							
						</tr>
						<?php } ?>	
						<tr>
						<td colspan="4" ALIGN=RIGHT>Total Offering: </td>
						<td><b>Rs. <?php echo $invoiceValues["amountOffered"]; ?></b></td>	
						</tr>
						<tr>
						<td colspan="4" ALIGN=RIGHT>Amount Paid: </td>
						<td><b>Rs. <?php echo $invoiceValues["amountReceived"]; ?></b></td>	
						</tr>
						<tr>
						<td colspan="4" ALIGN=RIGHT>Due Amount: </td>
						<td><b>Rs. <?php echo $invoiceValues["amountPending"]; ?></b></td>	
						</tr>
                </tbody>
              </table>
			</div>
			
			<div class="col-md-12">
				<div class="form-floating">
				 
				  <input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
				  <input type="hidden" value="<?php echo $invoiceValues['eventId']; ?>" class="form-control" name="eventid" id="eventid">
				</div>
			  </div>
			</div>
			<div class="col-md-12">
				<div class="form-floating">
				  <input type="text" class="form-control" id="lastUpdated" placeholder="lastUpdated" value="<?php echo $invoiceValues['date']; ?>" readonly>
				  <label for="lastUpdated">Last Updated On</label>
				  
				</div>
			  </div>
			</div>
			
			<div class="text-center">
			<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
			
			<input type="hidden" value="<?php echo $invoiceValues['sambhavanaId']; ?>" class="form-control" name="invoiceId" id="invoiceId">
			<input data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" value="Save Invoice" class="btn btn-success submit_btn invoice-save-btm">			
			  <button type="reset" class="btn btn-danger">Reset</button>
			</div>
		  </form><!-- End floating Labels Form -->

		</div>
	  </div>

	</div>
  </div>
</section>

</main><!-- End #main -->
 <!-- ======= Footer ======= -->
 <?php
  include 'footer.php';
  ?>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>
<script>
$(document).on('blur', "[id^=productCode_]", function(){
	var count = $(".itemRow").length;
	console.log("Count:"+count);
	var itemid1 = $(this).val();
	console.log("ItemID:"+itemid1);
	// var index = items_array.findIndex(x=>x.itemid === itemid);
	// console.log("Index:"+index);
	var i=0;
	var arr_len = items_array.length;
	console.log("Length: "+arr_len);
	
	
	console.log(items_array);
	// for(i=0;i<items_array.length;i++){
	//  	if(items_array.find(items_array => items_array[i].itemid === itemid)){
	//  		console.log("FOUND!!!";)
	//  	}

	//  }
	var index_pos = 0;
	var itemname1 = 'NOT FOUND!!!';
	
	var itemrate1 = 0;
	
	const lastArray = [{ itemid: "999", itemname: "NOT FOUND", itemrate: "0",  }];
	let itemFound = false; // Flag to track if the item is found

	items_array.forEach((element, index, array) => {
		if(element.itemid == itemid1){
			console.log("FOUND!!!");
			itemFound = true; // Set the flag to true when item is found
			itemname1 = element.itemname;
			itemrate1 = element.itemrate;
			$('#productCode_'+count).val(element.itemid);
			$('#productName_'+count).val(itemname1);
			$('#price_'+count).val(itemrate1);
			$('#quantity_'+count).val(1);

			
			index_pos = index;
			
		}
		
		
    // console.log(element.itemid); // 100, 200, 300
    // console.log(index); // 0, 1, 2
    // console.log(array); // same myArray object 3 times
});
if (!itemFound) {
    console.log("NOT FOUND!!!");
	$('#productName_'+count).val(itemname1);
    // Handle the case when the item is not found
} 
	// var itemname = items_array[index_pos].itemname;
	// console.log("ItemName:"+itemname1);
	// var itemrate = items_array[index_pos].itemrate;
	
	});	

</script>
<?php include('inc/footer.php');
}
?>