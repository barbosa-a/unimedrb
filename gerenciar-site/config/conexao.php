<?php
if(!isset($seguranca)){
    exit;
}

$servidor = "localhost";
$usuario  = "gerenciarSite";
$senha    = "N75AdfsDzw4tM72i";
$banco    = "gerenciar_site";

//criar conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $banco);
if(!$conn){
    die("Falha ao conectar servidor: ". mysqli_connect_error());
}else{
    //echo "Conexão realizada com sucesso.";
}


?>
