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
if(!empty($_POST['devoteeName']) && $_POST['devoteeStar']&& $_POST['totalAftertax']) {	
	$invoice->updateInvoice($_POST);
	
	header("Location:create_invoice.php");	
}
if(!empty($_GET['update_id']) && $_GET['update_id']) {
	$invoiceValues = $invoice->getInvoice($_GET['update_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['update_id']);	
		
}
?>

<script src="js/invoice.js"></script>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Edit Vazhipadu | SARVAH</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
  <h1>Edit Invoice</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
	  <li class="breadcrumb-item">Nithyanidhanam</li>
	  <li class="breadcrumb-item">Vazhipadu</li>
	  <li class="breadcrumb-item active">Edit Vazhipadu</li>
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
				<input type="text" value="<?php echo $invoiceValues['order_receiver_name']; ?>" class="form-control" id="devoteeName" name="devoteeName" placeholder="Devotee Name" autocomplete="off" required>
				<label for="devoteeName">Enter Devotee Name</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="text" value="<?php echo $invoiceValues['order_receiver_address']; ?>" class="form-control" id="devoteeStar" name="devoteeStar" placeholder="Devotee Star" required>
				<label for="devoteeStar">Enter Devotee Star</label>
			  </div>
			</div>

			<div class="col-12">
				<div class="form-floating">
				<table class="table table-bordered table-hover" id="invoiceItem">	
						<tr>
							<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
							<th width="15%">Item No</th>
							<th width="38%">Item Name</th>
							<th width="15%">Quantity</th>
							<th width="15%">Price</th>								
							<th width="15%">Total</th>
						</tr>	
						<?php 
							$count = 0;
							foreach($invoiceItems as $invoiceItem){
								$count++;
							?>									
						<tr>
							<td><input class="itemRow" type="checkbox"></td>
							<td><input type="text" value="<?php echo $invoiceItem["item_code"]; ?>"  name="productCode[]" id="productCode_1" class="form-control" autocomplete="off"></td>
							<td><input type="text" value="<?php echo $invoiceItem["item_name"]; ?>" name="productName[]" id="productName_1" class="form-control" autocomplete="off" readonly></td>			
							<td><input type="number" value="<?php echo $invoiceItem["order_item_quantity"]; ?>" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
							<td><input type="number" value="<?php echo $invoiceItem["order_item_price"]; ?>" name="price[]" id="price_1" class="form-control price" autocomplete="off" readonly></td>
							<td><input type="number" value="<?php echo $invoiceItem["order_item_final_amount"]; ?>" name="total[]" id="total_1" class="form-control total" autocomplete="off" readonly></td>
							<input type="hidden" value="<?php echo $invoiceItem['order_item_id']; ?>" class="form-control" name="itemId[]">
						</tr>
						<?php } ?>					
					</table>
				</div>
				<div class="row">
				<div class="text-center">
					<button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
					<button class="btn btn-success" id="addRows" type="button">+ Add More</button>
				</div>
			</div>
			</div>
			<div class="col-12">
				<div class="form-floating">
				<textarea class="form-control" id="floatingNotes" name="floatingNotes" placeholder="floatingNotes" style="height: 100px;"><?php echo $invoiceValues['note']; ?></textarea>
				<label for="floatingNotes">Add Notes:</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="number" value="<?php echo $invoiceValues['order_total_before_tax']; ?>" class="form-control" id="subTotal" name="subTotal" placeholder="Sub Total" readonly>
				<label for="subTotal">Sub Total</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="number" value="<?php echo $invoiceValues['order_total_after_tax']; ?>" class="form-control" id="totalAftertax" name="totalAftertax" placeholder="Total" readonly>
				<label for="totalAftertax">Total</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="text" value="<?php echo $invoiceValues['order_amount_paid']; ?>" class="form-control" id="previousPayment" name="previousPayment" placeholder="Previous Payment"readonly >
				<label for="previousPayment">Previous Payment</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="number"  class="form-control" id="amountPaid" name="amountPaid" placeholder="Amount paid" >
				<label for="amountPaid">Amount Paying</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="number" value="<?php echo $invoiceValues['order_total_amount_due']; ?>"  class="form-control" name="amountDue" id="amountDue" placeholder="Amount Due" readonly>
				<label for="amountDue">Amount Due</label>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="form-floating">
				<input type="number"  class="form-control" id="latestAmount" name="latestAmount" placeholder="latestAmount" >
				<label for="latestAmount">Amount Paid Till Now</label>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="form-floating">
				<input type="number" value="<?php echo $invoiceValues['order_id']; ?>" class="form-control" id="invoiceId" name="invoiceId" placeholder="invoiceId" readonly >
				<label for="invoiceId">Invoice ID</label>
			  </div>
			</div>
			<div class="col-md-12">
				<div class="form-floating">
				  <input type="text" class="form-control" id="floatingPhone" placeholder="Mobile Number">
				  <label for="floatingPhone">Mobile Number</label>
				  <input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
				  <input type="hidden" value="<?php echo $invoiceValues['order_id']; ?>" class="form-control" name="invoiceId" id="invoiceId">
				</div>
			  </div>
			</div>
			
			<div class="text-center">
			<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
			
			<!-- <input type="hidden" class="form-control" name="latest_amount" id="latest_amount"> -->
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
	$('#quantity_'+selectedId).val(0);
	$('#price_'+selectedId).val(0);
	$('#total_'+selectedId).val(0);
    // Handle the case when the item is not found
} 
	// var itemname = items_array[index_pos].itemname;
	// console.log("ItemName:"+itemname1);
	// var itemrate = items_array[index_pos].itemrate;
	
	});	

</script>
<?php include('inc/footer.php');
}?>