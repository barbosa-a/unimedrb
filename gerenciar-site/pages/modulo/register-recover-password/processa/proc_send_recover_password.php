<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

if ($email) {
    //Verificar se o email esta cadastrado no banco de dados
    $verifica_registro_email = "SELECT id_user, email_user, usuarios_autenticacao_id FROM usuarios WHERE email_user = '$email' LIMIT 1";
    $query_verifica_registro_email = mysqli_query($conn, $verifica_registro_email);

    if (($query_verifica_registro_email) and ($query_verifica_registro_email->num_rows > 0)) {

        $user = mysqli_fetch_assoc($query_verifica_registro_email);

        if ($user['usuarios_autenticacao_id'] == 1) {

            $msg = array('tipo' => 'info', 'titulo' => 'Não autorizado', 'msg' => 'Usuário vinculado API');
            echo json_encode($msg);

        } else {

            try {
                //token de acesso
                $bytes = random_bytes(32);
                $token = hash('sha256', $bytes);

                //Senha
                $novaSenha = uniqid();
                $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
                //update para alterar a senha do usuário
                $up_senha = "UPDATE 
                usuarios 
                SET 
                    senha_user = '$senhaHash', 
                    token = '$token', 
                    situacoes_usuario_id= 3, 
                    modificado_user = NOW(), 
                    ult_token = NOW() 
                WHERE id_user = '{$user['id_user']}' 
                LIMIT 1 
            ";
                $query_up_senha = mysqli_query($conn, $up_senha);
                if (mysqli_affected_rows($conn) != 0) {

                    //salvar o historico de alteração de senha
                    $cad_hist_senha = "INSERT INTO hist_senha 
                    (usuario_id, operador, evento_senha_id, created_hist_senha) 
                        VALUES 
                    ('{$user['id_user']}', '{$user['id_user']}', 3, NOW())
                ";
                    $query_cad_hist_senha = mysqli_query($conn, $cad_hist_senha);

                    $arr = array(
                        'tipo' => 'success',
                        'titulo' => 'Sucesso',
                        'msg' => 'Nova senha enviada para o e-mail de cadastro',
                        'usuario' => $user['id_user'],
                        'senha' => $novaSenha,
                        'modulo' => 1
                    );
                    echo json_encode($arr);
                }
            } catch (Exception $err) {

                $arr = array('tipo' => 'error', 'titulo' => 'Ops', 'msg' => 'Erro: ' . $err->getMessage());
                echo json_encode($arr);
            }

        }
    } else {
        $arr = array('tipo' => 'info', 'titulo' => 'Atenção', 'msg' => 'Endereço de e-mail inválido');
        echo json_encode($arr);
    }
} else {
    $arr = array('tipo' => 'info', 'titulo' => 'Atenção', 'msg' => 'Digite um e-mail válido');
    echo json_encode($arr);
}
