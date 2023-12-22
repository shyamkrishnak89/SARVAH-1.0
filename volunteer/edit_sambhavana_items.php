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
if(!empty($_GET['update_id']) && $_GET['update_id']) {
	$item = $invoice->getSambhavanaItemsByID($_GET['update_id']);		
}
if(!empty($_POST['itemName']) && $_POST['rate']) {	
	$invoice->updateSambhavanaItemByID($_POST);
	header("Location:add_sambhavana_items.php");
}
?>

<script src="js/invoice.js"></script>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Edit Sambhavana Items</title>
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
<body>
	  <!-- ======= Header & Sidebar ======= -->
	  <?php
    include 'header.php';
    include 'sidebar.php';
  ?>
  <!-- ======= Header & Sidebar Ends ======= -->
<main id="main" class="main">

<div class="pagetitle">
  <h1>Update Sambhavana Items</h1>
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
		  <h5 class="card-title">Edit Sambhavana Items</h5>

		
	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Enter Item Details</h5>
      <!-- Floating Labels Form -->
      <form class="row g-3" action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" value = "<?php echo $item['itemname'];  ?> " id="itemName" name="itemName" placeholder="Item Name">
                    <label for="itemName">Item Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" value = "<?php echo $item['itemrate'];  ?> " id="rate" name="rate" placeholder="Rate">
                    <label for="rate">Rate</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Item Description" value = "<?php echo $item['itemdesc'];  ?> " name="itemDescription" id="itemDescription" style="height: 100px;"></textarea>
                    <label for="itemDescription">Item Description</label>
                  </div>
                </div>
                
                <div class="text-center">
                <input type="hidden" value="<?php echo $item['itemid']; ?>" class="form-control" name="itemid">
                  <input type="submit" value="Submit" name="invoice_btn" value="Save Item" class="btn btn-success submit_btn invoice-save-btm">
                  <button type="reset" class="btn btn-danger">Reset</button>
                </div>
              </form><!-- End floating Labels Form -->

            </div>
          </div>

        </div>
      </div>
    </section>



  <section class="section">
  <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Sambhavana Items List</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable table-hover">
                <thead>
                  <tr>
                  <th>Item ID.</th>
                  <th>Item Name</th>
                  <th>Rate</th>
                  <th>Description</th>
                  <th>Edit</th>
                  <th>Delete</th>
                  </tr>
                </thead>
                
                <tbody>
                <?php		
                    $itemList = $invoice->getSambhavanaItems();
                    foreach($itemList as $itemDetails){
			
                      echo '
                      <tr>
                        <td>'.$itemDetails["itemid"].'</td>
                        <td>'.$itemDetails["itemname"].'</td>
                        <td>'.$itemDetails["itemrate"].'</td>
                        <td>'.$itemDetails["itemdesc"].'</td>
                        <td><a href="edit_sambhavana_items.php?update_id='.$itemDetails["itemid"].'"  title="Edit Item"><span class="bi bi-pencil-square"></span></a></td>
                        <td><a href="#" id="'.$itemDetails["itemid"].'" class="deleteInvoice"  title="Delete Item"><span class="bi bi-trash"></span></a></td>
                      </tr>
                    ';
                }       
                
        ?>
                  
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

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

<?php
  }
  ?>
