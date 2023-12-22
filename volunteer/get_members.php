<?php
include 'Invoice.php'; 
$invoice = new Invoice();
// Fetch mobile numbers using the getMobileNumbers method
$result = $invoice->getMobileNumbers();
if ($result->num_rows > 0) {
    $values = [];
    while ($row = $result->fetch_assoc()) {
        $values[] = $row['mobile'];
    }
    echo json_encode(['success' => true, 'values' => $values]);
} else {
    echo json_encode(['success' => false]);
}

// Check if the query was successful
// if ($mobileNumbersData['success']) {
//     $mobileNumbers = $mobileNumbersData['data'];

//     // Extract 'mobile' values from the result
//     $values = array_column($mobileNumbers, 'mobile');

//     echo json_encode(['success' => true, 'values' => $values]);
// } else {
//     echo json_encode(['success' => false]);
// }

// $servername = "localhost";
// $username = "root";
// $password = "root";
// $dbname = "cman";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Fetch values from the database
// $sql = "SELECT mobile FROM members";
// // $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     $values = [];
//     while ($row = $result->fetch_assoc()) {
//         $values[] = $row['mobile'];
//     }
//     echo json_encode(['success' => true, 'values' => $values]);
// } else {
//     echo json_encode(['success' => false]);
// }

// $conn->close();







// include 'Invoice.php'; // Adjust the path accordingly

// // Assuming you have an instance of the Invoice class
// $invoice = new Invoice();

// // Fetch mobile numbers using the getMobileNumbers function
// $mobileNumbersData = $invoice->getMobileNumbers();

// // Check if the query was successful

// foreach($mobileNumbersData as $memberDetails){
//     // $mobileNumbers = $mobileNumbersData["mobile"];
//     $mobileNumbers = "1234567890";
//     echo json_encode(['success' => true, 'mobileNumbers' => $mobileNumbers]);
// }



// if ($mobileNumbersData) {
//     $mobileNumbers = $mobileNumbersData['data'];
//     echo json_encode(['success' => true, 'mobileNumbers' => $mobileNumbers]);
// } else {
//     echo json_encode(['success' => false]);
// }
  
?>
