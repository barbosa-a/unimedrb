<?php
session_start();
$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");

$linha = 1;

$id = filter_input(INPUT_GET, 'informativo', FILTER_DEFAULT);

$cons = "SELECT 
    id, 
    titulo,
    nome_arquivo,
    caminho,
    DATE_FORMAT(created, '%d/%m/%Y') AS data 
    FROM informativos_anexos WHERE informativo_id = '{$id}' ORDER BY created ASC
";
$query_cons = mysqli_query($conn, $cons);
while ($row = mysqli_fetch_array($query_cons)) { ?>
    <tr>
        <td><?php echo $linha++; ?></td>
        <td><?php echo $row['titulo']; ?></td>
        <td><?php echo $row['data']; ?></td>

        <td>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#verAnexo<?php echo $row['id']; ?>">
                Abrir
            </button>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delAnexo<?php echo $row['id']; ?>">
                Excluir
            </button>
        </td>
    </tr>

    <div class="modal fade" id="verAnexo<?php echo $row['id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><?php echo $row['titulo']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="<?php echo pg ."/". $row['caminho']; ?>" frameborder="0" width="100%" height="500px"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delAnexo<?php echo $row['id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><?php echo $row['titulo']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center text-bold">Atenção <br> Deseja excluir este anexo?</p>
                    <p class="text-center text-bold"><?php echo $row['titulo']; ?></p>

                    <button type="button" class="btn btn-danger btn-block btn-lg" onclick="delAqruivo(<?php echo $row['id']; ?>)">Excluir arquivo</button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>