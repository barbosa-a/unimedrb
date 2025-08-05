<?php
if (!isset($seguranca)) {
    exit;
}
$sendCadastraDepartamento = filter_input(INPUT_POST, 'sendCadastraDepartamento', FILTER_DEFAULT);
if($sendCadastraDepartamento){
    $nome_depar       = filter_input(INPUT_POST, 'nome_depar', FILTER_DEFAULT);
    $descricao_depar  = filter_input(INPUT_POST, 'descricao_depar', FILTER_DEFAULT);
    //Verificar se o grupo ja existe cadastrado no banco de dados
    $verifica_registro_depar = "SELECT * FROM departamento WHERE nome_depar = '$nome_depar' AND contrato_sistema_id = '{$_SESSION['contratoUSER']}' LIMIT 1 ";
    $query_verifica_registro_depar = mysqli_query($conn, $verifica_registro_depar);
    if(($query_verifica_registro_depar) AND ($query_verifica_registro_depar->num_rows !=0)){
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
                      <p class="text-center">Departamento: <br>'.$nome_depar.'<br> já cadastrado.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_departamento";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } else {
      
      try {
        $cad_depar = "INSERT INTO departamento 
          (nome_depar, descricao_depar, contrato_sistema_id, usuario_id, criado_depar) 
            VALUES 
          ('$nome_depar', '$descricao_depar', '{$_SESSION['contratoUSER']}', '{$_SESSION['usuarioID']}', NOW())
        ";
        $query_cad_depar = mysqli_query($conn, $cad_depar);

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
                      <p class="text-center">Departamento: <br>' . $nome_depar . '<br> Registrado com sucesso</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_departamento";
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
                      <p class="text-center">Erro ao cadastrar departamento <br> ' . $err->getMessage() . '</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                  </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_departamento";
        //header("Location: $url_destino");
        echo '<script> location.replace("' . $url_destino . '"); </script>';

      }

    }
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    //header("Location: $url_destino");
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}

?>