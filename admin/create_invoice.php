<?php 

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
	$invoice->saveInvoice($_POST);
	header("Location:create_invoice.php");	
}
?>


<!-- <link href="css/style.css" rel="stylesheet"> -->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Add Vazhipadu | SARVAH</title>
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
  <h1>Make Vazhipadu</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
	  <li class="breadcrumb-item">Nithyanidhanam</li>
	  <li class="breadcrumb-item active">Create Vazhipadu</li>
	</ol>
  </nav>
</div><!-- End Page Title -->
<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Add Vazhipadu</h5>

		
	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Fill Details</h5>

		  <!-- Floating Labels Form -->
		  <!-- <form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">  -->
		  <form class="row g-3" action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="text" class="form-control" id="devoteeName" name="devoteeName" placeholder="Devotee Name" autocomplete="off">
				<label for="devoteeName">Enter Devotee Name</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="text" class="form-control" id="devoteeStar" name="devoteeStar" placeholder="Devotee Star">
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
						<tr>
							<td><input class="itemRow" type="checkbox"></td>
							<td><input type="text" name="productCode[]" id="productCode_1" class="form-control" autocomplete="off"></td>
							<td><input type="text" name="productName[]" id="productName_1" class="form-control" autocomplete="off" readonly></td>			
							<td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
							<td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off" readonly></td>
							<td><input type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off" readonly></td>
						</tr>						
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
				<textarea class="form-control" id="floatingNotes" name="floatingNotes" placeholder="floatingNotes" style="height: 100px;"></textarea>
				<label for="floatingNotes">Add Notes:</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="text" class="form-control" id="subTotal" name="subTotal" placeholder="Sub Total" readonly>
				<label for="subTotal">Sub Total</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="text" class="form-control" id="totalAftertax" name="totalAftertax" placeholder="Total" readonly>
				<label for="totalAftertax">Total</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="text" class="form-control" id="amountPaid" name="amountPaid" placeholder="Amount paid" >
				<label for="amountPaid">Amount Paid</label>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="form-floating">
				<input type="text" class="form-control" name="amountDue" id="amountDue" placeholder="Amount Due" readonly>
				<label for="amountDue">Amount Due</label>
			  </div>
			</div>
			<div class="col-md-12">
				<div class="form-floating">
				  <input type="text" class="form-control" id="floatingPhone" placeholder="Mobile Number">
				  <label for="floatingPhone">Mobile Number</label>
				  <input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
					<input type="hidden" value="0" class="form-control" name="previousPayment" id="previousPayment">
				</div>
			  </div>
			</div>
			
			<div class="text-center">
			
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
$(document).on('blur', "[id^=productCode_]", function(event){
	
	var count = $(".itemRow").length;
	console.log("Count:"+count);
	var itemid1 = $(this).val();
	console.log("ItemID:"+itemid1);
	var i=0;
	var arr_len = items_array.length;
	var selectedInputId = event.target.id;
    console.log("Selected Input ID: " + selectedInputId);
	var selectedId = selectedInputId.substr(12);
	console.log("Sliced ID: "+selectedId);
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
			$('#productCode_'+selectedId).val(element.itemid);
			$('#productName_'+selectedId).val(itemname1);
			$('#price_'+selectedId).val(itemrate1);
			$('#quantity_'+selectedId).val(1);
			
			index_pos = index;
			
		}
		
	});
if (!itemFound) {
    console.log("NOT FOUND!!!");
	$('#productName_'+selectedId).val(itemname1);
	$('#quantity_'+selectedId).val(0);
	$('#price_'+selectedId).val(0);
	$('#total_'+selectedId).val(0);
    } 
	
	$("[id^='price_']").attr("readonly","readonly") ;
	$("[id^='total_']").attr("readonly","readonly") ;
	$("[id^='productName_']").attr("readonly","readonly") ;
	calculateTotal();
	});	

</script>
<?php include('inc/footer.php');
}?>