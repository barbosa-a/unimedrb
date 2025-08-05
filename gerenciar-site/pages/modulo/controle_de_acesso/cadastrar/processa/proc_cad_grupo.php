<?php
if (!isset($seguranca)) {
    exit;
}
$sendCadastraGrupo = filter_input(INPUT_POST, 'sendCadastraGrupo', FILTER_DEFAULT);
if($sendCadastraGrupo){
    $nome_gru       = filter_input(INPUT_POST, 'nome_gru', FILTER_DEFAULT);
    $descricao_gru  = filter_input(INPUT_POST, 'descricao_gru', FILTER_DEFAULT);
    $pai            = filter_input(INPUT_POST, 'pai', FILTER_DEFAULT);
    //Verificar se o grupo ja existe cadastrado no banco de dados
    $verifica_registro_grupo = "SELECT * FROM grupo WHERE nome_gru = '$nome_gru' AND contrato_sistema_id = '{$_SESSION['contratoUSER']}' LIMIT 1 ";
    $query_verifica_registro_grupo = mysqli_query($conn, $verifica_registro_grupo);
    if(($query_verifica_registro_grupo) AND ($query_verifica_registro_grupo->num_rows !=0)){
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
                      <p class="text-center">Grupo <br>'.$nome_gru.'<br> já cadastrado.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_grupo";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } else {
      
      try {
        $cad_grupo = "INSERT INTO grupo 
          (nome_gru, descricao_gru, grupo_pai_id, contrato_sistema_id, usuario_id, criado_gru) 
            VALUES 
          ('$nome_gru', '$descricao_gru', '$pai', '{$_SESSION['contratoUSER']}', '{$_SESSION['usuarioID']}', NOW())
        ";
        $query_cad_grupo = mysqli_query($conn, $cad_grupo);

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
                      <p class="text-center">Grupo <br>' . $nome_gru . '<br> Registrado com sucesso</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_grupo";
        //header("Location: $url_destino");
        echo '<script> location.replace("' . $url_destino . '"); </script>';
      } catch (Exception $err) {
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
                      <p class="text-center">Erro ao cadastrar grupo <br> ' . $err->getMessage() . ' </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_grupo";
        //header("Location: $url_destino");
        echo '<script> location.replace("' . $url_destino . '"); </script>';
      }
    }
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    //header("Location: $url_destino");
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}

