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
if(!empty($_POST['firstName']) && $_POST['mobileNumber']) {	
	$invoice->saveMember($_POST);
	header("Location:add_people.php");
}
?>

<script src="js/invoice.js"></script>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>View All People</title>
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
  <h1>View People</h1>
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
              <h5 class="card-title">Peoples List</h5>
              <p>Generated on:<?php echo date("d-m-Y") ; ?> at <?php date_default_timezone_set("Asia/Calcutta"); echo  date("h:i:sA");?> </p>
              <a href="print_people_list.php" class="btn btn-info" id="print" data-placement="left" title="Click to Print"><i class="icon-print icon-large"></i> Print List</a>
              <button name="create_excel" id="create_excel" class="btn btn-success">Create Excel File</button>
              <!-- Table with stripped rows -->
              <table class="table datatable table-hover">
                <thead>
                  <tr>
                  <th>Sl. No</th>
                  <th>Zone</th>
                  <th>House Number</th>
                  <th>Name</th>
                  <th>House Name</th>
                  <th>Gender</th>
                  <th>Mobile Number</th>
                  <th>View</th>
                  <th>Edit</th>
                  <th>Delete</th>
                  </tr>
                </thead>
                
                <tbody>
                <?php		
            $memberList = $invoice->getMembers();
                foreach($memberList as $memberDetails){
			
            echo '
              <tr>
                <td>'.$memberDetails["keyu"].'</td>
                <td>'.$memberDetails["zone"].'</td>
                <td>'.$memberDetails["housenumber"].'</td>
				        <td>'.$memberDetails["fname"]." ".$memberDetails["sname"]." ".$memberDetails["lname"].'</td>
                <td>'.$memberDetails["housename"].'</td>
                <td>'.$memberDetails["Gender"].'</td>
                <td>'.$memberDetails["mobile"].'</td>
                <td><a href="view_one_person.php?person_id='.$memberDetails["keyu"].'" title="View Person"><span class="bi bi-eye"></span></a>
                <td><a href="edit_person.php?update_id='.$memberDetails["keyu"].'"  title="Edit Person"><span class="bi bi-pencil-square"></span></a></td>
                <td><a href="#" id="'.$memberDetails["keyu"].'" class="deleteInvoice"  title="Delete Person"><span class="bi bi-trash"></span></a></td>
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