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
    nome,
    descricao, 
    biografia, 
    DATE_FORMAT(data_inicio, '%d/%m/%Y') AS inicio,
    DATE_FORMAT(data_fim, '%d/%m/%Y') AS fim,
    foto
    FROM site_ceo ORDER BY data_inicio DESC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {

    $images[] = array(

        "id"        => $row['id'],
        "nome"      => $row['nome'],
        "descricao"   => $row['descricao'],
        "biografia"   => $row['biografia'],
        "data1"   => $row['inicio'],
        "data2"   => $row['fim'],
        "foto"       => pg . $row['foto']

    );
}

header('Content-Type: application/json');
echo json_encode($images);
