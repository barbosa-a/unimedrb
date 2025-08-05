<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../config/seguranca.php");
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");
include_once("../../../../lib/lib_funcoes.php");

$query = "SELECT 
    id,
    categoria
    FROM site_publicacoes_categoria ORDER BY categoria ASC
";
$results = $conn->query($query);

// Retorna os dados no formato esperado pelo Select2
$data = [];
foreach ($results as $row) {
    $data[] = ['id' => $row['id'], 'text' => $row['categoria']];
}

echo json_encode($data);