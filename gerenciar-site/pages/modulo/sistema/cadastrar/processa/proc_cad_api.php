<?php
    session_start();
    
    $seguranca = true;
    //Biblioteca auxiliares
    include_once("../../../../../config/config.php");
    include_once("../../../../../config/conexao.php");

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if (isset($dados["status"]) && $dados["status"] == "on") {
        $status = 1;
    } else {
        $status = 2;
    }

    $cad_modulo = "INSERT INTO apis 
        (curl, requisicao, tipo, biblioteca, github, iframe, status, usuario_id_on, created_on) 
    VALUES 
        ('{$dados['curl']}', '{$dados['requisicao']}', '{$dados['tipo']}', '{$dados['biblioteca']}', '{$dados['github']}', '{$dados['iframe']}', '$status', '{$_SESSION['usuarioID']}', NOW())
    ";
    $query_cad_modulo = mysqli_query($conn, $cad_modulo);
    if(mysqli_insert_id($conn) !=0){
        $arr = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => "Api cadastrada com sucesso");
        echo json_encode($arr); 
    }else{
        $arr = array('tipo' => 'error', 'titulo' => 'Erro', 'msg' => 'Erro ao salvar Api.');
        echo json_encode($arr); 
    }