<?php
if(!function_exists('sendEmail')) {
	function sendEmail($data, $message) {
		
		global $con;
		$current=basename($_SERVER['PHP_SELF']);
		$phone='03037492694';
		$address = 'Test Address';
		if($data['email'] != '') {
			// send an email
			include_once 'PHPMailer-master/PHPMailerAutoload.php';
	        $mail = new PHPMailer();
			if(true) {
	            $mail->isSMTP();                                      // Set mailer to use SMTP 
	            $mail->Host = 'gloneweb.com';
	            $mail->SMTPAuth = true;                               // Enable SMTP authentication 
	            $mail->Username = 'developer@gloneweb.com'; 
	            $mail->Password = 'SGH.^gkn$Hac';                          // SMTP password
	            $mail->SMTPSecure = 'SSL/TLS';                            // Enable TLS encryption, `ssl` also accepted
	            $mail->Port = 587;
	        }
	        $senderEmail = 'developer@gloneweb.com';                                 // TCP port to connect to
	        $senderName = 'developer@gloneweb.com';                                 // TCP port to connect to
	         $msg = $message['body'];
	         $msg .= '<p><b>Best regards,</b></p>';
	         $msg .= '<p><b>'.'Jermy and Jazzy'.'</b></p>';
	         $msg .= '<p><b>Address:</b> '.$address.'</p>';
	         $msg .= '<p><b>Phone:</b> '.$phone.'</p>';
	         ob_start();
	         include 'email_template.php';
	          $mail_data = ob_get_contents();
	          ob_end_clean();
	        $mail->setFrom($senderEmail, $senderName);
	        $mail->addAddress(strtolower($data['email']));     // Add a recipient
	        $reply_to_email = isset($data['reply_to_email']) ? $data['reply_to_email'] : null;
	        $reply_to_name = isset($data['reply_to_name']) ? $data['reply_to_name'] : null;
	        if($reply_to_email) {
		        $mail->addReplyTo($reply_to_email, $reply_to_name);
		    }
	        if(isset($message['attachment']))
	            $mail->AddAttachment($message['attachment']);
	        $mail->isHTML(true);                                  // Set email format to HTML
	        $mail->Subject = $message['subject'];
	        $mail->Body    = $mail_data;
	        $mail->AltBody = '';
	        if(!$mail->send()) {
	            return 'Mailer error: ' . $mail->ErrorInfo;;
	        } else {
	            return 1;
	        }

		}
		return 0;
	}
}
function sendEmailToAdmin($data, $message) {
	global $con;
	$data['email'] = 'fakharabbas4956@gmil.com';
	return sendEmail($data, $message);
}
if(!function_exists('countLiveVisitors')) {
	function countLiveVisitors() {
		global $con;
		$current_time = time();
		$timeout = $current_time - (60);
		$session_check = 0;
		$select_total = mysqli_query($con, "SELECT * FROM total_visitors WHERE session_time >= '".$timeout."'");
		return mysqli_num_rows($select_total);
	}
}
function validateEditOrder($order_id = null) {
	global $con;
	$customer_ledger_payments = mysqli_query($con, "SELECT * FROM customer_ledger_payments WHERE FIND_IN_SET($order_id,ledger_orders)");
	$result= ($customer_ledger_payments) ? mysqli_fetch_assoc($customer_ledger_payments):false;
	$customer_ledger_id = isset($result['id']) ? $result['id']:'';

	$non_customer_ledger_payments = mysqli_query($con, "SELECT * FROM non_customer_ledger_payments WHERE FIND_IN_SET($order_id,ledger_orders)");
	$non_customer= ($non_customer_ledger_payments) ? mysqli_fetch_assoc($non_customer_ledger_payments):false;
	$non_customer_ledger_id = isset($non_customer['id']) ? $non_customer['id']:'';

	if($customer_ledger_id!='' || $non_customer_ledger_id!='')
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

if(!function_exists('sendEmail_template')) {
	function sendEmail_template($data, $message) {
		global $con;
		$current=basename($_SERVER['PHP_SELF']);
		$query=mysqli_query($con,"SELECT * FROM users WHERE type='admin' ");
		$fetch=mysqli_fetch_array($query);
		$phone=$fetch['phone'];
		$address = getConfig('address');
		if($data['email'] != '') 
		{
			// send an email
			include_once 'PHPMailer-master/PHPMailerAutoload.php';
	        $mail = new PHPMailer();
	        // $mail->SMTPDebug = 3;
	        // if(true) {
	        //     $mail->isSMTP();                                      // Set mailer to use SMTP
	        //      $mail->Host =  getConfig('mail_host');  // Specify main and backup SMTP servers
	        //     //$mail->Host = 'zoop.to';
	        //     $mail->SMTPAuth = true;                               // Enable SMTP authentication
	        //      $mail->Username = getConfig('mail_username');                 // SMTP username
	        //     //$mail->Username = 'support@zoop.to';
	        //     $mail->Password = getConfig('mail_password');
	        //     //$mail->Password = '-3U+ho#(KAg=';                          // SMTP password
	        //     $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	        //     $mail->Port = 587;
	        // }

	        $senderEmail = getConfig('mail_username');                                 // TCP port to connect to
	        $senderName = getConfig('mail_from_name');                                 // TCP port to connect to
	         $msg = $message['body'];
	         ob_start();
	         include 'email_template.php';
	          $mail_data = ob_get_contents();
	          ob_end_clean();
	        $mail->setFrom($senderEmail, $senderName);
	        $mail->addAddress(strtolower($data['email']));     // Add a recipient
	        $reply_to_email = isset($data['reply_to_email']) ? $data['reply_to_email'] : null;
	        $reply_to_name = isset($data['reply_to_name']) ? $data['reply_to_name'] : null;
	        if($reply_to_email) 
	        {
		        $mail->addReplyTo($reply_to_email, $reply_to_name);
		    }
	        if(isset($message['attachment']))
	        {
	            $mail->AddAttachment($message['attachment']);
	        }
	        $mail->isHTML(true);                                  // Set email format to HTML
	        $mail->Subject = $message['subject'];
	        $mail->Body    = $mail_data;
	        $mail->AltBody = '';
	        if(!$mail->send()) {
	            return 0;
	        } else {
	            return 1;
	        }

		}
		return 0;
	}
}
?>
