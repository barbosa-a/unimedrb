<?php
    session_start();
    //segurança do ADM
    $seguranca = true;    
    //Biblioteca auxiliares
    include_once("../../../../config/config.php");
    include_once("../../../../config/conexao.php");
    include_once("../../../../lib/lib_funcoes.php");
    include_once("../../../../lib/lib_timezone.php");
    
  $dados        = filter_input_array(INPUT_POST, FILTER_DEFAULT);
  $senha_crip   = password_hash($dados['confirmar_senha'], PASSWORD_DEFAULT);
  $usuario      = $_SESSION['usuarioID'];

  if((empty($dados['senha_atual'])) OR (empty($dados['nova_senha'])) OR (empty($dados['confirmar_senha']))){

    $msg = array('tipo' => 'info', 'titulo' => 'Campos vazios', 'msg' => 'Necessário preencher todos os campos');
    echo json_encode($msg);

  }else{

      //verificar se a senha atual é igual a senha digitada
      $cons_user = "SELECT * FROM usuarios WHERE id_user = '{$_SESSION['usuarioID']}' ";
      $query_cons_user = mysqli_query($conn, $cons_user);
      $rowUser = mysqli_fetch_assoc($query_cons_user);

      if ($rowUser['usuarios_autenticacao_id'] == 1) {

        $msg = array('tipo' => 'info', 'titulo' => 'Não autorizado', 'msg' => 'Usuário vinculado API');
        echo json_encode($msg);

      }elseif(password_verify($dados['senha_atual'], $rowUser['senha_user'])){

          //verificar se as senhas são iguais
          if($dados['confirmar_senha'] == $dados['nova_senha']){

              //token de acesso
              $bytes = random_bytes(32);
              $token = hash('sha256', $bytes);

              //update para alterar a senha do usuário
              $up_senha = "UPDATE usuarios SET senha_user = '$senha_crip', token='$token', situacoes_usuario_id = 5, modificado_user = NOW(), ult_token = NOW() WHERE id_user = '$usuario' LIMIT 1 ";
              $query_up_senha = mysqli_query($conn, $up_senha);

              if(mysqli_affected_rows($conn) != 0){

                  //salvar o historico de alteração de senha
                  $cad_hist_senha = "INSERT INTO hist_senha (usuario_id, operador, evento_senha_id, created_hist_senha) VALUES ('$usuario', '{$_SESSION['usuarioID']}', 1, NOW())";
                  $query_cad_hist_senha = mysqli_query($conn, $cad_hist_senha);

                  //mensagem
                  if(mysqli_insert_id($conn)){

                    $msg = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Nova senha cadastrada com sucesso');
                    echo json_encode($msg);

                  } else {

                    $msg = array('tipo' => 'info', 'titulo' => 'Senha cadastrada', 'msg' => 'Erro ao registrar histórico');
                    echo json_encode($msg);

                  }
              }else{

                $msg = array('tipo' => 'error', 'titulo' => 'Senha não alterada', 'msg' => 'Erro ao registrar nova senha '+ mysqli_error($conn));
                echo json_encode($msg);

              }
          } else {

            $msg = array('tipo' => 'info', 'titulo' => 'Senha incorreta', 'msg' => 'As senhas digitadas não são iguais');
            echo json_encode($msg);

          }
      } else {

        $msg = array('tipo' => 'info', 'titulo' => 'Senha incorreta', 'msg' => 'Senha atual está incorreta');
        echo json_encode($msg);
        
      }            
  }