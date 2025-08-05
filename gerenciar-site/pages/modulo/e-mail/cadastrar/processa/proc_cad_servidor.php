<?php
if (!isset($seguranca)) {
    exit;
}
$SendCadSrvEmail = filter_input(INPUT_POST, 'SendCadSrvEmail', FILTER_DEFAULT);

if($SendCadSrvEmail){
    $usuario            = filter_input(INPUT_POST, 'usuario', FILTER_DEFAULT);
    $senha              = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
    $porta              = filter_input(INPUT_POST, 'porta', FILTER_SANITIZE_NUMBER_INT);
    $remetente          = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
    $host               = filter_input(INPUT_POST, 'host', FILTER_DEFAULT);

    //Verificar se ja existe registros no srv smtp
    $cons = "SELECT id  FROM email";
    $query_cons = mysqli_query($conn, $cons);
    if (($query_cons) AND ($query_cons->num_rows > 0)) {
        // Atualizar dados SMTP
        $up = "UPDATE email SET host = '$host', usuario = '$usuario', senha = '$senha', porta = '$porta', nome_usuario = '$remetente', usuario_id_at = '{$_SESSION['usuarioID']}', modifield_at = NOW()";
        $query_up = mysqli_query($conn, $up);
        if(mysqli_affected_rows($conn) > 0){
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
                          <p class="text-center">Registro atualizado com sucesso.</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                      </div>
                    </div>
                </div>
            ';
            $url_destino = pg . "/pages/modulo/e-mail/e-mail";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
        }else{
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
                          <p class="text-center">Erro ao atualizar registro.</p>
                          <code>'.mysqli_error($conn).'</code>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                      </div>
                    </div>
                </div>
            ';
            $url_destino = pg . "/pages/modulo/e-mail/e-mail";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
        }
    }else{
        // cadastrar dados SMTP
        $cad_smtp = "INSERT INTO email 
            (host, usuario, senha, porta, nome_usuario, usuario_id_on, created_on)
                VALUES 
            ('$host', '$usuario', '$senha', '$porta', '$remetente', '{$_SESSION['usuarioID']}', NOW())";
        $query_cad_smtp = mysqli_query($conn, $cad_smtp);
        if(mysqli_insert_id($conn)){
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
                          <p class="text-center">Registro cadastrado com sucesso.</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                      </div>
                    </div>
                </div>
            ';
            $url_destino = pg . "/pages/modulo/e-mail/e-mail";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
        }else{
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
                          <p class="text-center">Erro ao cadastrado registro.</p>
                          <code>'.mysqli_error($conn).'</code>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                      </div>
                    </div>
                </div>
            ';
            $url_destino = pg . "/pages/modulo/e-mail/e-mail";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
        }
    }    
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}