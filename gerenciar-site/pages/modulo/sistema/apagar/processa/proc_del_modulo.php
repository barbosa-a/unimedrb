<?php

if (!isset($seguranca)) {
    exit;
}
//recuperar valor da url
$nome   = filter_input(INPUT_GET, 'nome', FILTER_DEFAULT);
$modulo = filter_input(INPUT_GET, 'modulo', FILTER_SANITIZE_NUMBER_INT);
if ($modulo) {
    //deletar 
    $del_mod = "DELETE FROM modulos WHERE id_mod = '$modulo' ";
    $query_del_mod = mysqli_query($conn, $del_mod);
    //mensagem
    if (mysqli_affected_rows($conn) != 0) {
        //excluir pasta do modulo
        delTree('pages/modulo/' . $nome . '');

        //excluir paginas do modulo
        $del_mod_pg = "DELETE FROM paginas WHERE modulo_id = '$modulo' ";
        $query_del_mod_pg = mysqli_query($conn, $del_mod_pg);
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
                            <p class="mb-0 text-center">Modulo e páginas de acesso excluidas com sucesso! </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            ';
            $url_destino = pg . "/pages/modulo/sistema/sistema";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
        } else {
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
                            <p class="mb-0 text-center">Modulo excluido com sucesso! </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            ';
            $url_destino = pg . "/pages/modulo/sistema/sistema";
            echo '<script> location.replace("' . $url_destino . '"); </script>';    
        }
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
                            <p class="mb-0 text-center">Não foi possivel excluir o modulo!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            ';
        $url_destino = pg . "/pages/modulo/sistema/sistema";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}
