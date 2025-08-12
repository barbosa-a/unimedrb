<?php
if (!isset($seguranca)) {
    exit;
}
$SendCadOperacao = filter_input(INPUT_POST, 'SendCadOperacao', FILTER_DEFAULT);

if($SendCadOperacao){
    $nome_processo          = filter_input(INPUT_POST, 'nome_processo', FILTER_DEFAULT);
    $modulo                 = filter_input(INPUT_POST, 'modulo', FILTER_SANITIZE_NUMBER_INT);
    $endereco_fluxo         = filter_input(INPUT_POST, 'endereco_fluxo', FILTER_DEFAULT);
    $menu                   = filter_input(INPUT_POST, 'menu', FILTER_SANITIZE_NUMBER_INT);
    $objeto                 = filter_input(INPUT_POST, 'objeto', FILTER_SANITIZE_NUMBER_INT);
    $ordem                  = filter_input(INPUT_POST, 'ordem', FILTER_SANITIZE_NUMBER_INT);
    $icone                  = filter_input(INPUT_POST, 'icone', FILTER_DEFAULT);
    $pagina                 = filter_input(INPUT_POST, 'pagina', FILTER_DEFAULT);
    $subpagina              = empty($pagina) ? 0 : $pagina;

    try {
      
      $cad_pg = "INSERT INTO paginas 
        (icon, endereco_pg, nome_pg, menu_lateral, objeto_id, modulo_id, pagina_id, usuario_id, ordem_menu, criado_pg)
            VALUES 
        ('$icone', '$endereco_fluxo', '$nome_processo', '$menu', '$objeto', '$modulo', '$subpagina', '{$_SESSION['usuarioID']}', '$ordem', NOW())
      ";
      $query_cad_pg = mysqli_query($conn, $cad_pg);

      $ultpg = mysqli_insert_id($conn);

      //consultar niveis de acesso
      $consNvl = "SELECT * FROM niveis_acessos";
      $query_consNVL = mysqli_query($conn, $consNvl);
      while ($nvl = mysqli_fetch_array($query_consNVL)) {
        //verificar permissao
        if($nvl['id_nvl'] == 1){
            $permissao = 1;
        } else {
            $permissao = 2;
        }
        //pegar a ultima ordem
        $consOrdemNVL = "SELECT ordem FROM niveis_acessos_paginas WHERE niveis_acesso_id = '{$nvl['id_nvl']}' ORDER BY id_nvl_pg DESC LIMIT 1 ";
        $query_consOrdemNVL = mysqli_query($conn, $consOrdemNVL);
        $ordemNVL = mysqli_fetch_assoc($query_consOrdemNVL);
        $ultOrdem = $ordemNVL['ordem'] + 1;
        //cadastrar permissoes
        $cadPermissao = "INSERT INTO niveis_acessos_paginas
            (niveis_acesso_id, pagina_id, permissao, menu, ordem, criado_nvl_pg) 
                VALUES 
            ('{$nvl['id_nvl']}', '$ultpg', '$permissao', '$menu', '$ultOrdem', NOW())";
        $query_cadPermissao = mysqli_query($conn, $cadPermissao);
      }

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
                  <p class="text-center">Operação cadastrada.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
              </div>
            </div>
        </div>
      ';
      $url_destino = pg . "/pages/modulo/sistema/sistema";
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
                <p class="text-center">Erro ao operação <br> '.$e->getMessage().'</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
              </div>
            </div>
          </div>
        </div>
      ';
      $url_destino = pg . "/pages/modulo/sistema/sistema";
      echo '<script> location.replace("' . $url_destino . '"); </script>';
    }

} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}