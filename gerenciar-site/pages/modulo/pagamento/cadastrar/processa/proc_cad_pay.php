<?php
session_start();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['cep']) AND !empty($dados['rua']) AND !empty($dados['numero']) AND !empty($dados['bairro']) AND !empty($dados['cidade']) AND !empty($dados['uf'])) {
    $seguranca = true;
    include_once '../../../../../config/config.php';
    include_once '../../../../../config/conexao.php';

    try {

        $conn->begin_transaction();

        // Obtém a data atual
        $dataAtual = new DateTime();
        
        // Adiciona 7 dias à data atual
        $dataAtual->modify('+30 days');

        // Obtém a data formatada
        $validade = $dataAtual->format('Y-m-d');

        $cons = "SELECT 
                * 
            FROM 
                contrato_sistema cs
            INNER JOIN usuarios_cartao uc ON uc.contrato_sistema_id = cs.idcontratosistema
            WHERE 
                cs.idcontratosistema = '{$_SESSION['contratoUSER']}' 
            LIMIT 1 
        ";
        $query = $conn->query($cons);
        if (($query) and ($query->num_rows > 0)) {

            //Atualizar status do contrato
            $upContrato = "UPDATE 
                    contrato_sistema 
                SET 
                    vencimento = '{$dados['cep']}', 
                    fim_contrato = '{$dataAtual}', 
                    situacao_contrato_id  = 1,                       
                    modifield_contrato = NOW()
                WHERE
                    idcontratosistema = '{$_SESSION['contratoUSER']}'
            ";
            $query_upContrato = $conn->query($upContrato);

            $conn->commit();

            $response = array('tipo' => 'success', 'titulo' => 'Sucesso', 'msg' => 'Endereço de cobrança salvo com sucesso');
            echo json_encode($response);
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
