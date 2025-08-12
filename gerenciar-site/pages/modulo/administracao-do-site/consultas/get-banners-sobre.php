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
    ordem, 
    obs,
    DATE_FORMAT(created, '%d/%m/%Y') AS criado 
    FROM site_sobre_img ORDER BY ordem ASC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {
    $images[] = array(
        "id"        => $row['id'],
        "titulo"    => $row['titulo'],
        "url"       => pg . $row['arquivo'],
        "criado"    => $row['criado'],
        "obs"       => empty($row['obs']) ? "" : $row['obs']
    );
}

header('Content-Type: application/json');
echo json_encode($images);
