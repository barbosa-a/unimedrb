<?php
	session_start();
    //segurança do ADM
    $seguranca = true;
    //conexão
    include_once ("../../../../../config/config.php");
    include_once ("../../../../../config/conexao.php");

    $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);

    try {
        $cad = "UPDATE base_conhecimento SET views = views + 1 WHERE id = '$id' ";
        $query_cad = mysqli_query($conn, $cad);

        $msg = array(
            'tipo' => 'success', 
            'titulo' => 'Sucesso', 
            'msg' => 'Artigo visualizado com sucesso'
        );

        echo json_encode($msg);	
    } catch (Exception $err) {
        $msg = array(
            'tipo' => 'error', 
            'titulo' => 'Erro de processamento', 
            'msg' => 'Erro ao visualizar artigo, tente novamente!' . $err->getMessage()
        );

        echo json_encode($msg);	
    }