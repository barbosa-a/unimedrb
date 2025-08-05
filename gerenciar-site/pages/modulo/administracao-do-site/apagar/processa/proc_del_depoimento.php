<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../../config/seguranca.php");
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
include_once("../../../../../lib/lib_funcoes.php");

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$msg = [];

$query = "DELETE FROM site_depoimento WHERE id = $id ";
$result = mysqli_query($conn, $query);
if ($result) {
    $msg = array(
        'tipo' => 'success', 
        'titulo' => 'Sucesso', 
        'msg' => 'Registro excluido com sucesso'
    );
} else {
    $msg = array(
        'tipo' => 'error', 
        'titulo' => 'Erro ao excluir', 
        'msg' => 'Erro ao processar dados'
    );
}

echo json_encode($msg);
