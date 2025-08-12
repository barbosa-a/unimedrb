<?php
	session_start();
    //segurança do ADM
    $seguranca = true;
    //conexão
    include_once ("../../../../../config/config.php");
    include_once ("../../../../../config/conexao.php");

    $dado = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    // Retirar (') do texto
    $texto = str_replace("'", " ", $dado['texto']);

    try {
        $cad = "INSERT INTO base_conhecimento 
            (titulo, conteudo, views, contrato_sistema_id, usuario_id_on, created_on) 
                VALUES 
            ('{$dado['titulo']}', '{$texto}', 0, '{$_SESSION['contratoUSER']}', '{$_SESSION['usuarioID']}', NOW())";
        $query_cad = mysqli_query($conn, $cad);

        $msg = array(
            'tipo' => 'success', 
            'titulo' => 'Sucesso', 
            'msg' => 'Artigo salvo com sucesso'
        );

        echo json_encode($msg);	
    } catch (Exception $err) {
        $msg = array(
            'tipo' => 'error', 
            'titulo' => 'Erro de processamento', 
            'msg' => 'Erro ao salvar artigo, tente novamente! ' . $err->getMessage()
        );

        echo json_encode($msg);	
    }