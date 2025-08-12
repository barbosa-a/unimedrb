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
    site_publicaoes_id,
    nome_img, 
    arquivo, 
    legenda
    FROM site_publicacoes_galeria WHERE site_publicaoes_id = '$id'
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {

    $images[] = array(

        "id"        => $row['id'],
        "nome"      => $row['nome_img'],
        "legenda"   => $row['legenda'],
        "url"       => pg . $row['arquivo']

    );
}

header('Content-Type: application/json');
echo json_encode($images);
