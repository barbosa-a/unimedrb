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

try {

    // Verificar se ja existe um destaque para data fim
    $cons = "SELECT id FROM site_endereco LIMIT 1 ";
    $query_cons = mysqli_query($conn, $cons);
    if (($query_cons) and ($query_cons->num_rows > 0)) {

        // Atualizar
        $cad = "UPDATE site_endereco SET 
            endereco = '{$dado['endereco']}', 
            horario = '{$dado['horario']}', 
            telefone_principal = '{$dado['telefone1']}', 
            telefone_secundario = '{$dado['telefone2']}', 
            usuario_id = '{$_SESSION['usuarioID']}', 
            created = NOW()
        ";
        $query = mysqli_query($conn, $cad);

        $msg = array(
            'tipo' => 'success',
            'titulo' => 'Sucesso',
            'msg' => 'Registro atualizado com sucesso'
        );
        echo json_encode($msg);

    } else {

        // Cadastrar
        $cad = "INSERT INTO site_endereco 
        (endereco, horario, telefone_principal, telefone_secundario, usuario_id, created) 
            VALUES
        ('{$dado['endereco']}', '{$dado['horario']}', '{$dado['telefone1']}', '{$dado['telefone2']}', '{$_SESSION['usuarioID']}', NOW())
        ";
        $query = mysqli_query($conn, $cad);

        $msg = array(
            'tipo' => 'success',
            'titulo' => 'Sucesso',
            'msg' => 'Registro cadastrado com sucesso'
        );
        echo json_encode($msg);
        
    }
} catch (Exception $e) {
    $msg = array(
        'tipo' => 'error',
        'titulo' => 'Erro de processamento',
        'msg' => $e->getMessage()
    );
    echo json_encode($msg);
}
