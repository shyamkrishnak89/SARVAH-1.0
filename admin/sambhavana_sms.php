<?php
// Include necessary files and configurations for sendSMS function
include 'sms.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sambhavanaId = $_POST['sambhavanaId'];
    $personName = $_POST['personName'];
    $eventName = $_POST['eventName'];
    $houseNumber = $_POST['houseNumber'];
    $mobile = $_POST['mobile'];
    $amountOffered = $_POST['amountOffered'];
    $amountPaid = "Rs.".$_POST['amountPaid'];
    $balanceAmount = "Rs.".$_POST['balanceAmount'];

    // Additional parameters for your sendSMS function
    $campaign_name = "$eventName-Approval";
    $mobileNumber = $mobile; // Replace with the actual mobile number
    $sender = 'KMVTNL';
    $message = "
    Hi $houseNumber,
Event: $eventName
Amount Received:$amountPaid
Balance: $balanceAmount
R.No: $sambhavanaId
-
Secretary 
KIZHUTHULLY SREE MAHAVISHNU KSHETRA SAMRAKSHANA SAMITHY";



    //$message = "Hi $houseNumber,\rThank you for offering Rs.$amountOffered towards $eventName.\rReceived Rs.$amountPaid\rR.No -$sambhavanaId\r-Secretary\rKIZHUTHULLY SREE MAHAVISHNU KSHETRA SAMRAKSHANA SAMITHY";
    $route = 'TR';
    $template_id = '1407170075641133954';
    $coding = '1';

    // Call the sendSMS function
    sendSMS($campaign_name, $mobileNumber, $sender, $message, $route, $template_id, $coding);

    // You can echo a success message or any other response if needed
    echo 'SMS sent successfully!';
} else {
    // Handle cases where the request method is not POST
    echo 'Invalid request method';
}
?>