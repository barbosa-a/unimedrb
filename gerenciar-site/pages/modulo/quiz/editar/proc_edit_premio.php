<?php
    session_start();

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['premioName'])) {
        $seguranca = true;
        include_once '../../../../config/config.php';
        include_once '../../../../config/conexao.php';

        $cad = "UPDATE quiz_premios SET premio = '{$dados['premioName']}', usuario_id = '{$_SESSION['usuarioID']}', modified = NOW() WHERE id = '{$dados['premioID']}' ";
        $query_cad = mysqli_query($conn, $cad);
        if (mysqli_affected_rows($conn) > 0) {
            // Retorna uma resposta em JSON para o JavaScript
            $response = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Registro alterada com sucesso!');
            echo json_encode($response);
        }else {
            // Retorna uma resposta em JSON para o JavaScript
            $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Erro ao salvar: '. mysqli_error($conn));
            echo json_encode($response);
        }        
    }else {
        // Retorna uma resposta em JSON para o JavaScript
        $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Não encontramos a registro');
        echo json_encode($response);
    }

    //var_dump($dados);
    