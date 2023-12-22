<!DOCTYPE html>
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

$itemList = $invoice->getItemsByTypeAndCount();
$announcementList = $invoice->getAnnouncements();
// $incomeList = $invoice->getDailyIncome();
$income_data = [];
$amounts = array();
$dates = array();
$expenses = array();
$edates = array();
$balance = array();
$flag=0;
$thisMonthRevenue = array();
$thisMonthRevenue = $invoice->getThisMonthRevenue();
$numOfMembers = $invoice->getNumOfMembers();
$todaysRevenue = $invoice -> getTodaysRevenue();




// if ($incomeList && mysqli_num_rows($incomeList) > 0) {
//   $flag = 1;
//   while($row = $incomeList->fetch_assoc()) {
//       $amounts[] = $row["amount"];
      
//   }
// } else {
//   echo "0 results found";
//   $flag =0;
// }

// echo $amountList;

$data = [];
foreach ($itemList as $itemDetails) {
  $data[] = [
      "value" => $itemDetails["item_count"],
      "name" => $itemDetails["item_name"]
  ];
}


?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard | SARVAH</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link rel="stylesheet" href="vendor_css.css">



  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">താങ്കളുടെ സംഭാവനകൾ <span>| വീട് നമ്പർ: <?php echo $_SESSION['username'];  ?></span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">തിയ്യതി</th>
                        <th scope="col">പരിപാടി</th>
                        <th scope="col">എഴുതിയ തുക </th>
                        <th scope="col">നൽകിയത്</th>
                        <th scope="col">ബാക്കി</th>
                        <th scope="col">സ്റ്റാറ്റസ് </th>
                        <th scope="col">രശീതി</th>
                        <th scope="col">പ്രിന്റ് </th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php		
                    $houseNumber = $_SESSION['username'];
		              $invoiceList = $invoice->getSambhavanaListByUser($houseNumber);
                  foreach($invoiceList as $invoiceDetails){
                  $invoiceDate = date("d-m-Y, H:i:s", strtotime($invoiceDetails["date"]));
                  $stat = $invoiceDetails["status"];
                  $status = "";
                  if($stat=="Paid"){
                    $status = "<span class= 'badge bg-success'>Paid</span>";
                  }
                  else if($stat=="Unpaid"){
                    $status = "<span class= 'badge bg-danger'>UnPaid</span>";
                  }
                  else if($stat=="Partial"){
                    $status = "<span class= 'badge bg-warning'>Partial</span>";
                  }
                  else{
                    $status = "<span class= 'badge bg-info'>Bonus</span>";
                  }
                  echo '
                  <tr>
                  <td>'.$invoiceDetails["sambhavanaId"].'</td>
                  <td>'.$invoiceDate.'</td>
                  <td>'.$invoiceDetails["eventName"].'</td>
                  <td>'.$invoiceDetails["amountOffered"].'</td>
                  <td>'.$invoiceDetails["amountReceived"].'</td>
                  <td>'.$invoiceDetails["amountPending"].'</td>
                  <td>'.$status.'</td>
                  
                  <td><a href="view_sambhavana_invoice.php?invoice_id='.$invoiceDetails["sambhavanaId"].'" title="View Invoice"><span class="bi bi-eye"></span></a>
                  </td>
                  <td><a href="print_sambhavana.php?invoice_id='.$invoiceDetails["sambhavanaId"].'" title="Print Invoice"><span class="bi bi-printer"></span></a>
                  </td>
                  </tr>
              ';
               }       
              ?>
             
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

            

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">ഇവെന്റുകൾ <span>| Active</span></h5>
              

              <div class="activity">
              <?php
		          $eventsList = $invoice->getActiveEvents();

              foreach($eventsList as $eventDetails){
                $eventDate = date("d-m-Y", strtotime($eventDetails["Date"]));

                ?>
                <div class="activity-item d-flex">
                  <div class="activite-label"><?php echo $eventDate; ?></div>
                  <?php if($eventDetails["isactive"]==1){
                    echo "<i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>";
                           }
                           else
                           {
                            echo "<i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>";
                           }

                  ?>
                  
                  <div class="activity-content">
                    <?php echo $eventDetails["Title"]; ?>
                  </div>
                </div><!-- End activity item-->


<?php


              }


              ?>

                

              </div>

            </div>
          </div><!-- End Events -->

          

          <!-- News & Updates Traffic -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">News &amp; Updates <span>| Today</span></h5>

              <div class="news">
              <?php
              
               foreach($announcementList as $announcement){
                $id = $announcement["announcement_id"];
                $announcementDate = date("d-m-Y", strtotime($announcement["times"]));
                $content = $announcement["content"];
                $pos=strpos($content, ' ', 10);
              ?>
              <div class="post-item clearfix">
                  <img src="../assets/img/news-1.jpg" alt="">
                  <h4><a href="#" data-bs-toggle="modal" data-bs-target="#basicModal<?php echo $id; ?>"><?php echo $announcement["title"]." | ".$announcementDate  ?></a></h4>
                  <p><?php echo substr($content,0,$pos );  ?></p>
                </div>
                <div class="modal fade" id="basicModal<?php echo $id; ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title"><?php echo $announcement["title"]?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <?php echo $announcement["content"] ?>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                      
                    </div>
                  </div>
                </div>
              </div><!-- End Basic Modal-->


                <?php
               }

                ?>

              </div><!-- End sidebar recent posts-->

            </div>
          </div><!-- End News & Updates -->

        </div><!-- End Right side columns -->

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
// print_r($_SESSION);
} 

?>