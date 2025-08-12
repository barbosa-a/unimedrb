<?php

if (!isset($seguranca)) {
    exit;
}
//recuperar valor da url
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {
    //deletar 
    $del = "DELETE FROM email_modelos WHERE id = '$id' ";
    $query_del = mysqli_query($conn, $del);
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
            '
        ;
        $url_destino = pg . "/pages/modulo/e-mail/e-mail";
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
            '
        ;
        $url_destino = pg . "/pages/modulo/e-mail/e-mail";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}
?>