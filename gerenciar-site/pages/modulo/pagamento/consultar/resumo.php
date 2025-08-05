<?php 
    session_start();
    
    $seguranca = true;
    include_once '../../../../config/config.php';
    include_once '../../../../config/conexao.php';  
    
    $cons = "SELECT * FROM contrato_sistema cs
        INNER JOIN planos_modelos pm ON pm.idmodeloplano = cs.planos_modelos_id
        INNER JOIN planos_usuarios_qtd puq ON puq.id = pm.planos_usuarios_qtd_id
        INNER JOIN usuarios_cartao uc ON uc.contrato_sistema_id = cs.idcontratosistema
        WHERE cs.idcontratosistema = '{$_SESSION['contratoUSER']}'
    ";
	$query_cons = mysqli_query($conn, $cons);
	$row = mysqli_fetch_assoc($query_cons);
	$msg = array(
        'nome' => $row['razao_social'],
        'plano' => $row['nome_mod_plano'],
        'valor' => 'R$ '. number_format($row['valor_plano'], 2, ",", "."),
        'total' => $row['qtd'] . ' - ' . $row['descricao'],
        'titular' => $row['titular'],
        'number' => $row['ncartao'],
        'val' => $row['mes'] . '/' . $row['ano'],
        'cod' => $row['cod'],
    );
    echo json_encode($msg);

?>