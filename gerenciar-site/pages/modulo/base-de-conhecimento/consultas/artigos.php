<?php
session_start();
$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");

$linha = 1;

$cons = "SELECT 
    bc.id, 
    bc.titulo, 
    u.nome_user, 
    DATE_FORMAT(bc.created_on, '%d/%m/%Y') AS data 
    FROM base_conhecimento bc 
    INNER JOIN usuarios u ON u.id_user = bc.usuario_id_on
    WHERE (bc.contrato_sistema_id = '{$_SESSION['contratoUSER']}' OR bc.contrato_sistema_id = 1)
";
$query_cons = mysqli_query($conn, $cons);
while ($row = mysqli_fetch_array($query_cons)) { ?>
    <tr>
        <td><?php echo $linha++; ?></td>
        <td><?php echo $row['titulo']; ?></td>
        <td><?php echo $row['nome_user']; ?></td>
        <td><?php echo $row['data']; ?></td>
        
        <td>
            <!-- Default dropleft button -->
            <div class="btn-group dropleft">
                <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false">
                    Menu
                </button>
                <div class="dropdown-menu">
                    <!-- Dropdown menu links -->
                    <a class="dropdown-item" href="<?php echo pg; ?>/pages/modulo/base-de-conhecimento/editar/edit_artigo?id=<?php echo $row['id']; ?>">Editar</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delArtigo<?php echo $row['id']; ?>">Apagar</a>
                </div>
            </div>
        </td>
    </tr>

    <!-- Modal Editar Artigo-->
    <div class="modal fade" id="delArtigo<?php echo $row['id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <p class="text-center text-bold"><?php echo $row['titulo']; ?></p>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo pg; ?>/pages/modulo/base-de-conhecimento/apagar/processa/proc_del_artigo?id=<?php echo $row['id']; ?>">
                        <button type="button" class="btn btn-danger">Excluir</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php } ?>