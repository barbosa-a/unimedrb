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
    titulo, 
    arquivo, 
    descricao,
    DATE_FORMAT(dtInicio, '%d/%m/%Y') AS inicio,
    DATE_FORMAT(dtFim, '%d/%m/%Y') AS fim,
    DATE_FORMAT(created, '%d/%m/%Y') AS criado 
    FROM site_pub_destaque WHERE id != 1 ORDER BY dtInicio DESC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {
    $images[] = $row;
}
header('Content-Type: application/json');
echo json_encode($images);
