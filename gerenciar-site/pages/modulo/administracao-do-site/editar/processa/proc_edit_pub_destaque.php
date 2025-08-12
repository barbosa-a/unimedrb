<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../../config/seguranca.php");
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
include_once("../../../../../lib/lib_funcoes.php");

$dado = filter_input_array(INPUT_POST, FILTER_DEFAULT);

try {

    $edit = "UPDATE site_pub_destaque SET titulo = '{$dado['edit_titulo']}', descricao = '{$dado['edit_desc']}', modified = NOW() WHERE id = '{$dado['idpubdestaque']}' ";
    $query = $conn->query($edit);

    $msg = array(
        'tipo' => 'success',
        'titulo' => 'Sucesso',
        'msg' => 'Registro alterado com sucesso'
    );
    echo json_encode($msg);

} catch (Exception $e) {

    $msg = array(
        'tipo' => 'error',
        'titulo' => 'Error',
        'msg' => 'Tente novamente, erro: ' . $e->getMessage()
    );
    echo json_encode($msg);

}
