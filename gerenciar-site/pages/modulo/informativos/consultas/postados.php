<?php
session_start();
$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");

$linha = 1;

$buscar = filter_input(INPUT_GET, 'buscar', FILTER_DEFAULT);

$cons = "SELECT 
    i.id, 
    i.assunto,
    i.conteudo,
    ic.categoria,
    DATE_FORMAT(i.created_on, '%d/%m/%Y') AS data 
    FROM informativos i INNER JOIN informativos_categorias ic ON ic.id  = i.informativo_categoria_id WHERE i.assunto LIKE '%$buscar%' ORDER BY i.assunto ASC
";
$query_cons = mysqli_query($conn, $cons);
while ($row = mysqli_fetch_array($query_cons)) { ?>
    <tr>
        <td><?php echo $linha++; ?></td>
        <td><?php echo $row['assunto']; ?></td>
        <td>
            <span class="badge badge-primary"><?php echo $row['categoria']; ?></span>
        </td>
        <td><?php echo $row['data']; ?></td>

        <td>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#verPostado<?php echo $row['id']; ?>">
                Abrir
            </button>
        </td>
    </tr>

    <div class="modal fade" id="verPostado<?php echo $row['id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><?php echo $row['assunto']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $row['conteudo']; ?>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo pg; ?>/pages/modulo/informativos/editar/edit_informativo?info=<?php echo $row['id']; ?>">
                        <button type="button" class="btn btn-primary">Alterar</button>
                    </a>                    
                </div>
            </div>
        </div>
    </div>

<?php } ?>