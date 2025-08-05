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

    $edit = "UPDATE site_ceo SET 
        nome           = '{$dado['nome']}', 
        descricao      = '{$dado['descricao']}', 
        biografia      = '{$dado['biografia']}', 
        data_inicio    = '{$dado['data_inicio']}', 
        data_fim       = '{$dado['data_fim']}',
        usuario_id_at  = '{$_SESSION['usuarioID']}',
        modified = NOW() 
        WHERE id = '{$dado['id']}' 
    ";
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
