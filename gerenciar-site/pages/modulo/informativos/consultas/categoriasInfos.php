<?php
session_start();
$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");

$linha = 1;

$cons = "SELECT
    ic.categoria,
    COUNT(i.id) AS total
    FROM informativos_categorias ic 
    INNER JOIN informativos i ON i.informativo_categoria_id = ic.id GROUP BY ic.categoria ORDER BY ic.categoria ASC
";
$query_cons = mysqli_query($conn, $cons);

while ($row = mysqli_fetch_array($query_cons)) { ?>

    <li class="d-flex justify-content-between align-items-center">
        <a href="#" class="btn-link text-dark">
            <?php echo $row['categoria']; ?>
        </a>
        <span class="badge badge-primary badge-pill"><?php echo $row['total']; ?></span>
    </li>

<?php } ?>