<?php
#Useful implementation for microservices
include_once('config.php');
require 'vendor/autoload.php';
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\SMTP;
		use PHPMailer\PHPMailer\Exception;
function envia_email($SUBJECT,$msg,$SENDER_EMAIL, $SENDER_PASSWORD, $RECEIVER_EMAIL, 
		$RECEIVER_APELIDO, $EMPRESA, $ALERTA_SEND, $LINK_REDIRECIONAMENTO, $ALERTA_NOTSEND,
		$LINK_REDIRECIONAMENTO_NOTSEND, $OUTRO_EMAIL=NULL){

		$mail = new PHPMailer(true);
		$mail->CharSet = 'UTF-8';
		$mail->Encoding = 'base64';
		try {	
			//Server settings
			#$mail->SMTPDebug = SMTP::DEBUG_SERVER;//Enable verbose debug output
			$mail->isSMTP();//Send using SMTP
			$mail->Host       = 'smtp.gmail.com'; //Set the SMTP server to send through
			$mail->SMTPAuth   = true;//Enable SMTP authentication
			$mail->Username   = $SENDER_EMAIL;//SMTP username
			$mail->Password   = $SENDER_PASSWORD;//SMTP password
			#$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;//Enable implicit TLS encryption
			$mail->Port       = 587;//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
			//Recipients
			$mail->setFrom($SENDER_EMAIL, $EMPRESA);
			$mail->addAddress($RECEIVER_EMAIL, $RECEIVER_APELIDO);     //Add a recipient
			$mail->addAddress($SENDER_EMAIL);
			if(isset($OUTRO_EMAIL))$mail->addAddress($OUTRO_EMAIL);			//Name is optional
			#$mail->addReplyTo('info@example.com', 'Information');
			#$mail->addCC('cc@example.com');
			#$mail->addBCC('bcc@example.com');
			#Attachments
			
			#$mail->addAttachment($ARQUIVO_ANEXO);         //Add attachments
			#$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = $SUBJECT;
			$mail->Body = $msg;	
			#$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
			if($mail->send()){
				echo $ALERTA_SEND;
				echo $LINK_REDIRECIONAMENTO;
			} else {
				echo $ALERTA_NOTSEND;
				echo $LINK_REDIRECIONAMENTO_NOTSEND;
			}
		} catch (Exception $e) {
			echo $ALERTA_NOTSEND;
			echo $LINK_REDIRECIONAMENTO_NOTSEND;
			#echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
		echo $LINK_REDIRECIONAMENTO;
		}
		if(isset($_POST['msg'])){
			$RECEIVER_APELIDO=$_POST['RECEIVER_APELIDO'];
			$RECEIVER_EMAIL=$_POST['RECEIVER_EMAIL'];
			$SENDER_EMAIL=$_POST['SENDER_EMAIL'];
			$SENDER_PASSWORD=$_POST['SENDER_PASSWORD'];
			$EMPRESA=$_POST['EMPRESA'];
			$LINK_LOGOMARCA=$_POST['LINK_LOGOMARCA'];
			$ALERTA_SEND=$_POST['ALERTA_SEND'];#"<script> alert('Verifique sua caixa de entrada e de spam do seu email!');</script>";
			$LINK_REDIRECIONAMENTO=$_POST['LINK_REDIRECIONAMENTO'];#"simm";#"<meta http-equiv='refresh' content='0;url=https://url.com'>";
			$ALERTA_NOTSEND=$_POST['ALERTA_NOTSEND'];#"<script> alert('Erro no processo de registro. Tente novamente');</script>";
			$LINK_REDIRECIONAMENTO_NOTSEND=$_POST['LINK_REDIRECIONAMENTO_NOTSEND'];#"null";
			#"<meta http-equiv='refresh' content='0;url=https://url2.com'>";
			$SUBJECT=$_POST['SUBJECT'];
			$OUTRO_EMAIL=$_POST['OUTRO_EMAIL'];
			$ARQUIVO_ANEXO=$_POST['ARQUIVO_ANEXO'];
			
			$msg=$_POST['msg'];#
			
			envia_email($SUBJECT,$msg,$SENDER_EMAIL, $SENDER_PASSWORD, $RECEIVER_EMAIL, 
			$RECEIVER_APELIDO, $EMPRESA, $ALERTA_SEND, $LINK_REDIRECIONAMENTO, $ALERTA_NOTSEND,
			$LINK_REDIRECIONAMENTO_NOTSEND, $OUTRO_EMAIL, $ARQUIVO_ANEXO);
		}else{
			echo "Erro!";
		}

?>
