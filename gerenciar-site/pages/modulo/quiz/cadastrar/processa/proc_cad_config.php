<?php
    session_start();

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if ($dados['totalPerguntas']) {
        $seguranca = true;
        include_once '../../../../../config/config.php';
        include_once '../../../../../config/conexao.php';

        // Inicia a transação
        $conn->begin_transaction();

        try {

            $cons = "SELECT * FROM quiz_config";
            $query_cons = mysqli_query($conn, $cons);

            if (mysqli_num_rows($query_cons) > 0) {
                //$row = mysqli_fetch_assoc($query_cons);

                $cad = "UPDATE quiz_config SET titulo = '{$dados['titulo']}', subtitulo = '{$dados['subtitulo']}', descricao = '{$dados['descricao']}', totalPerguntas = '{$dados['totalPerguntas']}', habilitarRoleta = '{$dados['habilitarRoleta']}', usuario_id = '{$_SESSION['usuarioID']}', modified = NOW() WHERE id = '{$dados['id']}'";
                $query_cad = mysqli_query($conn, $cad);

            } else {

                $cad = "INSERT INTO quiz_config (titulo, subtitulo, totalPerguntas, descricao, habilitarRoleta, usuario_id, created) VALUES ('{$dados['titulo']}', '{$dados['subtitulo']}', '{$dados['descricao']}', '{$dados['totalPerguntas']}', '{$dados['habilitarRoleta']}', '{$_SESSION['usuarioID']}', NOW())";
                $query_cad = mysqli_query($conn, $cad);

            }   
            
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
    