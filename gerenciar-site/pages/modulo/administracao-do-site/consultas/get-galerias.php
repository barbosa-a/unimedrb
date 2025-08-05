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
    sg.album,
    sg.descricao, 
    sg.capa, 
    DATE_FORMAT(sg.created, '%d/%m/%Y') AS criado,
    (
        SELECT arquivo FROM site_galeria_fotos WHERE site_galeria_id = sg.id LIMIT 1
    ) AS img
    FROM site_galeria sg ORDER BY id DESC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {

    $images[] = array(

        "id"        => $row['id'],
        "album"      => $row['album'],
        "descricao"   => $row['descricao'],
        "criado"       => $row['criado'],
        "img"           => pg . $row['img']

    );
}

header('Content-Type: application/json');
echo json_encode($images);
