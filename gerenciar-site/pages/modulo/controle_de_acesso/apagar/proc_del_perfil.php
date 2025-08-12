<?php
    if (!isset($seguranca)) {
            exit;
    }
    //recuperar valor da url
    $perfil = filter_input(INPUT_GET, 'perfil', FILTER_SANITIZE_NUMBER_INT);
    if ($perfil) {
        //consultar  perfil
        $cons_perfil = "SELECT * FROM niveis_acessos nv INNER JOIN usuarios us ON us.niveis_acesso_id = nv.id_nvl WHERE nv.id_nvl = '$perfil' ";
        $query_cons_perfil = mysqli_query($conn, $cons_perfil);
        $num_perfil = mysqli_num_rows($query_cons_perfil);
        if(($query_cons_perfil) AND ($query_cons_perfil->num_rows !=0)){ 
            $_SESSION['msg'] = '
                <div class="modal fade" id="procmsg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-sm">
                            <div class="modal-header">
                                <h5 class="modal-title">Erro</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body m-3">
                                <p class="mb-0 text-center">Não foi possivel excluir o registro!<br> existe ('.$num_perfil.') usuario(s) vinculado a este perfil.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            $url_destino = pg . "/pages/modulo/controle_de_acesso/controle_de_acesso";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
        }else{
            //deleta paginas do perfil
            $del_perfil_pg = "DELETE FROM niveis_acessos_paginas WHERE niveis_acesso_id = '$perfil' ";
            $query_del_perfil_pg = mysqli_query($conn, $del_perfil_pg);
            //deleta perfil
            $del_perfil = "DELETE FROM niveis_acessos WHERE id_nvl = '$perfil' ";
            $query_del_perfil = mysqli_query($conn, $del_perfil);            
            //mensagem
            if (mysqli_affected_rows($conn) != 0) {
                $_SESSION['msg'] = '
                <div class="modal fade" id="procmsg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-sm">
                            <div class="modal-header">
                                <h5 class="modal-title">Sucesso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body m-3">
                                <p class="mb-0 text-center">Registro excluido com sucesso! </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                ';
                $url_destino = pg . "/pages/modulo/controle_de_acesso/controle_de_acesso";
                echo '<script> location.replace("' . $url_destino . '"); </script>';
            } else {
                $_SESSION['msg'] = '
                <div class="modal fade" id="procmsg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-sm">
                            <div class="modal-header">
                                <h5 class="modal-title">Erro</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body m-3">
                                <p class="mb-0 text-center">Não foi possivel excluir o registro!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                ';
                $url_destino = pg . "/pages/modulo/controle_de_acesso/controle_de_acesso";
                echo '<script> location.replace("' . $url_destino . '"); </script>';
            } 
        }        
    } else {
        $url_destino = pg . "/pages/modulo/404/404";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }

