<?php
if (!isset($seguranca)) {
    exit;
}
$sendEditarGrupo = filter_input(INPUT_POST, 'sendEditarGrupo', FILTER_SANITIZE_STRING);
if($sendEditarGrupo){
    $nome_gru         = filter_input(INPUT_POST, 'nome_gru', FILTER_SANITIZE_STRING);
    $descricao_gru    = filter_input(INPUT_POST, 'descricao_gru', FILTER_SANITIZE_STRING);
    $pai              = filter_input(INPUT_POST, 'pai', FILTER_SANITIZE_NUMBER_INT);
    $grupo            = filter_input(INPUT_POST, 'grupo', FILTER_SANITIZE_NUMBER_INT);
    //consultar cargo e verificar se ja existe cadastrado
    $cons_grupo = "SELECT * FROM grupo WHERE nome_gru = '$nome_gru' ";
    $query_cons_grupo = mysqli_query($conn, $cons_grupo);
    if(($query_cons_grupo) AND ($query_cons_grupo->num_rows !=0)){
        $_SESSION['msg'] = '
            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Atenção!</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Registro já cadastrado.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_grupo?grupo=$grupo";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } else {
        $edit_grupo = "UPDATE grupo SET nome_gru='$nome_gru', descricao_gru='$descricao_gru', grupo_pai_id='$pai', modificado_gru=NOW() WHERE id_gru = '$grupo' ";
        $query_edit_grupo = mysqli_query($conn, $edit_grupo);
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
                          <p class="text-center">Registro salvo com sucesso.</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                      </div>
                    </div>
                </div>
            ';
            $url_destino = pg . "/pages/modulo/controle_de_acesso/controle_de_acesso";
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
                          <p class="text-center">Não foi possivel cadastrar, tente novamente.</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                      </div>
                    </div>
                </div>
            ';
            $url_destino = pg . "/pages/modulo/controle_de_acesso/controle_de_acesso";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
        }
    }    
} else {
  $url_destino = pg . "/pages/modulo/404/404";
  echo '<script> location.replace("' . $url_destino . '"); </script>'; 
}

