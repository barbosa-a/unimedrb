<?php
session_start();

$acao = filter_input(INPUT_GET, "acao", FILTER_DEFAULT);
$resultado = filter_input(INPUT_POST, "resultado", FILTER_SANITIZE_NUMBER_INT);
$comentario = filter_input(INPUT_POST, "obs", FILTER_DEFAULT);

//segurança do ADM
$seguranca = true;
include_once "../../../config/config.php";
//conexão
include_once "../../../config/conexao.php";

if ($acao == "deslogar") {
    //update tabela user
    $up_ult_logon = "UPDATE usuarios SET ult_acesso = NOW() WHERE id_user = '{$_SESSION["usuarioID"]}' ";
    $query_up_ult_logon = mysqli_query($conn, $up_ult_logon);
    if (mysqli_affected_rows($conn) > 0) {
        unset(
            $_SESSION["usuarioID"],
            $_SESSION["usuarioNOME"],
            $_SESSION["usuarioEMAIL"],
            $_SESSION["usuarioLOGIN"],
            $_SESSION["usuarioORDEM"],
            $_SESSION["usuarioUNIDADEID"],
            $_SESSION["usuarioUNIDADE"],
            $_SESSION["usuarioUNIDADESIGLA"],
            $_SESSION["usuarioCARGO"],
            $_SESSION["usuarioPERFIL"],
            $_SESSION["usuarioNIVEL"],
            $_SESSION["contratoUSER"],
            $_SESSION["contratoID"]
        );

        $_SESSION["msg"] = '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <small><i class="fa fa-check"></i> Desconectado com sucesso</small>
                    </div>';
        $url_destino = pg . "/login.php";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } else {
        $_SESSION["msg"] =
            '
    <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Atenção!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p class="text-center">Erro ao tentar desconectar</p>
              <p class="text-center text-danger">'.mysqli_error($conn).'</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
          </div>
        </div>
    </div>
   ';
    $url_destino = pg . "/";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
} else {
    if (empty($_SESSION["contratoID"])) {
        $contrato = 0;
    } else {
        $contrato = $_SESSION["contratoID"];
    }
    //verificar se as variaveis estão vazias
    if (empty($resultado) and empty($comentario)) {
        //update tabela user
        $up_ult_logon = "
                UPDATE usuarios SET ult_acesso = NOW() WHERE id_user = '{$_SESSION["usuarioID"]}' ";
        $query_up_ult_logon = mysqli_query($conn, $up_ult_logon);
        unset(
            $_SESSION["usuarioID"],
            $_SESSION["usuarioNOME"],
            $_SESSION["usuarioEMAIL"],
            $_SESSION["usuarioLOGIN"],
            $_SESSION["usuarioORDEM"],
            $_SESSION["usuarioUNIDADEID"],
            $_SESSION["usuarioUNIDADE"],
            $_SESSION["usuarioUNIDADESIGLA"],
            $_SESSION["usuarioCARGO"],
            $_SESSION["usuarioPERFIL"],
            $_SESSION["usuarioNIVEL"],
            $_SESSION["contratoUSER"],
            $_SESSION["contratoID"]
        );

        $_SESSION["msg"] = '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <small><i class="fa fa-check"></i> Desconectado com sucesso</small>
                    </div>';
        $url_destino = pg . "/login.php";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    } else {
        $cad = "
         INSERT INTO enquete 
         (contrato_sistema_id, usuario_id, resultado, obs, created) 
         VALUES 
         ('$contrato', '{$_SESSION["usuarioID"]}', '$resultado', '$comentario', NOW())";
        $query_cad = mysqli_query($conn, $cad);
        if (mysqli_insert_id($conn)) {
            //update tabela user
            $up_ult_logon = "
             UPDATE usuarios SET ult_acesso = NOW() WHERE id_user = '{$_SESSION["usuarioID"]}' ";
            $query_up_ult_logon = mysqli_query($conn, $up_ult_logon);
            unset(
                $_SESSION["usuarioID"],
                $_SESSION["usuarioNOME"],
                $_SESSION["usuarioEMAIL"],
                $_SESSION["usuarioLOGIN"],
                $_SESSION["usuarioORDEM"],
                $_SESSION["usuarioUNIDADEID"],
                $_SESSION["usuarioUNIDADE"],
                $_SESSION["usuarioUNIDADESIGLA"],
                $_SESSION["usuarioCARGO"],
                $_SESSION["usuarioPERFIL"],
                $_SESSION["usuarioNIVEL"],
                $_SESSION["contratoUSER"],
                $_SESSION["contratoID"],
                $_SESSION['empresaNOME']
            );

            $_SESSION["msg"] = '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <small><i class="fa fa-check"></i> Desconectado com sucesso</small>
                    </div>';
            $url_destino = pg . "/login.php";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
        } else {
            //update tabela user
            $up_ult_logon = "
             UPDATE usuarios SET ult_acesso = NOW() WHERE id_user = '{$_SESSION["usuarioID"]}' ";
            $query_up_ult_logon = mysqli_query($conn, $up_ult_logon);
            if (mysqli_affected_rows($conn) > 0) {
                unset(
                $_SESSION["usuarioID"],
                $_SESSION["usuarioNOME"],
                $_SESSION["usuarioEMAIL"],
                $_SESSION["usuarioLOGIN"],
                $_SESSION["usuarioORDEM"],
                $_SESSION["usuarioUNIDADEID"],
                $_SESSION["usuarioUNIDADE"],
                $_SESSION["usuarioUNIDADESIGLA"],
                $_SESSION["usuarioCARGO"],
                $_SESSION["usuarioPERFIL"],
                $_SESSION["usuarioNIVEL"],
                $_SESSION["contratoUSER"],
                $_SESSION["contratoID"],
                $_SESSION['empresaNOME']
            );

            $_SESSION["msg"] = '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <small><i class="fa fa-check"></i> Desconectado com sucesso</small>
                    </div>';
            $url_destino = pg . "/login.php";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
            }else{
                unset(
                $_SESSION["usuarioID"],
                $_SESSION["usuarioNOME"],
                $_SESSION["usuarioEMAIL"],
                $_SESSION["usuarioLOGIN"],
                $_SESSION["usuarioORDEM"],
                $_SESSION["usuarioUNIDADEID"],
                $_SESSION["usuarioUNIDADE"],
                $_SESSION["usuarioUNIDADESIGLA"],
                $_SESSION["usuarioCARGO"],
                $_SESSION["usuarioPERFIL"],
                $_SESSION["usuarioNIVEL"],
                $_SESSION["contratoUSER"],
                $_SESSION["contratoID"],
                $_SESSION['empresaNOME']
            );

            $_SESSION["msg"] = '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <small><i class="fa fa-check"></i> Desconectado com sucesso</small>
                    </div>';
            $url_destino = pg . "/login.php";
            echo '<script> location.replace("' . $url_destino . '"); </script>';
            }            
        }
    }
}
?>