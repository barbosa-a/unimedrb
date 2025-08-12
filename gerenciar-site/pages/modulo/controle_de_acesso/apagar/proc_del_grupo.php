<?php
    if (!isset($seguranca)) {
        exit;
    }
    //recuperar valor da url
    $grupo = filter_input(INPUT_GET, 'grupo', FILTER_SANITIZE_NUMBER_INT);
    if ($grupo) {
        //consultar grupos
        $cons_grupo = "SELECT * FROM grupo g INNER JOIN unidade u ON u.grupo_id = g.id_gru WHERE g.id_gru = '$grupo' ";
        $query_cons_grupo = mysqli_query($conn, $cons_grupo);
        $num_grupo = mysqli_num_rows($query_cons_grupo);
        if(($query_cons_grupo) AND ($query_cons_grupo->num_rows !=0)){ 
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
                                <p class="mb-0 text-center">Não foi possivel excluir o registro!<br> existe ('.$num_grupo.') unidade(s) vinculado a este grupo.</p>
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
            //deletar grupo
            $del_grupo = "DELETE FROM grupo WHERE id_gru = '$grupo' ";
            $query_del_grupo = mysqli_query($conn, $del_grupo);
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
        
    }else{
        $url_destino = pg . "/pages/modulo/404/404";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
