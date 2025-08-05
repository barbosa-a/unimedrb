<?php
session_start();
$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");

$linha = 1;

$cons = "SELECT 
    id, 
    premio,
    qtd,
    status,
    DATE_FORMAT(created, '%d/%m/%Y') AS data 
    FROM quiz_premios ORDER BY premio ASC
";
$query_cons = mysqli_query($conn, $cons);
while ($row = mysqli_fetch_array($query_cons)) { ?>
<tr>
    <td><?php echo $linha++; ?></td>
    <td><?php echo $row['premio']; ?></td>
    <td><?php echo $row['qtd']; ?></td>
    <td><?php echo $row['data']; ?></td>

    <td>
        <a href="#" onclick="alterarStatusPremio('<?php echo $row['status'] == 'Ativo' ? 'Inativo' : 'Ativo' ; ?>', <?php echo $row['id']; ?>)">
            <span class="badge badge-<?php echo $row['status'] == 'Ativo' ? 'primary' : 'danger' ; ?>"><?php echo $row['status']; ?></span>
        </a>
    </td>

    <td>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-toggle="dropdown"
                aria-expanded="false">
                Menu
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delPremio<?php echo $row['id']; ?>">Apagar</a>
                <a class="dropdown-item" href="#" onclick="editarPremio(<?php echo $row['id']; ?>, '<?php echo $row['premio']; ?>')">Editar</a>     
                <a class="dropdown-item" href="#" onclick="editarQtdPremio(<?php echo $row['id']; ?>, '<?php echo $row['qtd']; ?>')">Quantidade</a>               
            </div>
        </div>
    </td>
</tr>

<div class="modal fade" id="delPremio<?php echo $row['id']; ?>" data-backdrop="static" data-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Atenção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">Deseja excluir este prêmio <br> <?php echo $row['premio']; ?></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger"
                    onclick="excluirPremio(<?php echo $row['id']; ?>)">Excluir</button>
            </div>
        </div>
    </div>
</div>

<?php } ?>