<?php 
function sendSMS($campaign_name, $mobileNumber, $sender, $message, $route, $template_id, $coding) {
    $curl = curl_init();
    $authKey = "491ccde39edb0dc969dac39d8e40cccb";  //Valid Authentication Key
    $scheduleTime = ""; //if required fill parameter in given format 07-05-2022 12:00:00 dd-mm-yyyy hh:mm:ss 

    $postData = array(
        "campaign_name" => $campaign_name,
        "auth_key" => $authKey,
        "receivers" => $mobileNumber,
        "sender" => $sender,
        "route" => $route,
        "message" => ['msgdata' => $message, 'Template_ID' => $template_id, 'coding' => $coding,],
        "scheduleTime" => $scheduleTime,
    );

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sms.bulksmsserviceproviders.com/api/send/sms',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($postData),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
}




    
   ?>