<?php
if (!isset($seguranca)) {
    exit;
}
$SendEditModulo = filter_input(INPUT_POST, 'SendEditModulo', FILTER_DEFAULT);

if($SendEditModulo){
    $nome       = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
    $chave      = filter_input(INPUT_POST, 'chave', FILTER_DEFAULT);
    $descricao  = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT);
    $status     = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
    $modulo     = filter_input(INPUT_POST, 'modulo', FILTER_SANITIZE_NUMBER_INT);
    
    $up_modulo = "UPDATE modulos SET nome_mod = '$nome', chave_mod = '$chave', descricao_mod = '$descricao', permissao_mod = '$status', modifield_mod = NOW() WHERE id_mod = '$modulo' ";
    $query_up_modulo = mysqli_query($conn, $up_modulo);
    if(mysqli_affected_rows($conn) !=0){
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
                      <p class="text-center">Modulo <code>'.$chave.'</code> atualizado.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/sistema/editar/edit_modulo?modulo=$modulo";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }else{
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
                      <p class="text-center">Erro ao salvar.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/sistema/editar/edit_modulo?modulo=$modulo";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}