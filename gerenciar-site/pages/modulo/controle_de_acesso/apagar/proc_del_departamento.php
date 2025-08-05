<?php
    if (!isset($seguranca)) {
        exit;
    }
    //recuperar valor da url
    $departamento = filter_input(INPUT_GET, 'departamento', FILTER_SANITIZE_NUMBER_INT);
    if ($departamento) {
        //consultar departamento
        $cons_departamento = "SELECT * FROM departamento d INNER JOIN cargo c ON c.departamento = d.id_depar WHERE d.id_depar = '$departamento' ";
        $query_cons_departamento = mysqli_query($conn, $cons_departamento);
        $num_departamento = mysqli_num_rows($query_cons_departamento);
        if(($query_cons_departamento) AND ($query_cons_departamento->num_rows !=0)){ 
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
                                <p class="mb-0 text-center">Não foi possivel excluir o registro!<br> existe ('.$num_departamento.') cargo(s) vinculado a este departamento.</p>
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
            //deletar departamento
            $del_depar = "DELETE FROM departamento WHERE id_depar = '$departamento' ";
            $query_del_depar = mysqli_query($conn, $del_depar);
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
    }else {
        $url_destino = pg . "/pages/modulo/404/404";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
?>