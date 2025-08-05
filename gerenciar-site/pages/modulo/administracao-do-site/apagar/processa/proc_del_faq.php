<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../../config/seguranca.php");
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
include_once("../../../../../lib/lib_funcoes.php");

$id = json_decode(file_get_contents("php://input"), true);

$msg = [];

try {

    $query = "DELETE FROM site_faq WHERE id = '{$id['id']}' ";
    $result = mysqli_query($conn, $query);

    $msg = array(
        'tipo' => 'success',
        'titulo' => 'Sucesso',
        'msg' => 'Registro excluido com sucesso'
    );

    echo json_encode($msg);

} catch (Exception $e) {

    $msg = array(
        'tipo' => 'error',
        'titulo' => 'Erro de processamento',
        'msg' => $e->getMessage()
    );

    echo json_encode($msg);
}