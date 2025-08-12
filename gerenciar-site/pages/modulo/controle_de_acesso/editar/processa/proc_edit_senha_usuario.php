<?php
if (!isset($seguranca)) {
  exit;
}
$sendRedefinirSenha = filter_input(INPUT_POST, 'sendRedefinirSenha', FILTER_DEFAULT);
//Verificar se a variavel possui um valor
if ($sendRedefinirSenha) {
  $nova_senha         = filter_input(INPUT_POST, 'nova_senha', FILTER_DEFAULT);
  $confirmar_senha    = filter_input(INPUT_POST, 'confirmar_senha', FILTER_DEFAULT);
  $senha_crip         = password_hash($confirmar_senha, PASSWORD_DEFAULT);
  $usuario            = filter_input(INPUT_POST, 'usuario', FILTER_DEFAULT);
  if ((empty($nova_senha)) or (empty($confirmar_senha))) {
    $_SESSION['msg'] = '
                <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="staticBackdropLabel">Erro!</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="text-center">Necessário preencher todos os campos.</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                      </div>
                    </div>
                </div>
            ';
    $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_usuario?usuario=$usuario";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
  } else {
    //verificar se as senhas são iguais
    if ($confirmar_senha == $nova_senha) {

      //Consultar usuario
      $cons_usuario = "SELECT id_user, usuarios_autenticacao_id FROM usuarios WHERE token = '$usuario' LIMIT 1 ";
      $query_cons_usuario = mysqli_query($conn, $cons_usuario);

      if (($query_cons_usuario) and ($query_cons_usuario->num_rows > 0)) {

        $row_usuario = mysqli_fetch_assoc($query_cons_usuario);

        if ($row_usuario['usuarios_autenticacao_id'] == 1) {
          $_SESSION['msg'] = '
                    <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="staticBackdropLabel">Erro!</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p class="text-center">Não autorizado <br> Usuário vinculado API</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                            </div>
                          </div>
                        </div>
                    </div>
                ';
          $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_usuario?usuario=$usuario";
          echo '<script> location.replace("' . $url_destino . '"); </script>';
        } else {
          //token de acesso
          //$bytes = random_bytes(32);
          //$token = hash('sha256', $bytes);
          //update para alterar a senha do usuário
          $up_senha = "UPDATE usuarios SET senha_user = '$senha_crip', situacoes_usuario_id = 3, modificado_user = NOW(), ult_token = NOW() WHERE token = '$usuario' LIMIT 1 ";
          $query_up_senha = mysqli_query($conn, $up_senha);
          if (mysqli_affected_rows($conn) != 0) {
            //salvar o historico de alteração de senha
            $cad_hist_senha = "INSERT INTO hist_senha (usuario_id, operador, evento_senha_id, created_hist_senha) VALUES ('{$row_usuario['id_user']}', '{$_SESSION['usuarioID']}', 2, NOW())";
            $query_cad_hist_senha = mysqli_query($conn, $cad_hist_senha);
            //mensagem
            if (mysqli_insert_id($conn)) {
              $_SESSION['msg'] = '
                            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="staticBackdropLabel">Sucesso!</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p class="text-center">Nova senha cadastrada.</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        ';
              $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_usuario?usuario=$usuario";
              echo '<script> location.replace("' . $url_destino . '"); </script>';
            } else {
              $_SESSION['msg'] = '
                            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="staticBackdropLabel">Error!</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <p class="text-center">Error, senha cadastrada. Mas historico não atualizado.</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        ';
              $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_usuario?usuario=$usuario";
              echo '<script> location.replace("' . $url_destino . '"); </script>';
            }
          } else {
            $_SESSION['msg'] = '
                        <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="staticBackdropLabel">Error!</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p class="text-center">Não foi possivel alterar a senha do usuário.</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                </div>
                              </div>
                            </div>
                        </div>
                    ';
            $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_usuario?usuario=$usuario";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
          }
        }

      } else {
        $_SESSION['msg'] = '
                    <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="staticBackdropLabel">Error!</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p class="text-center">Usuário não encontrado.</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                            </div>
                          </div>
                        </div>
                    </div>
                ';
      $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_usuario?usuario=$usuario";
      echo '<script> location.replace("' . $url_destino . '"); </script>';
      }
    } else {
      $_SESSION['msg'] = '
                    <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="staticBackdropLabel">Error!</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p class="text-center">As senhas não coincidem.</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                            </div>
                          </div>
                        </div>
                    </div>
                ';
      $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_usuario?usuario=$usuario";
      echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
  }
} else {
  $url_destino = pg . "/pages/modulo/404/404";
  echo '<script> location.replace("' . $url_destino . '"); </script>';
}
