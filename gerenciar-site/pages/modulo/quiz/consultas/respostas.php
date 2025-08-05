<?php
session_start();
$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");

$linha = 1;

$id = filter_input(INPUT_GET, "perguntaID", FILTER_SANITIZE_NUMBER_INT);

$cons = "SELECT 
    r.id, 
    r.quiz_pergunta_id,
    p.pergunta,
    r.resposta,
    r.situacao,
    DATE_FORMAT(r.created, '%d/%m/%Y') AS data 
    FROM quiz_pergunta_respostas r INNER JOIN quiz_perguntas p ON p.id = r.quiz_pergunta_id WHERE r.quiz_pergunta_id = '{$id}' ORDER BY r.id ASC
";
$query_cons = mysqli_query($conn, $cons);
while ($row = mysqli_fetch_array($query_cons)) { ?>
<tr>
    <td><?php echo $linha++; ?></td>

    <td><?php echo $row['resposta']; ?></td>    

    <td>
        <a href="#" onclick="alterarStatusResposta('<?php echo $row['situacao'] == 'Incorreta' ? 'Correta' : 'Incorreta' ; ?>', <?php echo $row['id']; ?>, <?php echo $row['quiz_pergunta_id']; ?>, '<?php echo $row['pergunta']; ?>')">
            <span class="badge badge-<?php echo $row['situacao'] == 'Correta' ? 'primary' : 'danger' ; ?>"><?php echo $row['situacao']; ?></span>
        </a>
    </td>

    <td><?php echo $row['data']; ?></td>

    <td>
        <button type="button" class="btn btn-danger btn-sm" onclick="excluirResposta(<?php echo $row['id']; ?>, <?php echo $row['quiz_pergunta_id']; ?>, '<?php echo $row['pergunta']; ?>')">Excluir</button>    
    </td>
    
</tr>

<div class="modal fade" id="delResposta<?php echo $row['id']; ?>" data-backdrop="static" data-keyboard="false"
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
                <p class="text-center">Deseja excluir esta resposta <br> <?php echo $row['resposta']; ?></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" >Excluir</button>
            </div>
        </div>
    </div>
</div>

<?php } ?>