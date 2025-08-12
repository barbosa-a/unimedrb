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
    $cons = "SELECT id FROM site_contato LIMIT 1 ";
    $query_cons = mysqli_query($conn, $cons);
    if (($query_cons) and ($query_cons->num_rows > 0)) {

        // Atualizar
        $cad = "UPDATE site_contato SET 
            enderecoEmail = '{$dado['enderecoEmail']}', 
            numeroWpp = '{$dado['numeroWpp']}', 
            telefoneFixo = '{$dado['telefoneFixo']}', 
            telefoneCelular = '{$dado['telefoneCelular']}', 
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
        $cad = "INSERT INTO site_contato 
        (enderecoEmail, numeroWpp, telefoneFixo, telefoneCelular, usuario_id, created) 
            VALUES
        ('{$dado['enderecoEmail']}', '{$dado['numeroWpp']}', '{$dado['telefoneFixo']}', '{$dado['telefoneCelular']}', '{$_SESSION['usuarioID']}', NOW())
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
