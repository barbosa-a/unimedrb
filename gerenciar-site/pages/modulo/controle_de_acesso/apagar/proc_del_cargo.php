<?php

if (!isset($seguranca)) {
    exit;
}
//recuperar valor da url
$cargo = filter_input(INPUT_GET, 'cargo', FILTER_SANITIZE_NUMBER_INT);
if ($cargo) {
    //consultar cargos
    $cons_cargo = "SELECT * FROM cargo c INNER JOIN usuarios u ON u.cargo_id = c.id_cargo WHERE c.id_cargo = '$cargo' ";
    $query_cons_cargo = mysqli_query($conn, $cons_cargo);
    $num = mysqli_num_rows($query_cons_cargo);
    //$row = mysqli_fetch_assoc($query_cons_cargo);
    //echo "ID CARGO: ".$row['id_cargo']."<br>";
    //echo "qtd: ".$num;
    if (($query_cons_cargo) AND ($query_cons_cargo->num_rows != 0)) {
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
                                <p class="mb-0 text-center">Erro ao deletar cargo, existe (' . $num . ') usuário(s) vinculado a este cargo.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                '
        ;
        $url_destino = pg . "/pages/modulo/controle_de_acesso/controle_de_acesso";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } else {
        //deletar 
        $del_cargo = "DELETE FROM cargo WHERE id_cargo = '$cargo' ";
        $query_del_cargo = mysqli_query($conn, $del_cargo);
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
                '
            ;
            $url_destino = pg . "/pages/modulo/controle_de_acesso/controle_de_acesso";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
        }
    }
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}
?>