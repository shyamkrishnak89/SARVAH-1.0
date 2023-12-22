<?php  
 //excel.php  
 ob_start();
 header('Content-Type: application/vnd.ms-excel');  
 header('Content-disposition: attachment; filename=Invoice.xls');  
 echo $_GET["data"];  
 ?>  