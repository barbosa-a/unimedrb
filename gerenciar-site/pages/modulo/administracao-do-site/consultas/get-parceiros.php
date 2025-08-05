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
    link, 
    arquivo
    FROM site_parceiros ORDER BY nome DESC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {

    $images[] = array(

        "id"        => $row['id'],
        "nome"      => $row['nome'],
        "link"   => $row['link'],
        "foto"   => pg . $row['arquivo']

    );
}

header('Content-Type: application/json');
echo json_encode($images);
