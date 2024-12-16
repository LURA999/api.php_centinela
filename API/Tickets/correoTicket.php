<?php
 include "../../Config/database.php";
 include '../../Config/config.php';
 /*NOTA: TIENE QUE ESTAR DESACTIVADO EL AVASTANTIVIRUS PARA QUE ENVIE EL MENSAJE */

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\POP3;
 
 require '../../PHPMailer/src/Exception.php';
 require '../../PHPMailer/src/PHPMailer.php';
 require '../../PHPMailer/src/SMTP.php';
 require '../../PHPMailer/src/POP3.php';


    $params = json_decode(file_get_contents('php://input'),true);
    $mail = new PHPMailer(true);
    try{
    $db = new database();
    $sql = $db->connect()->prepare("select host,port,username,password from smtp");
    $sql ->execute();
    $sql = $sql->fetch(PDO::FETCH_ASSOC);

    $ticket = $db->connect()->prepare("select Max(idTicket) id from ticket");
    $ticket ->execute();
    $ticket = $ticket->fetch(PDO::FETCH_ASSOC);

    $empresa = $db->connect()->prepare("select * from empresa");
    $empresa ->execute();
    $empresa = $empresa->fetch(PDO::FETCH_ASSOC);
    
    //Server settings
    // Set mailer to use SMTP
    $mail             = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = false; 

    $mail->SMTPAuth   = true;                 // enable SMTP authentication
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Host       = $sql["host"];      // sets GMAIL as the SMTP server
    $mail->Port       = $sql["port"];        // set the SMTP port for the GMAIL server
    $mail->Username   = $sql["username"];  // GMAIL username
    $mail->Password   = $sql["password"];      // GMAIL password TCP port to connect to
    //Recipients
    $mail->setFrom($sql["username"], 'Aviso de ticket');          //This is the email your form sends From
    $mail->addAddress($params["correo"], $params["nombreContacto"]); 
    //$mail->addAddress('rub_evil@hotmail.com', 'Joe User'); Add a recipient address
    //$mail->addAddress('contact@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    if(count($params["correoCc"]) > 0){
    foreach ($params["correoCc"] as $key => $value) {
        $mail->addCC($value);
        }
    }

    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $empresa["nombre"]." Ticket #".$ticket["id"];

    $mail->AddEmbeddedImage('../../Img/banner.png', 'logoimg', 'banner.png', 'base64', 'image/png');
    $body = "<div  style='font-family:sans-serif; font-size: large;'>";
    $body = $body.$params["nombreContacto"]." (".$params["nombreCliente"].")<br/>";
    $body = $body.$params["TextoAsunto"].".<br/><br/>";
    $body = $body."Ticket #".$ticket["id"].'<br/>';
    $body = $body."Servicio: ".$params["servicio"].'<br/>';
    $body = $body."Identificador: ".$params["identificador"].'<br/>';
    $body = $body."Prioridad: ".$params["prioridad"].'<br/>';
    $body = $body."Estatus:  ".$params["estatus"]. "<br/><br/>";
    $body = $body."</div>";
    $body = $body."<img src='cid:logoimg' style='height:290px; width:1000px;'/>";
    $mail->Body    = $body;

    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
   /* if(!$mail->send()) {
        echo 'Message could not be sent.'."\n";
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }*/
    }catch(Exception $e){
              //  echo 'Error de envio';

    }
        


