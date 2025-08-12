<?php
    
    if (class_exists('ZipArchive')) {
        $zip = new ZipArchive();
        $pastaOrigem = '../../../../../';
        $pastaDestino = '../../backup/sistema/';
        $arquivoZip = 'sistema_backup_' . date('d-m-Y') . '_' . time() . '.zip';

        $caminhoArquivoZip = $pastaDestino . DIRECTORY_SEPARATOR . $arquivoZip;

        //$zip = new ZipArchive();
    
        if ($zip->open($caminhoArquivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $arquivos = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($pastaOrigem),
                RecursiveIteratorIterator::LEAVES_ONLY
            );
            
            foreach ($arquivos as $arquivo) {
                if (!$arquivo->isDir()) {
                    $caminhoArquivo = $arquivo->getRealPath();
                    $arquivoRelativo = substr($caminhoArquivo, strlen($pastaOrigem) + 1);
                    $zip->addFile($caminhoArquivo, $arquivoRelativo);
                }
            }
            
            $zip->close();
            //echo "A compactação foi concluída. Arquivo ZIP criado: $arquivoZip";
            $arr = array('tipo' => 'success', 'titulo' => 'Backup concluído com sucesso', 'msg' => "A compactação foi concluída. Arquivo ZIP criado: ". $arquivoZip);
            echo json_encode($arr); 
        } else {
            //echo "Não foi possível criar o arquivo ZIP.";
            $arr = array('tipo' => 'error', 'titulo' => 'Erro', 'msg' => 'Não foi possível criar o arquivo ZIP.');
            echo json_encode($arr); 
        }

    } else {
        //echo "A extensão ZipArchive não está habilitada no PHP.";
        $arr = array('tipo' => 'error', 'titulo' => 'Erro', 'msg' => 'A extensão ZipArchive não está habilitada no PHP.');
        echo json_encode($arr); 
    }

?>
