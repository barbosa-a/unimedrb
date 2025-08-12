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
    nome_site,
    link_site, 
    DATE_FORMAT(created, '%d/%m/%Y') AS criado
    FROM site_links_uteis ORDER BY nome_site ASC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {

    $images[] = array(

        "id"        => $row['id'],
        "nome"      => $row['nome_site'],
        "link"      => $row['link_site'],
        "criado"    => $row['criado']

    );
}

header('Content-Type: application/json');
echo json_encode($images);
