<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
include_once("../../../../../lib/lib_funcoes.php");
include_once("../../../../../lib/lib_botoes.php");

$nome_completo  = filter_input(INPUT_POST, 'nome_completo', FILTER_DEFAULT);
$email          = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
$usuario        = filter_input(INPUT_POST, 'usuario', FILTER_DEFAULT);
$senha          = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
$senha_crip     = password_hash($senha, PASSWORD_DEFAULT);
$unidade        = filter_input(INPUT_POST, 'unidade', FILTER_DEFAULT);
$status         = filter_input(INPUT_POST, 'status', FILTER_DEFAULT);
$perfil_acesso  = filter_input(INPUT_POST, 'perfil_acesso', FILTER_DEFAULT);
$anotacao       = filter_input(INPUT_POST, 'anotacao', FILTER_DEFAULT);
$cargo          = filter_input(INPUT_POST, 'cargo', FILTER_DEFAULT);
$sendEmail      = filter_input(INPUT_POST, 'sendEmail', FILTER_DEFAULT);
//Validar campo senha e retirar os espaços em branco
$senha_sem_espaco = str_replace(" ", "", $senha_crip);
//Verificar se o usuário esta cadastrado no banco de dados
$verifica_registro_user = "SELECT * FROM usuarios WHERE login_user = '$usuario' ";
$query_verifica_registro_user = mysqli_query($conn, $verifica_registro_user);
//Verificar se o email esta cadastrado no banco de dados
$verifica_registro_email = "SELECT * FROM usuarios WHERE email_user = '$email' ";
$query_verifica_registro_email = mysqli_query($conn, $verifica_registro_email);
//Verificar a quantidade de usuários disponiveis
$cons_contrato = "SELECT 
        c.qtd_usuarios_liberados AS usuarios_permitidos,
        COUNT(u.id_user) AS total_cadastrados
      FROM 
        contrato_sistema c
      INNER JOIN usuarios u
      ON u.contrato_sistema_id = c.idcontratosistema
      WHERE c.idcontratosistema = '{$_SESSION['contratoID']}'
      HAVING COUNT(u.id_user) < c.qtd_usuarios_liberados";
$query_cons_contrato = mysqli_query($conn, $cons_contrato);
//Validar a quantidade de caracteres no campo senha    
if ((strlen($senha_sem_espaco)) < 6) {
  $arr = array('tipo' => 'info', 'titulo' => 'Atenção', 'msg' => 'Senha deve ter no minimo 6 caracteres.');
  echo json_encode($arr);
} elseif (($query_verifica_registro_user) and ($query_verifica_registro_user->num_rows != 0)) {
  $arr = array('tipo' => 'info', 'titulo' => 'Atenção', 'msg' => 'Já existe um usuário cadastrado com este login.');
  echo json_encode($arr);
} elseif (($query_verifica_registro_email) and ($query_verifica_registro_email->num_rows != 0)) {
  $arr = array('tipo' => 'info', 'titulo' => 'Atenção', 'msg' => 'Já existe um usuário cadastrado com este e-mail.');
  echo json_encode($arr);
} else {
  //token de acesso
  $bytes = random_bytes(32);
  $token = hash('sha256', $bytes);
  if ($_SESSION['contratoUSER'] == null) {
    $cad_user = "INSERT INTO usuarios 
            (nome_user, email_user, login_user, senha_user, token, niveis_acesso_id, situacoes_usuario_id, cargo_id, unidade_id, usuario_id, anotacao, usuarios_autenticacao_id, criado_user, ult_token) 
            VALUES 
            ('$nome_completo', '$email', '$usuario', '$senha_crip', '$token', '$perfil_acesso', '$status', '$cargo', '$unidade', '{$_SESSION['usuarioID']}', '$anotacao', 2, NOW(), NOW())";
    $query_cad_user = mysqli_query($conn, $cad_user);
    //verificar se foi salvo no banco de dados
    if (mysqli_insert_id($conn)) {
      //pegar o id do usuario cadastrado
      $ult_id_usuario = mysqli_insert_id($conn);
      //salvar o historico de alteração de senha
      $cad_hist_senha = "INSERT INTO hist_senha (usuario_id, operador, evento_senha_id, created_hist_senha) VALUES ('$ult_id_usuario', '{$_SESSION['usuarioID']}', '3', NOW())";
      $query_cad_hist_senha = mysqli_query($conn, $cad_hist_senha);
      //mensagem
      if (mysqli_affected_rows($conn) != 0) {

        $arr = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => "Conta do usuário criada! Solicitar ao usuário que altere a senha no próximo login.", "id" => $ult_id_usuario, "senha" => $senha, "modulo" => 1, "sendemail" => $sendEmail);
        echo json_encode($arr);
      } else {
        $msg_erro = mysqli_error($conn);
        $arr = array('tipo' => 'info', 'titulo' => 'Atenção', 'msg' => 'Historico de criação de senha não registrado.');
        echo json_encode($arr);
      }
    } else {
      $msg_erro = mysqli_error($conn);

      $arr = array('tipo' => 'error', 'titulo' => 'Atenção', 'msg' => 'Conta de usuário não registrada.');
      echo json_encode($arr);
    }
  } else {
    if (($query_cons_contrato) and ($query_cons_contrato->num_rows != 0)) {
      //Instrução para salvar no banco de dados
      $cad_user = "INSERT INTO usuarios 
              (nome_user, email_user, login_user, senha_user, token, niveis_acesso_id, situacoes_usuario_id, cargo_id, unidade_id, usuario_id, contrato_sistema_id, anotacao, usuarios_autenticacao_id, criado_user, ult_token) 
              VALUES 
              ('$nome_completo', '$email', '$usuario', '$senha_crip', '$token', '$perfil_acesso', '$status', '$cargo', '$unidade', '{$_SESSION['usuarioID']}', '{$_SESSION['contratoID']}', '$anotacao', 2, NOW(), NOW())";
      $query_cad_user = mysqli_query($conn, $cad_user);
      //verificar se foi salvo no banco de dados
      if (mysqli_insert_id($conn)) {
        //pegar o id do usuario cadastrado
        $ult_id_usuario = mysqli_insert_id($conn);
        //salvar o historico de alteração de senha
        $cad_hist_senha = "INSERT INTO hist_senha (usuario_id, operador, evento_senha_id, created_hist_senha) VALUES ('$ult_id_usuario', '{$_SESSION['usuarioID']}', 3, NOW())";
        $query_cad_hist_senha = mysqli_query($conn, $cad_hist_senha);
        //mensagem
        if (mysqli_affected_rows($conn) != 0) {
          $arr = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => "Conta do usuário criada! Solicitar ao usuário que altere a senha no próximo login.", "id" => $ult_id_usuario, "senha" => $senha, "modulo" => 1, "sendemail" => $sendEmail);
          echo json_encode($arr);
        } else {
          $msg_erro = mysqli_error($conn);
          $arr = array('tipo' => 'info', 'titulo' => 'Atenção', 'msg' => 'Historico de criação de senha não registrado.');
          echo json_encode($arr);
        }
      } else {
        $msg_erro = mysqli_error($conn);
        $arr = array('tipo' => 'error', 'titulo' => 'Atenção', 'msg' => 'Conta de usuário não registrada.');
        echo json_encode($arr);
      }
    } else {
      $arr = array('tipo' => 'info', 'titulo' => 'Atenção', 'msg' => 'Limite de usuários excedido para este contrato.');
      echo json_encode($arr);
    }
  }
}
