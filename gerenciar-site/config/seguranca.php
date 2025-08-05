<?php
if(!isset($seguranca)){
    exit;
}
function seguranca(){
    if((!isset($_SESSION['usuarioID'])) AND (!isset($_SESSION['usuarioLOGIN']))){
        include_once("config/config.php");
        $_SESSION['msg'] = '<div class="alert alert-info alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <small><i class="icon fa fa-info"></i> Para acessar a página é necessario realizar login.</small>
                            </div>';
        $url_destino = pg."/login.php";
        header("Location: $url_destino");    
    }
}
