<?php
session_start();
$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");

$linha = 1;

$cons = "SELECT *, DATE_FORMAT(created_on, '%d/%m/%Y') AS data FROM apis_documentacao";
$query_cons = mysqli_query($conn, $cons);
while ($row = mysqli_fetch_array($query_cons)) { ?>
    <tr>
        <td><?php echo $linha++; ?></td>
        <td><?php echo $row['assunto']; ?></td>
        <td><?php echo $row['data']; ?></td>
        <td>
            <!-- Default dropleft button -->
            <div class="btn-group dropleft">
                <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                    Menu
                </button>
                <div class="dropdown-menu">
                    <!-- Dropdown menu links -->
                    <a class="dropdown-item" href="<?php echo pg; ?>/pages/modulo/sistema/editar/edit_doc?id=<?php echo $row['id']; ?>">Editar</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delDocApi<?php echo $row['id']; ?>">Apagar</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#visuDocApi<?php echo $row['id']; ?>">Visualizar</a>
                </div>
            </div>
        </td>
    </tr>

    <!-- Modal Editar API-->
    <div class="modal fade" id="delDocApi<?php echo $row['id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Atenção</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Deseja excluir este registro?</p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo pg; ?>/pages/modulo/sistema/apagar/processa/proc_del_doc?id=<?php echo $row['id']; ?>">
                        <button type="button" class="btn btn-danger">Excluir</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Visualizar API-->
    <div class="modal fade" id="visuDocApi<?php echo $row['id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><?php echo $row['assunto']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $row['documentacao']; ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>