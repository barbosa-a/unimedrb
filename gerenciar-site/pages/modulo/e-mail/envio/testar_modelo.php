<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$seguranca = true;

//Biblioteca auxiliares
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");

//Load Composer's autoloader
require '../../../../vendor/autoload.php';

$modulo = filter_input(INPUT_POST, 'modulo', FILTER_SANITIZE_NUMBER_INT);

if (!empty($modulo)) {

    //consultar servidor de e-mail
    $srvEmail = "SELECT * FROM email ORDER BY id DESC LIMIT 1";
    $query_srvEmail = mysqli_query($conn, $srvEmail);
    if (($query_srvEmail) and ($query_srvEmail->num_rows > 0)) {
        $send = mysqli_fetch_assoc($query_srvEmail);

        //consultar modelo de envio
        $srvModEmail = "SELECT titulo, texto FROM email_modelos WHERE modulo_id = '$modulo' LIMIT 1";
        $query_srvModEmail = mysqli_query($conn, $srvModEmail);
        if (($query_srvModEmail) and ($query_srvModEmail->num_rows > 0)) {
            $sendMod = mysqli_fetch_assoc($query_srvModEmail);
            # preparar envio de e-mail

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                 //Enable verbose debug output
                $mail->CharSet  = 'UTF-8';
                $mail->isSMTP();                                        //Send using SMTP
                $mail->Host       = $send['host'];                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                             //Enable SMTP authentication
                $mail->Username   = $send['usuario'];                //SMTP username
                $mail->Password   = $send['senha'];                 //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   //Enable implicit TLS encryption
                $mail->Port       = $send['porta'];               //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($send['usuario'], $send['nome_usuario']);     //Quem esta enviando
                $mail->addAddress($send['usuario'], $send['nome_usuario']);                           //Quem esta recebendo
                //$mail->addAddress('ellen@example.com');                  //Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');          //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $sendMod['titulo'];
                $mail->Body    = $sendMod['texto'];
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                $arr = array('tipo' => 'success', 'titulo' => 'Enviado', 'msg' => 'E-mail enviado com sucesso');
                echo json_encode($arr);  
            } catch (Exception $e) {
                $arr = array('tipo' => 'error', 'titulo' => 'Erro de processamento', 'msg' =>$e ." - ". $mail->ErrorInfo);
                echo json_encode($arr); 
            }
        }
    }
}
