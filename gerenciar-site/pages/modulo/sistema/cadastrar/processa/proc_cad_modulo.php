<?php
if (!isset($seguranca)) {
    exit;
}
$SendCadModulo = filter_input(INPUT_POST, 'SendCadModulo', FILTER_DEFAULT);

if($SendCadModulo){
    $nome       = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
    $chave      = mb_strtolower(filter_input(INPUT_POST, 'chave', FILTER_DEFAULT));
    $descricao  = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT);
    $status     = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
    
    $cad_modulo = "INSERT INTO modulos (nome_mod, chave_mod, descricao_mod, permissao_mod, usuario_id, created_mod) VALUES ('$nome', '$chave', '$descricao', '$status', '".$_SESSION['usuarioID']."', NOW())";
    $query_cad_modulo = mysqli_query($conn, $cad_modulo);
    if(mysqli_insert_id($conn) !=0){
      //criar pasta do modulo
      $PastaModulo = mkdir('pages/modulo/'.slug($nome).'', 0777, true);
      // criar as subpastas do modulo: apagar, cadastrar, editar
      $apagar     = mkdir('pages/modulo/'.slug($nome).'/apagar', 0777, true);
      $cadastrar  = mkdir('pages/modulo/'.slug($nome).'/cadastrar', 0777, true);
      $editar     = mkdir('pages/modulo/'.slug($nome).'/editar', 0777, true);
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
                    <p class="text-center">Modulo <code>'.$chave.'</code> cadastrado.</p>
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
        $url_destino = pg . "/pages/modulo/sistema/sistema";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}