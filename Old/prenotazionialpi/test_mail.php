<?php
require("PHPMailerAutoload.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "mail.ao-ve.it";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "usis@ao-ve.it";  // SMTP username
$mail->Password = "catania2014"; // SMTP password

$mail->From = "g.licciardello@ao-ve.it";
$mail->FromName = "Dott. Giacomo Licciardello";
$mail->AddAddress("lodovico65@gmail.com", "Ing. Lorenzo Anastasi");

$mail->WordWrap = 50;                                 // set word wrap to 50 characters
$mail->AddAttachment("flussi.zip");         // add attachments
$mail->IsHTML(true);                                  // set email format to HTML

$mail->Subject = "Invio flussi";
$mail->Body    = "Invio flussi: <b>A, DSAO, C, F, T</b>";
$mail->AltBody = "Invio flussi: A, DSAO, C, F, T";

if(!$mail->Send())
{
   echo "Il messaggio non può essere inviato. <p>";
   echo "Si è verificato l'errore: " . $mail->ErrorInfo;
   exit;
}

echo "Il messaggio è stato inviato!";
?>