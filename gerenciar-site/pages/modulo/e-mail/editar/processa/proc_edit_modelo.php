<?php
if (!isset($seguranca)) {
    exit;
}
$SendEditModeloEmail = filter_input(INPUT_POST, 'SendEditModeloEmail', FILTER_DEFAULT);

if($SendEditModeloEmail){
    $titulo            = filter_input(INPUT_POST, 'titulo', FILTER_DEFAULT);
    $modulo            = filter_input(INPUT_POST, 'modulo', FILTER_DEFAULT);
    $texto             = filter_input(INPUT_POST, 'texto', FILTER_DEFAULT);
    $id                = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);

    // Atualizar dados SMTP
    $up = "UPDATE email_modelos SET modulo_id = '$modulo', titulo = '$titulo', texto = '$texto', usuario_id_at = '{$_SESSION['usuarioID']}', modifield_at = NOW() WHERE id = '$id' ";
    $query_up = mysqli_query($conn, $up);
    if(mysqli_affected_rows($conn) > 0){
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
                      <p class="text-center">Registro atualizado com sucesso.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/e-mail/e-mail";
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
                      <p class="text-center">Erro ao atualizar registro.</p>
                      <code>'.mysqli_error($conn).'</code>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/e-mail/e-mail";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }    
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}