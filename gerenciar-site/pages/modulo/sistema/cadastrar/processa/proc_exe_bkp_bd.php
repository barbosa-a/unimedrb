<?php
$seguranca = true;
//Biblioteca auxiliares
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");

$result = $conn->query('SHOW CREATE DATABASE ' . $banco);
if ($result) {
    $row = $result->fetch_row();
    $createDatabaseSQL = $row[1];
} else {
    //echo "Erro ao obter a estrutura do banco de dados: " . $conn->error;
    $arr = array('tipo' => 'error', 'titulo' => 'Erro', 'msg' => 'Erro ao obter a estrutura do banco de dados: ' . $conn->error);
    echo json_encode($arr); 
}

$output = "";

$tables = [];
$result = $conn->query('SHOW TABLES');
if ($result) {
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }
}else {
    //echo "Erro ao obter a lista de tabelas: " . $conn->error;
    $arr = array('tipo' => 'error', 'titulo' => 'Erro', 'msg' => 'Erro ao obter a lista de tabelas: ' . $conn->error);
    echo json_encode($arr); 
}

foreach ($tables as $table) {
    $result = $conn->query('SELECT * FROM ' . $table);
    $numFields = $result->field_count;

    $tableCreateSQL = "SHOW CREATE TABLE $table";
    $tableCreateResult = $conn->query($tableCreateSQL);
    $tableCreateRow = $tableCreateResult->fetch_row();
    $tableCreateSQL = $tableCreateRow[1];

    $output .= "DROP TABLE IF EXISTS $table;\n";
    $output .= $tableCreateSQL . ";\n";

    while ($row = $result->fetch_row()) {
        $output .= "INSERT INTO $table VALUES(";
        for ($i = 0; $i < $numFields; $i++) {
            $row[$i] = $conn->real_escape_string($row[$i]);
            $output .= '"' . $row[$i] . '"';
            if ($i < ($numFields - 1)) {
                $output .= ', ';
            }
        }
        $output .= ");\n";
    }
}

// Salvar o conteúdo em um arquivo
$backupFilename = '../../backup/BD/db_backup_' . date('d-m-Y') . '_' . date('His')  . '.sql';

if (file_put_contents($backupFilename, $output)) {
    //echo "Backup concluído com sucesso. O arquivo foi salvo como: $backupFilename";
    $arr = array('tipo' => 'success', 'titulo' => 'Backup concluído com sucesso', 'msg' => "O arquivo foi salvo como: ". str_replace("../../backup/", "", $backupFilename));
    echo json_encode($arr); 
} else {
    //echo "Erro ao salvar o arquivo de backup.";
    $arr = array('tipo' => 'error', 'titulo' => 'Erro', 'msg' => 'Erro ao salvar o arquivo de backup.');
    echo json_encode($arr); 
}
