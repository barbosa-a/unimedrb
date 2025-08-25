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

    $edit = "UPDATE site_simulacao SET
        status  = 'Recebido',
        recebido = NOW(),
        obs  = '{$dado['message']}' 
        WHERE id = '{$dado['id']}' 
    ";
    $query = $conn->query($edit);

    $msg = array(
        'success' => true,
        'titulo' => 'Sucesso',
        'msg' => 'Registro atualizado com sucesso'
    );
    echo json_encode($msg);

} catch (Exception $e) {

    $msg = array(
        'success' => false,
        'titulo' => 'Error',
        'msg' => 'Tente novamente, erro: ' . $e->getMessage()
    );
    echo json_encode($msg);

}
