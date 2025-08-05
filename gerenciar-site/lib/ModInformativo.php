<?php
function slugInfo($text)
{
	// Converter caracteres especiais em letras normais
	$text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);

	// Converter espaços em hífens
	$text = str_replace(' ', '-', $text);

	// Remover caracteres indesejados
	$text = preg_replace('/[^a-zA-Z0-9-]/', '', $text);

	// Converter para minúsculas
	$text = strtolower($text);

	return $text;
}

function categoriasInfo($conn)
{
	$cons = "SELECT 
		id, 
		categoria,
		slug,
		DATE_FORMAT(created_on, '%d/%m/%Y') AS data 
		FROM informativos_categorias ORDER BY categoria ASC
	";
	$query_cons = mysqli_query($conn, $cons);
	return $query_cons;
}

function editInformativo($conn, $id)
{
	$cons = "SELECT 
		id, 
		assunto,
		unidade_id,
		informativo_categoria_id,
		conteudo		
		FROM informativos WHERE id = $id LIMIT 1
	";
	$query_cons = mysqli_query($conn, $cons);
	$row = mysqli_fetch_assoc($query_cons);
	return $row;
}

function anexosInfos($conn, $id)
{
	$cons = "SELECT 
		id, 
		titulo,
		nome_arquivo,
		caminho,
		DATE_FORMAT(created, '%d/%m/%Y') AS data 
		FROM informativos_anexos WHERE informativo_id = '{$id}' ORDER BY titulo ASC
	";
	$query_cons = mysqli_query($conn, $cons);
	return $query_cons;
}
