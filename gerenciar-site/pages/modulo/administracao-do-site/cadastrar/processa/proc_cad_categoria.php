<?php
session_start();

//segurança do ADM
$seguranca = true;

//Biblioteca auxiliares
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
include_once("../../../../../lib/lib_funcoes.php");
include_once("../../../../../lib/lib_timezone.php");

$dado = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$slug = slugGeral($dado['newCategoriaPub']);

try {

    // Cadastrar
    $cad = "INSERT INTO site_publicacoes_categoria 
        (categoria, slug_cat, usuario_id, created) 
            VALUES
        ('{$dado['newCategoriaPub']}', '{$slug}', '{$_SESSION['usuarioID']}', NOW())
    ";
    $query = mysqli_query($conn, $cad);

    $msg = array(
        'tipo' => 'success',
        'titulo' => 'Sucesso',
        'msg' => 'Registro cadastrado com sucesso'
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
