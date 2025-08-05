<?php
    session_start();

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['id'])) {
        $seguranca = true;
        include_once '../../../../config/config.php';
        include_once '../../../../config/conexao.php';

        // Inicia a transação
        $conn->begin_transaction();

        try {

            $del = "DELETE FROM quiz_premios WHERE id = '{$dados['id']}' ";
            $query = mysqli_query($conn, $del);

            // Commit da transação
            $conn->commit();

            $response = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Registro excluido com sucesso');
            echo json_encode($response);

        } catch (Exception $e) {

            // Rollback em caso de erro
            $conn->rollback();
            
            $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Erro ao excluir: '. $e->getMessage());
            echo json_encode($response);
        }
               
    }else {
        // Retorna uma resposta em JSON para o JavaScript
        $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Não encontramos a pergunta, tente novamente');
        echo json_encode($response);
    }

    //var_dump($dados);
    