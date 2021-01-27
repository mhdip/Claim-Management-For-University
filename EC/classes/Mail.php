<?php
class Mail {

	  //this funciton is for sending mail 
	  public static function send_mail($email, $subject, $message){
		  require_once ('mails/mail/class.phpmailer.php');
		  require_once ('mails/mail/class.smtp.php');
		  
		  	$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug = false;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 465;
			//$mail->SMTPAuth = true;
			$mail->AddAddress($email);
			$mail->Username = "mhsporsho@gmail.com";
			$mail->Password = "thisismygmailaccount";//should be change
			$mail->SetFrom('mhsporsho@gmail.com','EC_Admin');
			$mail->AddReplyTo('mhsporsho@gmail.com','EC_Admin');
			$mail->Subject = $subject;
			$mail->MsgHTML($message);

			
			if($mail->Send()){
				echo "<div id='zartan_success_message'>";
                echo "A mail has sent to your email, Please check your email for furthure process";
                echo "</div>";
             }else {
                
            }
			
			
	  }

}

?>