<?php 

function funcaoCartao($conn)
{
	$cons = "SELECT * FROM usuarios_cartao_funcao";
	$query_cons = mysqli_query($conn, $cons);
	//$row = mysqli_fetch_assoc($query_cons);
	return $query_cons;
}

function formasPagamento($conn)
{
	$cons = "SELECT * FROM faturas_forma_pagamento";
	$query_cons = mysqli_query($conn, $cons);
	//$row = mysqli_fetch_assoc($query_cons);
	return $query_cons;
}

function dadosCartao($conn)
{
	$cons = "SELECT * FROM usuarios_cartao uc 
        INNER JOIN usuarios_cartao_funcao ucf ON ucf.id = uc.usuarios_cartao_funcao_id
        INNER JOIN contrato_sistema cs ON cs.idcontratosistema = uc.contrato_sistema_id
        WHERE uc.contrato_sistema_id = '{$_SESSION['contratoUSER']}' LIMIT 1
    ";
	$query_cons = mysqli_query($conn, $cons);
	$row = mysqli_fetch_assoc($query_cons);
	return $row;
}

function faturas($conn)
{
	$cons = "SELECT 
        f.id,
        f.nFatura,
        cs.razao_social,
        ffp.pagamento,
        mp.nome_mod_plano,
        f.valorPago,
        f.transacao_consulta,
        f.transacao_pagamento,
        fs.status,
        DATE_FORMAT(f.created, '%d/%m/%Y às %h:%i:%s') AS data
        FROM faturas f 
        INNER JOIN faturas_forma_pagamento ffp ON ffp.id = f.faturas_forma_pagamento_id
        INNER JOIN contrato_sistema cs ON cs.idcontratosistema = f.contrato_sistema_id
        INNER JOIN faturas_status fs ON fs.id = f.faturas_status_id
        INNER JOIN planos_modelos mp ON mp.idmodeloplano = f.modelo_plano_id
        WHERE f.contrato_sistema_id = '{$_SESSION['contratoUSER']}' ORDER BY f.id DESC
    ";
	$query_cons = mysqli_query($conn, $cons);
	//$row = mysqli_fetch_assoc($query_cons);
	return $query_cons;
}

function planos($conn)
{
	$cons = "SELECT * FROM planos_modelos pm INNER JOIN planos p ON p.idplano = pm.plano_id INNER JOIN planos_usuarios_qtd puq ON puq.id = pm.planos_usuarios_qtd_id ";
	$query_cons = mysqli_query($conn, $cons);
	//$row = mysqli_fetch_assoc($query_cons);
	return $query_cons;
}

?>