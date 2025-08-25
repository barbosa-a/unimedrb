<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../../config/seguranca.php");
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
include_once("../../../../../lib/lib_funcoes.php");

$dado = json_decode(file_get_contents("php://input"), true);

try {

    $edit = "UPDATE site_simulacao SET
        status  = 'Excluido',
        modified = NOW() 
        WHERE id = '{$dado['id']}' 
    ";
    $query = $conn->query($edit);

    $msg = array(
        'tipo' => 'success',
        'titulo' => 'Sucesso',
        'msg' => 'Registro excluido com sucesso'
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
