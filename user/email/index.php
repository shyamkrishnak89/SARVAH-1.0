<?php
include('smtp/PHPMailerAutoload.php');
// $msg1 = 'പ്രിയരേ, <b>ഇത് ഒരു ടെസ്റ്റ് മെസ്സേജ് ആണ്.</b> SMTP email body.';
// echo smtp_mailer('shyamkrishnak89@gmail.com','Test', $msg1);
function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	//$mail->SMTPDebug = 2; 
	$mail->Username = "communicationkizhuthully@gmail.com";
	$mail->Password = "olgqzkgtrhyktnea";
	$mail->setFrom('communicationkizhuthully@gmail.com', 'Kizhuthully Mahavishnu Temple');
	$mail->addReplyTo('communicationkizhuthully@gmail.com', 'Kizhuthully Mahavishnu Temple'); // to set the reply to
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		return 'Sent';
	}
}
?>