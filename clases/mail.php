<?php
include_once('class.phpmailer.php');
//function enviarMailDetalle($mail_custodio,$mail_encargado,$body){
function enviarMailDetalle($mail_destino,$body,$autorizacion){
//	echo "enviarMailDetalle= $mail_destino , $body <br>";
	//servidor de correo
//	$autorizacion = $_POST['autorizacion'];
	$email_host = "mail.ieps.gob.ec";
	$email_port = 587;
	$email_tipo = "smtp";
	//informacion de la cuenta
	$email_remintente = "talentohumano@ieps.gob.ec";
	$email_remintente_nombre = "IEPS";
	$email_remintente_usuario = "talentohumano"; 
	$email_remintente_contrasena = "Tal15HumI3p$";
	$email_asunto = "Solicitud de Vacaciones";
	//bandera
	$bandera = false;
	
	$mail = new PHPMailer();
	//$body = $mail->getFile('contents.html');
	//$body = eregi_replace("[\]",'',$body);
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Mailer   = $email_tipo;//"smtp";
	$mail->Host     = $email_host;//"mail.ieps.gob.ec"; // SMTP server
	$mail->Port     = $email_port;//587;
	$mail->SMTPAuth = true;
	$mail->Username = $email_remintente_usuario;//"conductores";//"compras"; 
	$mail->Password = $email_remintente_contrasena;//"ieps000"; 
	$mail->From     = $email_remintente;//"conductores@ieps.gob.ec";//"compras@ieps.gob.ec";
	$mail->FromName = $email_remintente_nombre;//"IEPS compras";
	$mail->Subject  = $email_asunto;//"PHPMailer Test Subject via smtp";
	$mail->MsgHTML($body);
		
	$mail->ClearAddresses();	
	 
	 if($autorizacion==1)
		{
	$mail->AddAddress($mail_destino,$mail_destino);
	$mail->AddAddress("mayra.criollo@ieps.gob.ec","Solicitudes Formularios TH");
	}else{
		$mail->AddAddress($mail_destino,"Correo");
	}
//	echo "antes de enviar<br>";
	
	//$mail->AddAddress($mail, "Correo");
	//$mail->AddAddress($mail_encargado, "Encargado");
	//agrega copia a administradores
	/*if ($email_ieps_recibe01!="") $mail-> AddAddress($email_ieps_recibe01);
	if ($email_ieps_recibe02!="") $mail-> AddAddress($email_ieps_recibe02);*/
	//Adjunta una imagen
	//$mail->AddAttachment("images/phpmailer.gif");   // attachment
		
	if(!$mail->Send()) 
	{
	  echo "Mailer Error: " . $mail->ErrorInfo;
	  $bandera = false;
	} else 
	{
	//  echo "Message sent!";
	  $bandera = true;
	}
//	echo "bandera=$bandera<br>";
	return $bandera;
}


function enviarMailDetalle1($mail_destino,$body){
	//	echo "enviarMailDetalle= $mail_destino , $body <br>";
	//servidor de correo
	//	$autorizacion = $_POST['autorizacion'];
	$email_host = "mail.ieps.gob.ec";
	$email_port = 587;
	$email_tipo = "smtp";
	//informacion de la cuenta
	$email_remintente = "talentohumano@ieps.gob.ec";
	$email_remintente_nombre = "IEPS";
	$email_remintente_usuario = "talentohumano";
	$email_remintente_contrasena = "Tal15HumI3p$";
	$email_asunto = "Solicitud de Permisos";
	//bandera
	$bandera = false;

	$mail = new PHPMailer();
	//$body = $mail->getFile('contents.html');
	//$body = eregi_replace("[\]",'',$body);
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Mailer   = $email_tipo;//"smtp";
	$mail->Host     = $email_host;//"mail.ieps.gob.ec"; // SMTP server
	$mail->Port     = $email_port;//587;
	$mail->SMTPAuth = true;
	$mail->Username = $email_remintente_usuario;//"conductores";//"compras";
	$mail->Password = $email_remintente_contrasena;//"ieps000";
	$mail->From     = $email_remintente;//"conductores@ieps.gob.ec";//"compras@ieps.gob.ec";
	$mail->FromName = $email_remintente_nombre;//"IEPS compras";
	$mail->Subject  = $email_asunto;//"PHPMailer Test Subject via smtp";
	$mail->MsgHTML($body);

	$mail->ClearAddresses();

		$mail->AddAddress($mail_destino,"Correo");
	//	$mail->AddAddress("adrian-cevatre@hotmail.com","Correo");
	
	//	echo "antes de enviar<br>";

	//$mail->AddAddress($mail, "Correo");
	//$mail->AddAddress($mail_encargado, "Encargado");
	//agrega copia a administradores
	/*if ($email_ieps_recibe01!="") $mail-> AddAddress($email_ieps_recibe01);
	 if ($email_ieps_recibe02!="") $mail-> AddAddress($email_ieps_recibe02);*/
	//Adjunta una imagen
	//$mail->AddAttachment("images/phpmailer.gif");   // attachment

	if(!$mail->Send())
	{
		echo "Mailer Error: " . $mail->ErrorInfo;
		$bandera = false;
	} else
	{
		//  echo "Message sent!";
		$bandera = true;
	}
	//	echo "bandera=$bandera<br>";
	return $bandera;
}


function enviarMail($mail_destino,$body, $titulo){
	$email_host = "mail.ieps.gob.ec";
	$email_port = 587;
	$email_tipo = "smtp";
	//informacion de la cuenta
	$email_remintente = "talentohumano@ieps.gob.ec";
	$email_remintente_nombre = "IEPS";
	$email_remintente_usuario = "talentohumano";
	$email_remintente_contrasena = "Tal15HumI3p$";
	$email_asunto = $titulo;
	//bandera
	$bandera = false;

	$mail = new PHPMailer();
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Mailer   = $email_tipo;//"smtp";
	$mail->Host     = $email_host;//"mail.ieps.gob.ec"; // SMTP server
	$mail->Port     = $email_port;//587;
	$mail->SMTPAuth = true;
	$mail->Username = $email_remintente_usuario;//"conductores";//"compras";
	$mail->Password = $email_remintente_contrasena;//"ieps000";
	$mail->From     = $email_remintente;//"conductores@ieps.gob.ec";//"compras@ieps.gob.ec";
	$mail->FromName = $email_remintente_nombre;//"IEPS compras";
	$mail->Subject  = $email_asunto;//"PHPMailer Test Subject via smtp";
	$mail->MsgHTML($body);

	$mail->ClearAddresses();

	$mail->AddAddress($mail_destino,$mail_destino);
	if(!$mail->Send())
	{
		echo "Mailer Error: " . $mail->ErrorInfo;
		$bandera = false;
	} else
	{
		//  echo "Message sent!";
		$bandera = true;
	}
	//	echo "bandera=$bandera<br>";
	return $bandera;
}
?>