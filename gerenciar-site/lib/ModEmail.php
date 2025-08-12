<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail($conn, $iduser, $senha = null, $modulo = null)
{
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
            
            # Consultar dados do usuário cadastrado
            $cons_user = "SELECT * FROM usuarios u WHERE u.id_user = '$iduser' LIMIT 1 ";
            $query_cons_user = mysqli_query($conn, $cons_user);
            $user = mysqli_fetch_assoc($query_cons_user);

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
                $mail->addAddress($user['email_user'], $user['nome_user']);                           //Quem esta recebendo
                //$mail->addAddress('ellen@example.com');                  //Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');          //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                $tags = array('#nome_completo', '#email', '#login', '#senha', '#empresa', '#usuario_logado');
                $dados = array($user['nome_user'], $user['email_user'], $user['login_user'], $senha, $_SESSION['empresaNOME'], $_SESSION["usuarioNOME"]);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $sendMod['titulo'];
                $mail->Body    = str_replace($tags, $dados, $sendMod['texto']);

                
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                
                $arr = array('tipo' => 'success', 'titulo' => 'Atenção', 'msg' => "E-mail enviado para o usuário");
                return json_encode($arr); 
            } catch (Exception $e) {
                //return "Erro ao enviar e-mail: {$mail->ErrorInfo}";
                $arr = array('tipo' => 'error', 'titulo' => 'Atenção', 'msg' => "Erro ao enviar e-mail: $mail->ErrorInfo");
                return json_encode($arr); 
            }
        }
    }
}

function listModelosEmails($conn)
{
    $cons = "SELECT 
        DATE_FORMAT(em.created_on, '%d/%m/%Y') AS data, 
        m.nome_mod, 
        em.titulo, 
        em.texto,
        em.id,
        em.modulo_id,
        m.id_mod
        FROM email_modelos em INNER JOIN modulos m ON m.id_mod = em.modulo_id ORDER BY em.modulo_id ASC ";
    $query_cons = mysqli_query($conn, $cons);
    return $query_cons;
}

function listEmail($conn)
{
    // Listar qtd
    $cons= "SELECT * FROM email ORDER BY id DESC LIMIT 1";
    $query_cons = mysqli_query($conn, $cons);
    $row = mysqli_fetch_assoc($query_cons);
    return $row;
}
