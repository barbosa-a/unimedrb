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
    $cons = "SELECT id FROM site_redes_socias LIMIT 1 ";
    $query_cons = mysqli_query($conn, $cons);
    if (($query_cons) and ($query_cons->num_rows > 0)) {

        // Atualizar
        $cad = "UPDATE site_redes_socias SET 
            facebook = '{$dado['facebook']}', 
            status_facebook = '{$dado['status_facebook']}', 
            instagram = '{$dado['instagram']}', 
            status_instagram = '{$dado['status_instagram']}', 
            youtube = '{$dado['youtube']}', 
            status_youtube = '{$dado['status_youtube']}', 
            linkedin = '{$dado['linkedin']}', 
            status_linkedin = '{$dado['status_linkedin']}', 
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
        $cad = "INSERT INTO site_redes_socias 
        (facebook, status_facebook, instagram, status_instagram, youtube, status_youtube, linkedin, status_linkedin, usuario_id, created) 
            VALUES
        ('{$dado['facebook']}', '{$dado['status_facebook']}', '{$dado['instagram']}', '{$dado['status_instagram']}', '{$dado['youtube']}', '{$dado['status_youtube']}', '{$dado['linkedin']}', '{$dado['status_linkedin']}', '{$_SESSION['usuarioID']}', NOW())
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
