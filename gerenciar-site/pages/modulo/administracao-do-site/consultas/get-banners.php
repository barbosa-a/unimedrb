<?php
session_start();
//segurança do ADM
$seguranca = true;
include_once("../../../../config/seguranca.php");
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");
include_once("../../../../lib/lib_funcoes.php");

$query = "SELECT 
    tb.id, 
    tb.titulo, 
    tb.arquivo, 
    tb.link,
    DATE_FORMAT(tb.dt_inicio, '%d/%m/%Y') AS inicio,
    DATE_FORMAT(tb.dt_fim, '%d/%m/%Y') AS fim,
    un.nome_uni, 
    tb.obs,
    DATE_FORMAT(tb.created, '%d/%m/%Y') AS data 
    FROM site_banners tb 
    INNER JOIN unidade un ON un.id_uni = tb.unidade_id WHERE CURDATE() >= tb.dt_inicio AND CURDATE() <= tb.dt_fim ORDER BY tb.ordem ASC
";
$result = $conn->query($query);

$images = [];
while ($row = $result->fetch_assoc()) {
    $images[] = array(
        "id"        => $row['id'],
        "titulo"    => $row['titulo'],
        "unidade"   => $row['nome_uni'],
        "inicio"    => $row['inicio'],
        "fim"       => $row['fim'],
        "link"      => $row['link'],
        "url"       => pg . $row['arquivo'],
        "data"      => $row['data'],
        "obs"       => empty($row['obs']) ? "" : $row['obs']
    );
}

header('Content-Type: application/json');
echo json_encode($images);
