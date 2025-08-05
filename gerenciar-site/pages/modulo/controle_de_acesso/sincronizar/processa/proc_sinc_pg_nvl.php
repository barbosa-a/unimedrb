
<?php
                    
                    //verificar a ultima ordem do nivel de acesso paginas
                    $verifica_ult_registro_nvl_pg = "SELECT ordem FROM niveis_acessos_paginas ORDER BY ordem DESC ";
                    $query_verifica_ult_registro_nvl_pg = mysqli_query($conn, $verifica_ult_registro_nvl_pg);
                    $row_ult_nvl_pg = mysqli_fetch_assoc($query_verifica_ult_registro_nvl_pg);
                    $row_ult_nvl_pg['ordem']++;
                    //ler os nvl de acessos
                    $cons_nvl = "SELECT * FROM niveis_acessos";
                    $query_cons_nvl = mysqli_query($conn, $cons_nvl);
                    while ($row_cons_nvl = mysqli_fetch_array($query_cons_nvl)){
                        echo "--->Nivel de acesso: ".$row_cons_nvl['nome_nvl']."<br>";
                        //Pesquisar as paginas
                        $cons_pg = "SELECT * FROM paginas";
                        $query_cons_pg = mysqli_query($conn, $cons_pg);
                        while ($row_cons_pg = mysqli_fetch_array($query_cons_pg)){
                            echo "Endereço: ".$row_cons_pg['endereco_pg']."<br>";
                            //verificar se o nivel de acesso possui inscrição na pagina na tabela niveis_acessos_paginas
                            $cons_nvl_pg = "SELECT * FROM niveis_acessos_paginas WHERE niveis_acesso_id = '".$row_cons_nvl['id_nvl']."' AND pagina_id = '".$row_cons_pg['id_pg']."' ";
                            $query_cons_nvl_pg = mysqli_query($conn, $cons_nvl_pg);
                            if($query_cons_nvl_pg->num_rows == 0){
                                //verificar o nivel de permissão do usuario logado
                                if($row_cons_nvl == 1){
                                    $permissao = 1;
                                } else {
                                    $permissao = 2;
                                }
                                echo "Necessario cadastrar<br>";
                                $cad_nvl_perm_pg = "INSERT INTO niveis_acessos_paginas (niveis_acesso_id, pagina_id, permissao, ordem, criado_nvl_pg)
                                        VALUES ('".$row_cons_nvl['id_nvl']."', '".$row_cons_pg['id_pg']."', '$permissao', '".$row_ult_nvl_pg['ordem']."', NOW()) ";
                                $query_cad_nvl_perm_pg = mysqli_query($conn, $cad_nvl_perm_pg);
                                if (mysqli_affected_rows($conn) != 0) {
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
                                                  <p class="text-center">Perfil ' . $nome_nvl . ' e menu cadastrado.</p>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    ';
                                    $url_destino = pg . "/modulo/controle_de_acesso/cadastrar/cad_permissao";
                                    echo '<script> location.replace("' . $url_destino . '"); </script>';
                                }else{
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
                                                  <p class="text-center">Error ao cadastrar perfil ' . $nome_nvl . ' e atribuir menu, tente novamente.</p>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    ';
                                    $url_destino = pg . "/modulo/controle_de_acesso/cadastrar/cad_permissao";
                                    echo '<script> location.replace("' . $url_destino . '"); </script>';
                                }
                            }
                        }
                    }
                ?>
