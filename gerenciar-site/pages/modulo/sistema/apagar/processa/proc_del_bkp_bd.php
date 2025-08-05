<?php
$arquivo = filter_input(INPUT_GET, 'arquivo', FILTER_DEFAULT);
$caminhoDoArquivo = '../../backup/BD/'.$arquivo;
//echo getcwd();

if (file_exists($caminhoDoArquivo)) {
    if (unlink($caminhoDoArquivo)) {
        echo "Arquivo $arquivo excluído com sucesso.";
    } else {
        echo "Erro ao excluir o arquivo $arquivo.";
    }
} else {
    echo "O arquivo $arquivo não existe.";
}

?>
