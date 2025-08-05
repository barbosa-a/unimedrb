<?php

if (!isset($seguranca)) {
    exit;
}
$SendUpPerfil = filter_input(INPUT_POST, 'SendUpPerfil', FILTER_DEFAULT);
//Verificar se a variavel possui um valor
if ($SendUpPerfil) {
    $nome_completo = filter_input(INPUT_POST, 'nome_completo', FILTER_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
    //$login_user = filter_input(INPUT_POST, 'login_user', FILTER_SANITIZE_STRING);
    //$unidade = filter_input(INPUT_POST, 'unidade', FILTER_SANITIZE_NUMBER_INT);
    //$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
    //$perfil_acesso = filter_input(INPUT_POST, 'perfil_acesso', FILTER_SANITIZE_NUMBER_INT);
    //$anotacao = filter_input(INPUT_POST, 'anotacao', FILTER_SANITIZE_STRING);
    //$cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_NUMBER_INT);
    //$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_NUMBER_INT);
    //echo $usuario;
    
    $edit_usuario = "UPDATE usuarios SET nome_user = '$nome_completo', email_user = '$email', modificado_user=NOW() WHERE id_user = '{$_SESSION['usuarioID']}' ";
    $query_edit_usuario = mysqli_query($conn, $edit_usuario);
    if (mysqli_affected_rows($conn) != 0) {
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
                      <p class="text-center">Conta do usuário ' . $login_user . ' atualizada.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/meu_perfil/perfil";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } else {
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
                      <p class="text-center">Erro ao atualizar conta do usuário ' . $login_user . '.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/meu_perfil/perfil";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
} else {
    $url_destino = pg . "/error";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}