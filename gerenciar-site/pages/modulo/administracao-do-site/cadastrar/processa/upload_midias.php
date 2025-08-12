<?php
session_start();

//segurança do ADM
$seguranca = true;

//Biblioteca auxiliares
include_once("../../../../../config/config.php");
include_once("../../../../../config/conexao.php");
include_once("../../../../../lib/lib_funcoes.php");
include_once("../../../../../lib/lib_timezone.php");

$dado = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$targetDir = "../../../../../dist/storage/galeria/";

// Verifica se os dados do formulário foram enviados
if (isset($_POST['legenda']) && isset($_POST['post_id'])) {
    $legenda = $dado['legenda'];
    $post_id = $dado['post_id'];

    // Agora processa o upload do arquivo
    if (!empty($_FILES)) {
        
        $fileName = slugImage(basename($_FILES['file']['name']));        

        $extensao = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        //Cria um nome baseado no UNIX TIMESTAMP atual
        $nome_final = time().'.'.$extensao;

        $targetFilePath = $targetDir . $nome_final;

        // Pasta
        $pasta = "/dist/storage/galeria/$nome_final";

        // Mover o arquivo para o diretório
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {

            //Upload efetuado com sucesso, exibe a mensagem
            $cad = "INSERT INTO site_publicacoes_galeria 
            (site_publicaoes_id, nome_img, arquivo, legenda, created) 
                VALUES
            ('{$post_id}', '{$fileName}', '{$pasta}', '{$legenda}', NOW())
            ";
            $query = mysqli_query($conn, $cad);

            $msg = array(
                'tipo' => 'success', 
                'titulo' => 'Sucesso', 
                'msg' => 'Galeria registrada com sucesso',
                //'id' => $id
            );
            echo json_encode($msg);	

        } else {
            echo json_encode([
                "tipo" => "error",
                "msg" => "Erro ao mover o arquivo"
            ]);
        }
    } else {
        echo json_encode([
            "tipo" => "error",
            "msg" => "Nenhum arquivo foi enviado"
        ]);
    }
} else {
    echo json_encode([
        "tipo" => "error",
        "msg" => "Dados do formulário estão ausentes"
    ]);
}
