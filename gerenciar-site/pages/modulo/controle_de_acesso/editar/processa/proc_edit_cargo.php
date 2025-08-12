<?php
if (!isset($seguranca)) {
    exit;
}
$sendEditarCargo = filter_input(INPUT_POST, 'sendEditarCargo', FILTER_SANITIZE_STRING);
if($sendEditarCargo){
    $nome_cargo         = filter_input(INPUT_POST, 'nome_cargo', FILTER_SANITIZE_STRING);
    $departamento       = filter_input(INPUT_POST, 'departamento', FILTER_SANITIZE_STRING);
    $descricao_cargo    = filter_input(INPUT_POST, 'descricao_cargo', FILTER_SANITIZE_STRING);
    $cargo              = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_NUMBER_INT);
    $edit_cargo = "UPDATE cargo SET nome_cargo='$nome_cargo', departamento='$departamento', descricao_cargo='$descricao_cargo', modificado_cargo=NOW() WHERE id_cargo = '$cargo' ";
    $query_edit_cargo = mysqli_query($conn, $edit_cargo);
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
                      <p class="text-center">Cargo alterado.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_cargo?cargo=$cargo";
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
                      <p class="text-center">Erro ao atualizar cargo, tente novamente.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_cargo?cargo=$cargo";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } 
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>'; 
}

