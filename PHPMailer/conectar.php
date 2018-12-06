<?php
require_once ('class.phpmailer.php');

$mail = new PHPMailer();

$receptor = "audiovisuales@estudiorochayasoc.com.ar";
$emisor = "facundo@estudiorochayasoc.com.ar";
$NombreEmisor = "Facundo Rocha";
$asunto = "Asunto";

$mail -> IsSMTP();
$mail -> Host = "mail.estudiorochayasoc.com.ar";
$mail -> SMTPDebug = 2;
$mail -> SMTPAuth = true;
$mail -> Host = "mail.estudiorochayasoc.com.ar";
$mail -> Port = 587;
$mail -> Username = "facundo@estudiorochayasoc.com.ar";
$mail -> Password = "faAr2010";
$mail -> SetFrom('facundo@estudiorochayasoc.com.ar', 'Facundo Rocha');

?>