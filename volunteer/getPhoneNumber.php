<?php
// Include your Invoice.php file
include 'Invoice.php';
$invoice = new Invoice();

if (isset($_POST['houseNumber'])) {
    $houseNumber = $_POST['houseNumber'];

    // Use the function from Invoice.php to get the phone number based on the house number
    $arr = $invoice->getMemberDetailsByHouseNumber($houseNumber);
    $returnValues = json_encode($arr);
    // Check if $phoneNumber is an array and convert it to a string
    // if (is_array($phoneNumber)) {
    //     // Assuming 'phone' is the key in your array, modify accordingly
    //     $phoneNumber = isset($phoneNumber['mobile']) ? $phoneNumber['mobile'] : '';
    // }

    echo  $returnValues ;
}
?>
