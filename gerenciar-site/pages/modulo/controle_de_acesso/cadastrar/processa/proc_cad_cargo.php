<?php
if (!isset($seguranca)) {
  exit;
}
$sendCadastraCargo = filter_input(INPUT_POST, 'sendCadastraCargo', FILTER_DEFAULT);

if ($sendCadastraCargo) {
  $nome_cargo      = filter_input(INPUT_POST, 'nome_cargo', FILTER_DEFAULT);
  $departamento    = filter_input(INPUT_POST, 'departamento', FILTER_DEFAULT);
  $descricao_cargo = filter_input(INPUT_POST, 'descricao_cargo', FILTER_DEFAULT);
  //consultar cargos
  $cargo = "SELECT * FROM cargo WHERE nome_cargo = '$nome_cargo' AND contrato_sistema_id = '{$_SESSION['contratoUSER']}' LIMIT 1 ";
  $query_cargo = mysqli_query($conn, $cargo);
  if (($query_cargo) and ($query_cargo->num_rows != 0)) {
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
                    <p class="text-center">Cargo <br>' . $nome_cargo . '<br> já cadastrado.</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
          </div>
      ';
    $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_cargo";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
  } else {

    try {
      $cad_cargo = "INSERT INTO cargo 
        (nome_cargo, departamento, descricao_cargo, contrato_sistema_id, usuario_id, criado_cargo) 
        VALUES 
        ('$nome_cargo', '$departamento', '$descricao_cargo', '{$_SESSION['contratoUSER']}', '{$_SESSION['usuarioID']}', NOW())
      ";
      $query_cad_cargo = mysqli_query($conn, $cad_cargo);

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
                  <p class="text-center">Cargo <br>' . $nome_cargo . ' <br> cadastrado com sucesso</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
              </div>
            </div>
        </div>
        ';
      $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_cargo";
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
                    <p class="text-center">Erro ao cadastrar <br> ' . $err->getMessage() . ' </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
          </div>
      ';
      $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_cargo";
      echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
  }
} else {
  $url_destino = pg . "/pages/modulo/404/404";
  echo '<script> location.replace("' . $url_destino . '"); </script>';
}
