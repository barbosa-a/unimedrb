<?php
    session_start();

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['categoria'])) {
        $seguranca = true;
        include_once '../../../../../config/config.php';
        include_once '../../../../../config/conexao.php';
        include_once '../../../../../lib/ModInformativo.php';

        $slug = slugInfo($dados['categoria']);

        $cad = "INSERT INTO informativos_categorias (categoria, slug, usuario_id_on, created_on) VALUES ('{$dados['categoria']}', '{$slug}', '{$_SESSION['usuarioID']}', NOW())";
        $query_cad = mysqli_query($conn, $cad);
        if (mysqli_insert_id($conn)) {
            // Retorna uma resposta em JSON para o JavaScript
            $response = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Registro salvo com sucesso');
            echo json_encode($response);
        }else {
            // Retorna uma resposta em JSON para o JavaScript
            $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Erro ao salvar: '. mysqli_error($conn));
            echo json_encode($response);
        }        
    }else {
        // Retorna uma resposta em JSON para o JavaScript
        $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Não encontramos a categoria');
        echo json_encode($response);
    }

    //var_dump($dados);
    