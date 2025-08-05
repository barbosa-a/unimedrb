<?php

if (!isset($seguranca)) {
    exit;
}
$sendCadastraUnidade = filter_input(INPUT_POST, 'sendCadastraUnidade', FILTER_DEFAULT);
//verificar se a variavelpossui algum valor
if ($sendCadastraUnidade) {
    $sigla_uni      = filter_input(INPUT_POST, 'sigla_uni', FILTER_DEFAULT);
    $nome_uni       = filter_input(INPUT_POST, 'nome_uni', FILTER_DEFAULT);
    $descrico_uni   = filter_input(INPUT_POST, 'descrico_uni', FILTER_DEFAULT);
    $pai            = filter_input(INPUT_POST, 'pai', FILTER_DEFAULT);
    //Verificar se a sigla ja existe cadastrada no banco de dados
    $verifica_registro_sigla_uni = "SELECT * FROM unidade WHERE sigla_uni = '$sigla_uni' AND contrato_sistema_id = '{$_SESSION['contratoUSER']}' ";
    $query_verifica_registro_sigla_uni = mysqli_query($conn, $verifica_registro_sigla_uni);
    //Verificar se o nome da unidade ja existe cadastrada no banco de dados
    $verifica_registro_nome_uni = "SELECT * FROM unidade WHERE nome_uni = '$nome_uni' AND contrato_sistema_id = '{$_SESSION['contratoUSER']}' ";
    $query_verifica_registro_nome_uni = mysqli_query($conn, $verifica_registro_nome_uni);
    if ((strlen($sigla_uni)) > 7) {
        $_SESSION['msg'] = '
            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Error!</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Quantidade permitida de 7 caracteres.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_unidade";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } elseif (($query_verifica_registro_sigla_uni) AND ($query_verifica_registro_sigla_uni->num_rows != 0)) {
        $_SESSION['msg'] = '
            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Error!</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Sigla precisar ser diferente.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_unidade";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } elseif (($query_verifica_registro_nome_uni) AND ($query_verifica_registro_nome_uni->num_rows != 0)) {
        $_SESSION['msg'] = '
            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Error!</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-center">Unidade já cadastrada, tente novamente.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_unidade";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } else {
      
      try {
        $cad_uni = "INSERT INTO unidade 
          (sigla_uni, nome_uni, descricao_uni, grupo_id, contrato_sistema_id, usuario_id, criado_uni) 
            VALUES 
          ('$sigla_uni', '$nome_uni', '$descrico_uni', '$pai', '{$_SESSION['contratoUSER']}', '{$_SESSION['usuarioID']}', NOW())";
        $query_cad_uni = mysqli_query($conn, $cad_uni);

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
                      <p class="text-center">Unidade cadastrada com sucesso.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_unidade";
        echo '<script> location.replace("' . $url_destino . '"); </script>';   
      } catch (Exception $err) {
        $_SESSION['msg'] = '
          <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Error!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p class="text-center">Error ao cadastrar unidade, tente novamente. <br> ' . $err->getMessage() . ' </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
          </div>
      ';
      $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_unidade";
      echo '<script> location.replace("' . $url_destino . '"); </script>';
      }
    }
} else {
    $url_destino = pg . "/error";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}

