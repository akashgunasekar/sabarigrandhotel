<?php
session_start();
ini_set('upload_max_filesize', '40000M');
ini_set('post_max_size', '40000M');
ini_set('max_input_time', 300000);
ini_set('max_execution_time', '-1');

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/*Email Template Render*/
function render_email($email, $data)
{
	ob_start();
	include "reservation.phtml";
	return ob_get_contents();
}

if ($_POST) {
	$data['checkin'] = isset($_POST['checkin']) ? $_POST['checkin'] : '';
    $data['checkout'] = isset($_POST['checkout']) ? $_POST['checkout'] : '';
    $data['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '';
    $data['person'] = isset($_POST['person']) ? $_POST['person'] : '';
    $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
	

	$body = render_email('email', $data);

	$subject = "You have a message from your client from contact us";

	//  $to = "arunduraideveloper@gmail.com";
	$to = "prasannakanthan@gmail.com";
	//$to = "prasannakanthan@gmail.com";
	$from = "prasannakanthan@gmail.com";

	//PHPMailer Object
	$mail = new PHPMailer\PHPMailer\PHPMailer(); //Argument true in constructor enables exceptions

	// $mail->SMTPDebug = 3;  
	$mail->SMTPDebug = false;
	//Set PHPMailer to use SMTP.
	$mail->isSMTP();
	//Set SMTP host name                          
	$mail->Host = "smtp.gmail.com";
	//Set this to true if SMTP host requires authentication to send email
	$mail->SMTPAuth = true;
	//Provide username and password     
	$mail->Username = "6383990217s@gmail.com";
	$mail->Password = "gxvc xjux sdnd igqa";
	//If SMTP requires TLS encryption then set it
	$mail->SMTPSecure = "ssl";
	//Set TCP port to connect to
	$mail->Port = 465;

	//From email address and name
	$mail->From = $from;
	$mail->FromName = "contact us details";

	//To address and name
	//$mail->addAddress("limtion.digital@gmail.com", "Limtion Site");
	$mail->addAddress($to); //Recipient name is optional

	//Address to which recipient will reply
	// $mail->addReplyTo("aaranrims@yourdomain.com", "Reply");

	//CC and BCC
	//$mail->addCC("aaranrims@gmail.com");
	//$mail->addBCC("bcc@example.com");

	//Send HTML or Plain Text email
	$mail->isHTML(true);

	$mail->Subject = $subject;
	$mail->Body = $body;


	try {
		$mail->send();
		echo "sent";
		$_SESSION['status'] = "success";
	} catch (Exception $e) {
		print_r(error_get_last());
		echo "Error: Message not accepted";
		$_SESSION['status'] = "failure";
	}

}
header("Location: index.php");
//header("Location: ". $_SERVER['HTTP_REFERER']);
exit;
?>