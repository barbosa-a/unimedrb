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
    sobre, 
    resumo,
    slug,
    created
    FROM site_sobre LIMIT 1
";
$result = $conn->query($query);

$images = [];
if (($result) and ($result->num_rows > 0)) {

    $row = $result->fetch_assoc();

    $images = array(
        "status"    => true,
        "id"        => $row['id'],
        "titulo"    => $row['titulo'],
        "sobre"     => $row['sobre'],
        "resumo"    => $row['resumo'],
        "slug"      => $row['slug'],
        "data"      => $row['created']
    );

} else {

    $images = array(
        "status"    => false
    );

}


header('Content-Type: application/json');
echo json_encode($images);
