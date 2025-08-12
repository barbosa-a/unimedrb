<?php
    session_start();

    $order = $_POST['ordem'];

    if (!empty($order)) {
        $seguranca = true;    

        include_once '../../../../../config/config.php';
        include_once '../../../../../config/conexao.php';

        foreach ($order as $ordem => $id) {
            $cad = "UPDATE paginas SET ordem_menu = '{$ordem}', usuario_id = '{$_SESSION['usuarioID']}', modificado_pg = NOW() WHERE id_pg = '{$id}' ";
            $query_cad = mysqli_query($conn, $cad);
        }
        
        if (mysqli_affected_rows($conn) > 0) {
            // Retorna uma resposta em JSON para o JavaScript
            $response = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Ordem atualizada com sucesso');
            echo json_encode($response);
        }else {
            // Retorna uma resposta em JSON para o JavaScript
            $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Erro ao salvar: '. mysqli_error($conn));
            echo json_encode($response);
        }        
    }else {
        // Retorna uma resposta em JSON para o JavaScript
        $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Não encontramos a ordenação');
        echo json_encode($response);
    }