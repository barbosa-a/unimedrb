<?php
    session_start();
    $seguranca = true;
    include_once("../../../../lib/ModSistema.php");

    $link = filter_input(INPUT_POST, 'linkCurl', FILTER_DEFAULT);
    $numero = filter_input(INPUT_POST, 'numero', FILTER_DEFAULT);
    $msg = filter_input(INPUT_POST, 'msg', FILTER_DEFAULT);

    echo sendWhatsApp($link, $numero, $msg);

?>