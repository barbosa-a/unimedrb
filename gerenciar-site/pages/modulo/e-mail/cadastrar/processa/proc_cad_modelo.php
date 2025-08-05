<?php
if (!isset($seguranca)) {
    exit;
}
$SendCadModeloEmail = filter_input(INPUT_POST, 'SendCadModeloEmail', FILTER_DEFAULT);

if($SendCadModeloEmail){
    $titulo            = filter_input(INPUT_POST, 'titulo', FILTER_DEFAULT);
    $modulo            = filter_input(INPUT_POST, 'modulo', FILTER_DEFAULT);
    $texto             = filter_input(INPUT_POST, 'texto', FILTER_DEFAULT);

    //Verificar se ja existe registros no srv smtp
    $cons = "SELECT id  FROM email_modelos WHERE modulo_id = '$modulo' LIMIT 1";
    $query_cons = mysqli_query($conn, $cons);
    if (($query_cons) AND ($query_cons->num_rows > 0)) {
        // Atualizar dados SMTP
        $up = "UPDATE email_modelos SET modulo_id = '$modulo', titulo = '$titulo', texto = '$texto', usuario_id_at = '{$_SESSION['usuarioID']}', modifield_at = NOW()";
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
        $cad = "INSERT INTO email_modelos 
            (modulo_id, titulo, texto, usuario_id_on, created_on)
                VALUES 
            ('$modulo', '$titulo', '$texto', '{$_SESSION['usuarioID']}', NOW())";
        $query_cad = mysqli_query($conn, $cad);
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
                          <p class="text-center">Erro ao cadastrar registro.</p>
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