<?php
	session_start();
    //segurança do ADM
    $seguranca = true;
    //conexão
    include_once ("../../../../../config/config.php");
    include_once ("../../../../../config/conexao.php");

    $dado = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    try {
        $cad = "INSERT INTO base_conhecimento_rating 
            (usuario_id, base_conhecimento_id, rating, created) 
                VALUES 
            ('{$_SESSION['usuarioID']}', '{$dado['id']}', '{$dado['pont']}',  NOW())";
        $query_cad = mysqli_query($conn, $cad);

        $msg = array(
            'tipo' => 'success', 
            'titulo' => 'Sucesso', 
            'msg' => 'Você avaliou'
        );

        echo json_encode($msg);	
    } catch (Exception $err) {
        $msg = array(
            'tipo' => 'error', 
            'titulo' => 'Erro de processamento', 
            'msg' => 'Erro ao salvar registro, tente novamente!' . $err->getMessage()
        );

        echo json_encode($msg);	
    }