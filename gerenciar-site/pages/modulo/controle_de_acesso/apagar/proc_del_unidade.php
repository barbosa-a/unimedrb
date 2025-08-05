<?php
    if (!isset($seguranca)) {
            exit;
    }
    //recuperar valor da url
    $unidade = filter_input(INPUT_GET, 'unidade', FILTER_SANITIZE_NUMBER_INT);
    if ($unidade) {
        //consultar unidade
        $cons_unidade = "
            SELECT 
                * 
            FROM 
                unidade un 
            INNER JOIN 
                usuarios us 
            ON 
                us.unidade_id = un.id_uni
            WHERE 
                us.unidade_id = '$unidade'
            GROUP BY un.id_uni ";
        $query_cons_unidade = mysqli_query($conn, $cons_unidade);
        //$num_uni = mysqli_num_rows($query_cons_unidade);
        if(($query_cons_unidade) AND ($query_cons_unidade->num_rows !=0)){ 
            $linha = mysqli_fetch_array($query_cons_unidade);
            $_SESSION['msg'] = '
                <div class="modal fade" id="procmsg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-sm">
                            <div class="modal-header">
                                <h5 class="modal-title">Error</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body m-3">
                                <p class="mb-0 text-center">Não é possivel excluir o registro<br> pois existe usuario(s) vinculado(s) a esta unidade.</p>
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
            //deletar unidade
            $del_unidade = "DELETE FROM unidade WHERE id_uni = '$unidade' ";
            $query_del_unidade = mysqli_query($conn, $del_unidade);
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
                                <p class="mb-0 text-center">Registro excluido com sucesso!</p>
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

