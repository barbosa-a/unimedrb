<?php

    //segurança do ADM
    $seguranca = true;   
    include_once("../../../../config/config.php"); 
    include_once("../../../../config/conexao.php");
    include_once("../../../../lib/ModSistema.php");

    $iduser = filter_input(INPUT_POST, 'usuario', FILTER_DEFAULT);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
    $modulo = filter_input(INPUT_POST, 'modulo', FILTER_DEFAULT);

    # Consultar dados do usuário cadastrado
    $cons_user = "SELECT * FROM usuarios u WHERE u.id_user = '$iduser' LIMIT 1 ";
    $query_cons_user = mysqli_query($conn, $cons_user);

    if (mysqli_affected_rows($conn) > 0) {

        $user = mysqli_fetch_assoc($query_cons_user);  

        $api = confApi($conn);

        try {
        
            $hora = date('H'); // Obtém a hora atual no formato de 24 horas
        
            if ($hora >= 5 && $hora < 12) {
                $sudacao = "Bom dia";
            } elseif ($hora >= 12 && $hora < 18) {
                $sudacao = "Boa tarde";
            } else {
                $sudacao = "Boa noite";
            }
        
            $link = pg . "/pages/modulo/update-password/update.php";
        
            $msg = "$sudacao, Sr(a) #nomeCompleto!\nRecebemos sua solicitação de redefinição de senha, abaixo segue seus dados para acesso.\n\nlink: #link\nUsuário: #user\nSenha: #senha\n\n#empresa,\n#usuario_logado";
        
            // Substituir tags para envio de mensagem personalizada
            $msgCustom = str_replace(
                ['#nomeCompleto', '#user', '#senha', '#link', '#empresa', '#usuario_logado'], 
                [$user['nome_user'], $user['login_user'], $senha, $link, "Equipe de suporte", nomeSistema], 
                $msg
            );
        
            $num = str_replace("(", "", str_replace(")", "", str_replace(" ", "", str_replace("-", "", $user['numeroCelular']))));
        
            // Dados para enviar no corpo da requisição
            $data = array(
                "chatId" => validarNumeroTelefone($num) . "@c.us",
                "contentType" => "string",
                "content" => $msgCustom,
            );
        
            // Headers da requisição
            $headers = array(
                'accept: */*',
                'x-api-key: comunidadezdg.com.br',
                'Content-Type: application/json'
            );
        
            // Inicializar a sessão cURL
            $ch = curl_init();
        
            // Configurar as opções da requisição
            curl_setopt($ch, CURLOPT_URL, $api['curl']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            // Executar a requisição e obter a resposta
            $response = curl_exec($ch);
            $resposta = json_decode($response, true);
        
            // Verificar se houve algum erro
            if(curl_errno($ch)) {
                //echo 'Erro ao enviar requisição: ' . curl_error($ch);
                $arr = array('tipo' => 'success', 'titulo' => 'WhatsApp', 'msg' => 'Mensagem enviado');
                echo json_encode($arr); 
            }else{
        
                if ($resposta['success'] == true) {
                    $arr = array('tipo' => 'success', 'titulo' => 'WhatsApp', 'msg' => "Mensagem enviado");
                    echo json_encode($arr); 
                }else{
                    $arr = array('tipo' => 'error', 'titulo' => 'Erro', 'msg' => 'Erro ao enviar mensagem de WhatsApp '. curl_error($ch) . "Erro: ". curl_errno($ch));
                    echo json_encode($arr); 
                }
        
            }
        
            // Fechar a sessão cURL
            curl_close($ch);
    
           
        } catch (Exception $err) {
            //return "Erro ao enviar e-mail: {$mail->ErrorInfo}";
            $arr = array('tipo' => 'error', 'titulo' => 'Atenção', 'msg' => "Erro ao enviar mensagem:". $err->getMessage());
            echo json_encode($arr); 
        }

    }else{
        $arr = array('tipo' => 'error', 'titulo' => 'Atenção', 'msg' => "Usuário inválido");
        echo json_encode($arr);     
    }
    
?>