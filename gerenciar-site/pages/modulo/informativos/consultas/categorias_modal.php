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
while ($row = mysqli_fetch_array($query_cons)) { ?>
    <tr>
        <td><?php echo $linha++; ?></td>
        <td><?php echo $row['categoria']; ?></td>
        <td><?php echo $row['data']; ?></td>
        
        <td>
            <!-- Default dropleft button -->
            <div class="btn-group dropleft">
                <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                    Menu
                </button>
                <div class="dropdown-menu">
                    <!-- Dropdown menu links -->
                    <a class="dropdown-item" href="#" onclick="editCategoriaModal(<?php echo $row['id']; ?>, '<?php echo $row['categoria']; ?>')">Editar</a>
                    <a class="dropdown-item" href="#" onclick="delCategoriaModal(<?php echo $row['id']; ?>, '<?php echo $row['categoria']; ?>')">Apagar</a>
                </div>
            </div>
        </td>
    </tr>

<?php } ?>