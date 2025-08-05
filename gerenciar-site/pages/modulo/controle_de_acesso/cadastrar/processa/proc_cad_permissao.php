<?php

if (!isset($seguranca)) {
    exit;
}
$sendCadastraNvl = filter_input(INPUT_POST, 'sendCadastraNvl', FILTER_DEFAULT);

if ($sendCadastraNvl) {
    try {
      $nome_nvl = filter_input(INPUT_POST, 'nome_nvl', FILTER_DEFAULT);
      //Verificar se o perfil ja existe cadastrado no banco de dados
      $verifica_registro_nvl = "SELECT * FROM niveis_acessos WHERE nome_nvl = '$nome_nvl' AND contrato_sistema_id = '{$_SESSION['contratoUSER']}' ";
      $query_verifica_registro_nvl = mysqli_query($conn, $verifica_registro_nvl);
      //Verificar a ultima ordem do nivel de acesso
      $verifica_ult_registro_nvl = "SELECT ordem_nvl FROM niveis_acessos WHERE contrato_sistema_id = '{$_SESSION['contratoUSER']}' ORDER BY ordem_nvl DESC LIMIT 1 ";
      $query_verifica_ult_registro_nvl = mysqli_query($conn, $verifica_ult_registro_nvl);
      $row_ult_nvl = mysqli_fetch_assoc($query_verifica_ult_registro_nvl);
      $row_ult_nvl['ordem_nvl']++;
      $ordem = 0;
      
      if (($query_verifica_registro_nvl) AND ($query_verifica_registro_nvl->num_rows != 0)) {
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
                        <p class="text-center">perfil <br>' . $nome_nvl . '<br> já cadastrado, tente novamente.</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                      </div>
                    </div>
                  </div>
              </div>
          ';
          $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_permissao";
          echo '<script> location.replace("' . $url_destino . '"); </script>';
      } else {
          $cad_permissao = "INSERT INTO niveis_acessos 
            (nome_nvl, ordem_nvl, contrato_sistema_id, usuario_id, criado_nvl) 
              VALUES 
            ('$nome_nvl', '{$row_ult_nvl['ordem_nvl']}', '{$_SESSION['contratoUSER']}', '{$_SESSION['usuarioID']}', NOW())";
          $query_cad_permissao = mysqli_query($conn, $cad_permissao);
          $IDNVL = mysqli_insert_id($conn);

          if (mysqli_insert_id($conn)) {
              foreach ($_POST['menu'] as $key => $menu_mod) {
                  //echo "id nvl: ".$IDNVL."<br>";
                  //echo "id menu: ".$menu_mod;
                  
                  
                  //consultar modulo
                  $cons_mod = "SELECT * FROM modulos where id_mod = '$menu_mod' ";
                  $query_cons_mod = mysqli_query($conn, $cons_mod);
                  while ($row_mod = mysqli_fetch_array($query_cons_mod)){
                      //echo "MOD: ".$row_mod['nome_mod']."<br>";
                      //liberar permissoes conforme o modulo selecionado
                      $cons_pg = "SELECT * FROM paginas WHERE modulo_id = '{$row_mod['id_mod']}' ORDER BY id_pg ASC ";
                      $query_cons_pg = mysqli_query($conn, $cons_pg);
                      while ($row_cons_pg = mysqli_fetch_array($query_cons_pg)){
                          //echo "Endereço: ".$row_cons_pg['endereco_pg']."<br>";
                          if($row_cons_pg['menu_lateral'] == 1){
                              $permissao = 1;
                          } else {
                              $permissao = 2;
                          }
                          //verificar a ultima ordem do nivel de acesso paginas
                          //$verifica_ult_registro_nvl_pg = "SELECT ordem FROM niveis_acessos_paginas ORDER BY ordem DESC ";
                          //$query_verifica_ult_registro_nvl_pg = mysqli_query($conn, $verifica_ult_registro_nvl_pg);
                          //$row_ult_nvl_pg = mysqli_fetch_assoc($query_verifica_ult_registro_nvl_pg);
                          //$row_ult_nvl_pg['ordem']++;
                          $ordem++;
                          //Salva no BD
                          $cad_nvl_perm_pg = "INSERT INTO niveis_acessos_paginas (niveis_acesso_id, pagina_id, permissao, menu, ordem, criado_nvl_pg)
                              VALUES ('$IDNVL', '{$row_cons_pg['id_pg']}', '$permissao', '$permissao', '$ordem', NOW()) ";
                          $query_cad_nvl_perm_pg = mysqli_query($conn, $cad_nvl_perm_pg);                        
                      }
                  }                
              }
              //mensagem
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
                          <p class="text-center">Perfil <br> ' . $nome_nvl . ' <br> Cadastrado</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                      </div>
                    </div>
                </div>
              ';
              $url_destino = pg . "/pages/modulo/controle_de_acesso/listar/list_permissao?nvl=$IDNVL";
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
                            <p class="text-center">Erro ao cadastrar perfil <br>' . $nome_nvl . '<br> tente novamente.</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                          </div>
                        </div>
                      </div>
                  </div>
              ';
              $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_permissao";
              echo '<script> location.replace("' . $url_destino . '"); </script>';
          }
      }
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
                  <p class="text-center">Erro: <br>' . $e->getMessage() . '</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
              </div>
            </div>
        </div>
      ';
      $url_destino = pg . "/pages/modulo/controle_de_acesso/cadastrar/cad_permissao";
      echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}
