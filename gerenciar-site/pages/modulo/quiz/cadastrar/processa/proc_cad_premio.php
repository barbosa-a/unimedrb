<?php
    session_start();

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if ($dados['premio']) {
        $seguranca = true;
        include_once '../../../../../config/config.php';
        include_once '../../../../../config/conexao.php';

        // Inicia a transação
        $conn->begin_transaction();

        try {

            $qtd = abs($dados['qtd']);

            $cad = "INSERT INTO quiz_premios (premio, qtd, status, usuario_id, created) VALUES ('{$dados['premio']}', '{$qtd}', '{$dados['status']}', '{$_SESSION['usuarioID']}', NOW())";
            $query_cad = mysqli_query($conn, $cad);

            // Commit da transação
            $conn->commit();

            $response = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Registro salvo com sucesso');
            echo json_encode($response);

        } catch (Exception $e) {

            // Rollback em caso de erro
            $conn->rollback();

            $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Erro ao salvar: '. $e->getMessage());
            echo json_encode($response);
        }

               
    }else {
        // Retorna uma resposta em JSON para o JavaScript
        $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Dados do formulário não são válidos');
        echo json_encode($response);
    }

    //var_dump($dados);
    