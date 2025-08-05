<?php
if (!isset($seguranca)) {
    exit;
}
$sendCadastrarPreco = filter_input(INPUT_POST, 'sendCadastrarPreco', FILTER_DEFAULT);

if($sendCadastrarPreco){
    $nome_pacote    = filter_input(INPUT_POST, 'nome_pacote', FILTER_DEFAULT);
    $plano          = filter_input(INPUT_POST, 'plano', FILTER_DEFAULT);
    $valor_preco    = filter_input(INPUT_POST, 'valor_preco', FILTER_DEFAULT);
    $valor_format = str_replace(".", "", $valor_preco);
    $valor_final = str_replace(",", ".", $valor_format);
    //echo $valor_final;
    $cad = "INSERT INTO planos_modelos 
        (nome_mod_plano, valor_plano, plano_id, usuario_id, created_modelo_plano)
            VALUES 
        ('$nome_pacote', '$valor_final',  '$plano', '".$_SESSION['usuarioID']."', NOW())";
    $query_cad = mysqli_query($conn, $cad);
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
                      <p class="text-center">Preço cadastrado com sucesso.</p>
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
                      <p class="text-center">Erro ao cadastrar preço, tente novamente..</p>
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