<?php
    session_start();
    
    $seguranca = true;
    //Biblioteca auxiliares
    include_once("../../../../../config/config.php");
    include_once("../../../../../config/conexao.php");

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $cad_modulo = "INSERT INTO apis_documentacao 
        (assunto, documentacao, usuario_id_on, created_on) 
    VALUES 
        ('{$dados['assunto']}', '{$dados['documentar']}', '{$_SESSION['usuarioID']}', NOW())
    ";
    $query_cad_modulo = mysqli_query($conn, $cad_modulo);
    if(mysqli_insert_id($conn) !=0){
        $arr = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => "Registro cadastrado com sucesso");
        echo json_encode($arr); 
    }else{
        $arr = array('tipo' => 'error', 'titulo' => 'Erro', 'msg' => 'Erro ao salvar registro.');
        echo json_encode($arr); 
    }