<?php
    session_start();

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['id'])) {
        $seguranca = true;
        include_once '../../../../../config/config.php';
        include_once '../../../../../config/conexao.php';
        include_once '../../../../../lib/ModInformativo.php';

        $slug = slugInfo($dados['assunto']);

        $cad = "UPDATE informativos SET assunto = '{$dados['assunto']}', 
            slug = '{$slug}', 
            unidade_id = '{$dados['unidadeInfo']}', 
            informativo_categoria_id = '{$dados['categoriaInfo']}', 
            conteudo = '{$dados['descricao']}', 
            usuario_id_at = '{$_SESSION['usuarioID']}', 
            modifield_at = NOW() 
            WHERE id = '{$dados['id']}' 
        ";
        $query_cad = mysqli_query($conn, $cad);
        if (mysqli_affected_rows($conn) > 0) {
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
    