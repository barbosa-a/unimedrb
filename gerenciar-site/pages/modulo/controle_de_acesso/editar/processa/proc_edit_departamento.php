<?php
if (!isset($seguranca)) {
    exit;
}
$sendEditaDepartamento = filter_input(INPUT_POST, 'sendEditaDepartamento', FILTER_DEFAULT);
if($sendEditaDepartamento){
    $nome_depar         = filter_input(INPUT_POST, 'nome_depar', FILTER_DEFAULT);
    $descricao_depar    = filter_input(INPUT_POST, 'descricao_depar', FILTER_DEFAULT);
    $departamento       = filter_input(INPUT_POST, 'departamento', FILTER_SANITIZE_NUMBER_INT);
    //query para fazer o update dos dados
    $edit_depar = "UPDATE departamento SET nome_depar='$nome_depar', descricao_depar='$descricao_depar', modificado_depar=NOW() WHERE id_depar = '$departamento' ";
    $query_edit_depar = mysqli_query($conn, $edit_depar);
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
                      <p class="text-center">Departamento alterado.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_departamento?departamento=$departamento";
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
                      <p class="text-center">Erro ao atualizar departamento, tente novamente.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_departamento?departamento=$departamento";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } 
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>'; 
}

