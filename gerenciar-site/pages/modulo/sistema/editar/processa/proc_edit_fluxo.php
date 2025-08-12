<?php
if (!isset($seguranca)) {
    exit;
}
$sendEditFluxo = filter_input(INPUT_POST, 'sendEditFluxo', FILTER_DEFAULT);

if($sendEditFluxo){
    $nome_processo = filter_input(INPUT_POST, 'nome_processo', FILTER_DEFAULT);
    $fluxo  = filter_input(INPUT_POST, 'fluxo', FILTER_SANITIZE_NUMBER_INT);
    $modulo = filter_input(INPUT_POST, 'modulo', FILTER_SANITIZE_NUMBER_INT);
    $menu   = filter_input(INPUT_POST, 'menu', FILTER_SANITIZE_NUMBER_INT);
    $objeto = filter_input(INPUT_POST, 'objeto', FILTER_SANITIZE_NUMBER_INT);
    $endereco_fluxo  = filter_input(INPUT_POST, 'endereco_fluxo', FILTER_DEFAULT);
    $icone                  = filter_input(INPUT_POST, 'icone', FILTER_DEFAULT);
    
    try {
      $edit_fluxo = "
        UPDATE 
          paginas p 
        INNER JOIN 
          niveis_acessos_paginas npg 
        ON 
          npg.pagina_id = p.id_pg 
        SET 
          p.icon = '$icone',
          p.endereco_pg = '$endereco_fluxo', 
          p.nome_pg = '$nome_processo', 
          p.menu_lateral = '$menu', 
          npg.menu = '$menu',
          p.objeto_id = '$objeto', 
          p.modulo_id = '$modulo', 
          p.modificado_pg = NOW(),
          npg.modificado_nvl_pg = NOW()
        WHERE 
          p.id_pg = '$fluxo' ";
      $query_edit_fluxo = mysqli_query($conn, $edit_fluxo);

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
        $url_destino = pg . "/pages/modulo/sistema/editar/edit_fluxo?operacao=$fluxo";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } catch (Exception $e) {
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
                      <p class="text-center">Erro ao atualizar registro, tente novamente. <br> '.$e->getMessage().'</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/sistema/editar/edit_fluxo?operacao=$fluxo";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
    
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}