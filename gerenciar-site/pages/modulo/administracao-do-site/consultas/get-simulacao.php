<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../config/seguranca.php");
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");
include_once("../../../../lib/lib_funcoes.php");

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

$query = "SELECT 
    id,
    cidade,
    ass_medica,
    sexo,
    faixaEtaria,
    qtd,
    nomeEmpresa,
    cnpj,
    email,
    nomeContato,
    telefone,
    DATE_FORMAT(created, '%d/%m/%Y às %H:%i:%s') AS criado
    FROM site_simulacao ORDER BY id DESC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {

    $images[] = $row;
}

header('Content-Type: application/json');
echo json_encode($images);
