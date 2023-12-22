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
if(!empty($_POST['firstName']) && $_POST['lastName']&& $_POST['type']) {
	
	
	$invoice->saveUser($_POST);
	header("Location:add_user.php");
}
?>

<script src="js/invoice.js"></script>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Add User</title>
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
  <h1>Add User</h1>
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
		  <h5 class="card-title">Add User</h5>

		
	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Fill Details</h5>



      <!-- Floating Labels Form -->
      <form class="row g-3" action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
                    <label for="firstName">First Name</label>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-floating">
                  <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
                    <label for="lastName">Last Name</label>
                  </div>
                </div>
				
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <select class="form-select" id="type" name="type" aria-label="Type">
                      <option value="Staff">Staff</option>
                      <option value="Volunteer">Volunteer</option>
                      <option value="Admin">Admin</option>
					  <option value="Super Admin">Super Admin</option>
                    </select>
                    <label for="type">User Type</label>
                  </div>
                </div>
                
                
                
                
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-floating">
                      <input type="text" class="form-control" name="mobileNumber" id="mobileNumber" placeholder="Mobile Number">
                      <label for="mobileNumber">Mobile Number</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                  <div class="form-floating">
                      <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    <label for="email">Email</label>
                  </div>
                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <label for="password">Password</label>
                  </div>
                </div>
				<div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Address" name="address" id="address" style="height: 100px;"></textarea>
                    <label for="address">Address</label>
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



  <section class="section">
  <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">User List</h5>
              <!-- Table with stripped rows -->
              <table class="table datatable table-hover">
                <thead>
                  <tr>
                  <th>ID</th>
                  <th>User Name</th>
                 
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Mobile Number</th>
                  <th>Type</th>
                  
				          <th>Address</th>
                  <th>Edit</th>
                  <th>Delete</th>
                  </tr>
                </thead>
                
                <tbody>
                <?php		
            $memberList = $invoice->getUsers();
                foreach($memberList as $memberDetails){
			
            echo '
              <tr>
                <td>'.$memberDetails["id"].'</td>
                <td>'.$memberDetails["username"].'</td>
                <td>'.$memberDetails["first_name"].'</td>
				        <td>'.$memberDetails["last_name"].'</td>
                <td>'.$memberDetails["mobile"].'</td>
                <td>'.$memberDetails["type"].'</td>
                <td>'.$memberDetails["address"].'</td>
                <td><a href="edit_people.php?update_id='.$memberDetails["id"].'"  title="Edit Person"><span class="bi bi-pencil-square"></span></a></td>
                <td><a href="#" id="'.$memberDetails["id"].'" class="deleteInvoice"  title="Delete Person"><span class="bi bi-trash"></span></a></td>
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