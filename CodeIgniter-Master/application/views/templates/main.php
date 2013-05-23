<?php
require("../phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP(); // send via SMTP
//IsSMTP(); // send via SMTP
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "jasper.cacbay@gmail.com"; // Enter your SMTP username
$mail->Password = "sinecosinetangent"; // SMTP password
$webmaster_email = "jtcacbay@up.edu.ph"; //Add reply-to email address
$email="minnie_pangilinan@yahoo.com.ph"; // Add recipients email address
$name="Minnie Pangilinan"; // Add Your Recipient’s name
$mail->From = "postmaster@localhost";
$mail->FromName = "KPI Automation System";
$mail->AddAddress($email,$name);
$mail->AddReplyTo($webmaster_email,"Super User");
$mail->WordWrap = 50; // set word wrap
//$mail->AddAttachment(“/var/tmp/file.tar.gz”); // attachment
//$mail->AddAttachment(“/tmp/image.jpg”, “new.jpg”); // attachment
$mail->IsHTML(true); // send as HTML

$mail->Subject = "TEST";

$mail->Body =      "Wooo, napagana ko na!" ;      //HTML Body

$mail->AltBody = "asdasd";     //Plain Text Body
if(!$mail->Send()){
echo "Mailer Error" . $mail->ErrorInfo;
} else {
echo "Message has been sent";
}
?>