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

    $nome    = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
    $email   = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);

    //consultar servidor de e-mail
    $srvEmail = "SELECT * FROM email ORDER BY id DESC LIMIT 1";
    $query_srvEmail = mysqli_query($conn, $srvEmail);
    if (($query_srvEmail) and ($query_srvEmail->num_rows > 0)) {
        $send = mysqli_fetch_assoc($query_srvEmail);

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
            $mail->addAddress($email, $nome);                           //Quem esta recebendo
            //$mail->addAddress('ellen@example.com');                  //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');          //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Não responda";
            $mail->Body    = "<h1>Este é um e-mail de teste</h1>";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

            $arr = array('tipo' => 'success', 'titulo' => 'Enviado', 'msg' => 'E-mail enviado com sucesso');
            echo json_encode($arr);  
        } catch (Exception $e) {
            $arr = array('tipo' => 'error', 'titulo' => 'Erro de processamento', 'msg' =>$e ." - ". $mail->ErrorInfo);
            echo json_encode($arr); 
        }
    }

?>