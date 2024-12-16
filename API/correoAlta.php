<?php
 include "../Config/config.php";
 /*NOTA: TIENE QUE ESTAR DESACTIVADO EL AVASTANTIVIRUS PARA QUE ENVIE EL MENSAJE */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\POP3;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/POP3.php';

$titulo='';
$cuerpo='';


$params = json_decode(file_get_contents('php://input'),true);


$mail = new PHPMailer(true); 
try{
    //Server settings
    // Set mailer to use SMTP
    $mail             = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 2; 

    $mail->SMTPAuth   = true;                 // enable SMTP authentication
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Host       = $params["host"];      // sets GMAIL as the SMTP server
    $mail->Port       = $params["port"];        // set the SMTP port for the GMAIL server
    $mail->Username   = $params["username"];  // GMAIL username
    $mail->Password   = $params["password"];        // GMAIL password TCP port to connect to
    //Recipients
    $mail->setFrom($params["username"], 'Mailer');          //This is the email your form sends From
    $mail->addAddress('alonsolr1999@gmail.com', 'Joe User'); 
    $mail->addAddress('rub_evil@hotmail.com', 'Joe User');// Add a recipient address
    //$mail->addAddress('contact@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Prueba';
    $mail->Body    = 'Este es un mensaje de prueba';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';

    }catch(Exception $e){
        echo 'Error de envio';
    }
