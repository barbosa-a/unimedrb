<?php
session_start();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['planoAtual'])) {
    $seguranca = true;
    include_once '../../../../../config/config.php';
    include_once '../../../../../config/conexao.php';

    try {

        $conn->begin_transaction();

        $cons = "SELECT idcontratosistema FROM contrato_sistema WHERE idcontratosistema = '{$_SESSION['contratoUSER']}' LIMIT 1 ";
        $query = $conn->query($cons);
        if (($query) and ($query->num_rows > 0)) {

            //consultar plano
            $plano = "SELECT * FROM planos_modelos pm INNER JOIN planos_usuarios_qtd puq ON puq.id = pm.planos_usuarios_qtd_id WHERE pm.idmodeloplano = '{$dados['planoAtual']}' LIMIT 1 ";
            $resul = $conn->query($plano);
            if (($resul) and ($resul->num_rows > 0)) {
                $row = $resul->fetch_assoc();

                //Atualizar plano do contrato
                $upContrato = "UPDATE 
                        contrato_sistema 
                    SET 
                        plano = '{$row['nome_mod_plano']}', 
                        planos_modelos_id = '{$dados['planoAtual']}', 
                        valor_contrato = '{$row['valor_plano']}', 
                        qtd_usuarios_liberados = '{$row['qtd']}',                        
                        modifield_contrato = NOW()
                    WHERE
                        idcontratosistema = '{$_SESSION['contratoUSER']}'
                ";
                $query_upContrato = $conn->query($upContrato);

                $conn->commit();

                $response = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Registro salvo com sucesso');
                echo json_encode($response);
            } else {

                $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Plano não encontrado');
                echo json_encode($response);

            }
        } else {

            $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Seu contrato não foi localizado, atualize a página e tente novamente.');
            echo json_encode($response);

        }
    } catch (Exception $e) {

        $conn->rollback();

        $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Erro ao salvar: ' . $e->getMessage());
        echo json_encode($response);
    }
} else {

    // Retorna uma resposta em JSON para o JavaScript
    $response = array('tipo' => 'error', 'titulo' => 'Ops...', 'msg' => 'Não encontramos os dados necessários');
    echo json_encode($response);
}
