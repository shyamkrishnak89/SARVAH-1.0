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
$invoiceList = "";
// if(!empty($_POST['event']) && $_POST['status']) {	
 
// 	 header("Location:search.php");
// }
?>

<script src="js/invoice.js"></script>
<!-- <link href="css/style.css" rel="stylesheet"> -->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Search Sambhavana | SARVAH</title>
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

<body>
  <!-- ======= Header & Sidebar ======= -->
  <?php
    include 'header.php';
    include 'sidebar.php';
  ?>
  <!-- ======= Header & Sidebar Ends ======= -->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>View Sambhavana</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">View Sambhavana</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Search Sambhavana</h5>

		
	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Search By</h5>
      <?php
      $eventsList = $invoice->getEvents();
      $events_json = json_encode($eventsList);

      ?>
      <!-- Floating Labels Form -->
      <form class="row g-3" action="search_sambhavana.php" id="invoice-form" method="post" action="search.php" class="invoice-form" role="form" novalidate="">
                <div class="col-md-4">
                <div class="form-floating mb-4">
                    <select class="form-select" id="event" name="event" aria-label="Event" required>
					<option value="">Select Event</option>
					<?php
						
						foreach($eventsList as $eventDetails){
						echo '
							  <option value="'.$eventDetails["Title"].'">'.$eventDetails["Title"].'</option>
							  						  
							';
						} 
						?>	
                    </select>
                    <label for="event">Select Event</label>
                  </div>
                </div>	
                
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="date" class="form-control" id="date" name="date" placeholder="Invoice date">
                    <label for="date">Invoice Date</label>
                  </div>
                </div>
                
                <div class="col-md-4">
                <div class="form-floating">
                  <input type="text" class="form-control" id="houseNumber" name="houseNumber" placeholder="houseNumber">
                  <label for="houseNumber">House Number</label>
              </div>
			        </div>
              <div class="col-md-4">
                <div class="form-floating">
                  <input type="text" class="form-control" id="sambhavanaId" name="sambhavanaId" placeholder="sambhavanaId">
                  <label for="sambhavanaId">Invoice Number</label>
              </div>
			        </div>
              <div class="col-md-4">
                  <div class="form-floating md-4">
                  <select class="form-select" id="status" name="status" aria-label="Status" required>
                                            <option value="">Select Status</option>
                                            <option value="Paid">Paid</option>
                                            <option value="UnPaid">UnPaid</option>
                                            <option value="Partial">Partial</option>
                                            <option value="Bonus">Bonus</option>

                                        </select> 


                    <label for="status">Status</label>
                  </div>
                </div>
                
                
                <div class="text-center">
                  
                  <input type="submit" value="Search" name="invoice_btn"  class="btn btn-success submit_btn invoice-save-btm">
                  <button type="reset" class="btn btn-danger">Reset</button>
                </div>
              </form><!-- End floating Labels Form -->

            </div>
          </div>

        </div>
      </div>
    </section>

<!-- Display search results here -->
<?php
    // Display search results if available
    if (isset($_POST['event']) && isset($_POST['status'])) {
        include("search.php");
    }
    ?>




    

  </main><!-- End #main -->
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










