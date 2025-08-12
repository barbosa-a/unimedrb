<?php
session_start();
$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");

$linha = 1;

$cons = "SELECT 
    id, 
    categoria,
    slug,
    DATE_FORMAT(created_on, '%d/%m/%Y') AS data 
    FROM informativos_categorias ORDER BY categoria ASC
";
$query_cons = mysqli_query($conn, $cons);

echo '<option value="">Selecione...</option>';
while ($row = mysqli_fetch_array($query_cons)) { ?>

    <option value="<?php echo $row['id']; ?>"><?php echo $row['categoria']; ?></option>

<?php } ?>