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
    sg.id,
    sg.slug,
    sg.arquivo, 
    sg.legenda, 
    DATE_FORMAT(sg.created, '%d/%m/%Y') AS criado
    FROM site_galeria_fotos sg WHERE site_galeria_id = '{$id}' ORDER BY nome ASC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {

    $images[] = array(

        "id"        => $row['id'],
        "legenda"   => $row['legenda'],
        "slug"      => $row['slug'],
        "criado"    => $row['criado'],
        "img"       => pg . $row['arquivo']

    );
}

header('Content-Type: application/json');
echo json_encode($images);
