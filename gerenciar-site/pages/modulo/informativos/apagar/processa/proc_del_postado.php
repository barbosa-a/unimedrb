<?php
    session_start();

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['id'])) {
        $seguranca = true;
        include_once '../../../../../config/config.php';
        include_once '../../../../../config/conexao.php';
        //include_once '../../../../../lib/ModInformativo.php';

       // $slug = slug($dados['categoria']);

        $cad = "DELETE FROM informativos WHERE id = '{$dados['id']}' ";
        $query_cad = mysqli_query($conn, $cad);
        if (mysqli_affected_rows($conn) > 0) {
            // Retorna uma resposta em JSON para o JavaScript
            $response = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Registro excluido com sucesso', 'info' => $dados['id']);
            echo json_encode($response);
        }else {
            // Retorna uma resposta em JSON para o JavaScript
            $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Erro ao excluir: '. mysqli_error($conn));
            echo json_encode($response);
        }        
    }else {
        // Retorna uma resposta em JSON para o JavaScript
        $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Não encontramos a postagem');
        echo json_encode($response);
    }

    //var_dump($dados);
    