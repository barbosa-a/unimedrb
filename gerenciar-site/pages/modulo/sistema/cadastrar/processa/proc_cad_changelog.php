<?php
if (!isset($seguranca)) {
    exit;
}
$sendCadastrarChangelog = filter_input(INPUT_POST, 'sendCadastrarChangelog', FILTER_DEFAULT);

if($sendCadastrarChangelog){
    $descricao         = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT);
    $versao            = filter_input(INPUT_POST, 'versao', FILTER_SANITIZE_NUMBER_INT);
    $categoria         = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_NUMBER_INT);
    
    $cad_changelog= "INSERT INTO changelog 
        (versoes_id, categoria_versao_id, usuario_id, descricao, created)
            VALUES 
        ('$versao', '$categoria', '".$_SESSION['usuarioID']."', '$descricao', NOW())";
    $query_cad_changelog = mysqli_query($conn, $cad_changelog);
    if(mysqli_insert_id($conn)){
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
                      <p class="text-center">Changelog cadastrado com sucesso.</p>
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
                      <p class="text-center">Erro ao cadastrar changelog.</p>
                      <code>'.mysqli_error($conn).'</code>
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