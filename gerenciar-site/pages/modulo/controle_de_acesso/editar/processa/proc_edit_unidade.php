<?php
if (!isset($seguranca)) {
    exit;
}
$sendEditarUnidade = filter_input(INPUT_POST, 'sendEditarUnidade', FILTER_DEFAULT);
if($sendEditarUnidade){
    $sigla_uni      = filter_input(INPUT_POST, 'sigla_uni', FILTER_DEFAULT);
    $nome_uni       = filter_input(INPUT_POST, 'nome_uni', FILTER_DEFAULT);
    $descrico_uni   = filter_input(INPUT_POST, 'descrico_uni', FILTER_DEFAULT);
    $endereco       = filter_input(INPUT_POST, 'endereco', FILTER_DEFAULT);
    $horario        = filter_input(INPUT_POST, 'horario', FILTER_DEFAULT);
    $pai            = filter_input(INPUT_POST, 'pai', FILTER_SANITIZE_NUMBER_INT);
    $unidade        = filter_input(INPUT_POST, 'unidade', FILTER_SANITIZE_NUMBER_INT);
    //query para alterar dados da unidade
    $edit_unidade = "UPDATE unidade SET 
      nome_uni='$nome_uni', 
      sigla_uni='$sigla_uni', 
      descricao_uni='$descrico_uni', 
      endereco='$endereco',
      horario='$horario',
      grupo_id='$pai', 
      modificado_uni=NOW() WHERE id_uni = '$unidade' 
    ";
    $query_edit_unidade = mysqli_query($conn, $edit_unidade);
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
        $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_unidade?unidade=$unidade";
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
        $url_destino = pg . "/pages/modulo/controle_de_acesso/editar/edit_unidade?unidade=$unidade";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }   
} else {
        $url_destino = pg . "/pages/modulo/404/404";
        echo '<script> location.replace("' . $url_destino . '"); </script>'; 
}

