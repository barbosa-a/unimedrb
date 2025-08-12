<?php
//inicializar sessão
session_start();

$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");
$usuario                = filter_input(INPUT_POST, 'usuario', FILTER_DEFAULT);
$senha_atual            = filter_input(INPUT_POST, 'senha_atual', FILTER_DEFAULT);
$senha_atual_crip       = password_hash($senha_atual, PASSWORD_DEFAULT);
$nova_senha             = filter_input(INPUT_POST, 'nova_senha', FILTER_DEFAULT);
$nova_senha_crip        = password_hash($nova_senha, PASSWORD_DEFAULT);
$confirmar_senha        = filter_input(INPUT_POST, 'confirmar_senha', FILTER_DEFAULT);
$confirmar_senha_crip   = password_hash($confirmar_senha, PASSWORD_DEFAULT);

if (!btnTrocarSenha) {
    die("Impossivel conectar a url");
}
if ((empty($usuario)) and (empty($senha_atual)) and (empty($nova_senha)) and (empty($confirmar_senha))) {

    $msg = array(
        'tipo' => 'info',
        'titulo' => 'Atenção',
        'msg' => 'Necessario preencher todos os campos.'
    );

    echo json_encode($msg);
    
} else {
    //comparar dados do usuário
    $pesq_usuario = "SELECT 
            *,
            TIMESTAMPDIFF(HOUR, ult_token, NOW()) AS tmp_token
        FROM usuarios WHERE login_user= '$usuario' LIMIT 1 
    ";
    $query_pesq_usuario = mysqli_query($conn, $pesq_usuario);
    if ($query_pesq_usuario) {
        $row_usuario = mysqli_fetch_array($query_pesq_usuario);

        if ($row_usuario['usuarios_autenticacao_id'] == 1) {

            $msg = array('tipo' => 'info', 'titulo' => 'Não autorizado', 'msg' => 'Usuário vinculado API');
            echo json_encode($msg);

        } elseif ($row_usuario['situacoes_usuario_id'] == 3 and $row_usuario['tmp_token'] > 1) {

            $msg = array(
                'tipo' => 'info',
                'titulo' => 'Token de acesso inválido',
                'msg' => 'Caso tenha feito o resete da senha, solicite uma nova senha.'
            );

            echo json_encode($msg);

        } elseif ($usuario == $row_usuario['login_user']) {
            if (password_verify($senha_atual, $row_usuario['senha_user'])) {
                if ($nova_senha == $confirmar_senha) {
                    //token de acesso
                    $bytes = random_bytes(32);
                    $token_up = hash('sha256', $bytes);
                    //update para alterar a senha do usuário
                    $up_senha = "UPDATE usuarios SET senha_user = '$confirmar_senha_crip', token='$token_up', situacoes_usuario_id= 5, modificado_user = NOW(), ult_token = NOW() WHERE id_user = '{$row_usuario['id_user']}' LIMIT 1 ";
                    $query_up_senha = mysqli_query($conn, $up_senha);
                    if (mysqli_affected_rows($conn) != 0) {
                        //salvar o historico de alteração de senha
                        $cad_hist_senha = "INSERT INTO hist_senha (usuario_id, operador, evento_senha_id, created_hist_senha) VALUES ('{$row_usuario['id_user']}', '{$row_usuario['id_user']}', 1, NOW())";
                        $query_cad_hist_senha = mysqli_query($conn, $cad_hist_senha);
                        //mensagem
                        if (mysqli_insert_id($conn)) {

                            $msg = array(
                                'tipo' => 'success',
                                'titulo' => 'Senha redefinida',
                                'msg' => 'Aguarde você será redirecionado para tela de login',
                                'url' => pg . '/login.php'
                            );

                            echo json_encode($msg);
                        } else {
                            $msg = array(
                                'tipo' => 'success',
                                'titulo' => 'Senha redefinida',
                                'msg' => 'Aguarde você será redirecionado para tela de login',
                                'url' => pg . '/login.php'
                            );

                            echo json_encode($msg);
                        }
                    } else {

                        $msg = array(
                            'tipo' => 'error',
                            'titulo' => 'Ops...',
                            'msg' => 'Erro ao alterar a senha'
                        );

                        echo json_encode($msg);
                    }
                } else {

                    $msg = array(
                        'tipo' => 'info',
                        'titulo' => 'Ops...',
                        'msg' => 'Senha digitada é diferente da senha de confirmação'
                    );

                    echo json_encode($msg);
                }
            } else {

                $msg = array(
                    'tipo' => 'info',
                    'titulo' => 'Ops...',
                    'msg' => 'Senha atual não confere'
                );

                echo json_encode($msg);
            }
        } else {

            $msg = array(
                'tipo' => 'error',
                'titulo' => 'Ops...',
                'msg' => 'Error de processamento, tente novamente.'
            );

            echo json_encode($msg);
        }
    } else {

        $msg = array(
            'tipo' => 'error',
            'titulo' => 'Ops...',
            'msg' => 'Usuário não encontrado.'
        );

        echo json_encode($msg);
    }
}
