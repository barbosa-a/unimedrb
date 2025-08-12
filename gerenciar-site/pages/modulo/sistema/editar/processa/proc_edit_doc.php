<?php
if (!isset($seguranca)) {
    exit;
}
$id  = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);

if($id){
    
    $assunto  = filter_input(INPUT_POST, 'assunto', FILTER_DEFAULT);
    $documentar = filter_input(INPUT_POST, 'documentar', FILTER_DEFAULT);
    
    
    $edit_fluxo = "UPDATE 
        apis_documentacao
      SET 
      assunto = '$assunto', 
      documentacao = '$documentar', 
      usuario_id_at = '{$_SESSION['usuarioID']}',
      modifield_at = NOW()
      WHERE 
        id= '$id' ";
    $query_edit_fluxo = mysqli_query($conn, $edit_fluxo);
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
                      <p class="text-center">Registro alterado com sucesso</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/sistema/editar/edit_doc?id=$id";
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
                      <p class="text-center">Erro ao atualizar registro, tente novamente. <br> '.die('Retorno: '.mysqli_error($conn)).'</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/sistema/editar/edit_doc?id=$id";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}