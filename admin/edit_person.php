<?php 
ob_start();
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
if(!empty($_POST['firstName']) && $_POST['mobileNumber']) {	
	$invoice->updatePerson($_POST);
	header("Location:dashboard.php");
}
if(!empty($_GET['update_id']) && $_GET['update_id']) {
	$personDetails = $invoice->getPerson($_GET['update_id']);		
	//$invoiceItems = $invoice->getInvoiceItems($_GET['update_id']);	
		
}
?>

<script src="js/invoice.js"></script>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Edit Person Data</title>
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
  <h1>Update Person Details</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
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
		  <h5 class="card-title">Update Person</h5>

		
	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Update Details</h5>
		   <!-- Floating Labels Form -->
		  <!-- <form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">  -->
			<!-- Floating Labels Form -->
			
			<form class="row g-3" action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control" value="<?php echo $personDetails['fname']; ?>" id="firstName" name="firstName" placeholder="First Name">
                    <input type="hidden" value="<?php echo $personDetails['keyu']; ?>" class="form-control" name="personId" id="personId">
					<label for="firstName">First Name</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="middleName" value="<?php echo $personDetails['sname']; ?>" name="middleName" placeholder="Middle Name">
                    <label for="middleName">Middle Name</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                  <input type="text" class="form-control" id="lastName" value="<?php echo $personDetails['lname']; ?>" name="lastName" placeholder="Last Name">
                    <label for="lastName">Last Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <select class="form-select" id="gender" name="gender"  aria-label="Gender">
					<option value="<?php echo $personDetails['Gender'];?>" hidden><?php echo $personDetails['Gender'];?></option>
					  <option value="Nil">Nil</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                    <label for="gender">Gender</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                  <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $personDetails['Birthday']; ?>" placeholder="Date of Birth">
                    <label for="dob">Date of Birth</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                  <input type="text" class="form-control" id="houseNumber" value="<?php echo $personDetails['housenumber']; ?>" name="houseNumber" placeholder="House Number">
                    <label for="houseNumber">House Number</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-6">
                    <select class="form-select" id="zone" name="zone" aria-label="Zone">
					<option value="<?php echo $personDetails['zone'];?>" hidden><?php echo $personDetails['zone'];?></option>
                      <option value="0">None</option>
                      <option value="Z-1">Z-1</option>
                      <option value="Z-2">Z-2</option>
                      <option value="Z-3">Z-3</option>
                      <option value="Z-4">Z-4</option>
                      <option value="Z-5">Z-5</option>
                      <option value="Z-6">Z-6</option>
                    </select>
                    <label for="zone">Zone</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="House Name" name="houseName"  id="houseName" style="height: 100px;"><?php echo $personDetails['housename']; ?></textarea>
                    <label for="houseName">House Name</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="col-md-12">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="mobileNumber" id="mobileNumber" value="<?php echo $personDetails['mobile']; ?>" placeholder="Mobile Number">
                      <label for="mobileNumber">Mobile Number</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                  <div class="form-floating">
                      <input type="email" class="form-control" name="email" id="email" value="<?php echo $personDetails['email']; ?>" placeholder="Email">
                    <label for="email">Email</label>
                  </div>
                </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="password" class="form-control" name="password" id="password" value="<?php echo $personDetails['password']; ?>" placeholder="Password">
                    <label for="password">Password</label>
                  </div>
                </div>
                
                <div class="text-center">
                  
                  <input type="submit" value="Submit" name="invoice_btn" value="Save Person" class="btn btn-success submit_btn invoice-save-btm">
                  <button type="reset" class="btn btn-secondary">Reset</button>
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

<?php include('inc/footer.php');
}?>