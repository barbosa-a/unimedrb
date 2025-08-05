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
    nome,
    cargoFuncao, 
    texto,
    foto,
    DATE_FORMAT(created, '%d/%m/%Y') AS criado 
    FROM site_depoimento ORDER BY id DESC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {

    $images[] = array(

        "id"        => $row['id'],
        "nome"      => $row['nome'],
        "cargoFuncao"   => $row['cargoFuncao'],
        "texto"      => $row['texto'],
        "foto"   => pg . $row['foto'],
        "registrado"      => $row['criado'],
    );
}

header('Content-Type: application/json');
echo json_encode($images);
