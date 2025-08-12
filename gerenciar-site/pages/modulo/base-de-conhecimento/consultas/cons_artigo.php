<?php
session_start();
$seguranca = true;
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");
include_once("../../../../lib/ModBaseConhecimento.php");

$assunto = filter_input(INPUT_GET, 'assunto', FILTER_DEFAULT);

$cons = "SELECT 
    bc.id, 
    bc.titulo, 
    bc.conteudo, 
    bc.views, 
    bc.created_on, 
    DATE_FORMAT(bc.created_on, '%d/%m/%Y') AS data,
    u.nome_user 
    FROM base_conhecimento bc 
    INNER JOIN usuarios u ON u.id_user = bc.usuario_id_on 
    WHERE bc.titulo LIKE '%$assunto%' AND (bc.contrato_sistema_id = '{$_SESSION['contratoUSER']}' OR bc.contrato_sistema_id = 1) LIMIT 50 ";
$query_cons = mysqli_query($conn, $cons);
while ($row = mysqli_fetch_array($query_cons)) { ?>
    <div class="post">
        <div class="user-block">
            <img class="img-circle img-bordered-sm" src="<?php echo pg; ?>/dist/img/artigo.png" alt="artigo imagem">
            <span class="username">
                <a href="#" onclick="cadVisualizacao(<?php echo $row['id']; ?>)">
                    <?php echo $row['titulo']; ?>
                </a>
            </span>
            <span class="description">
                <i class="fa fa-user" aria-hidden="true"></i> <?php echo $row['nome_user']; ?> - <i class="fa fa-calendar-check-o" aria-hidden="true"></i> <?php echo contarTempo($row['created_on']); ?>
            </span>
        </div>
        <!-- /.user-block -->
        <p>
            <?php echo resumirTexto($row['conteudo'], 100); ?>
        </p>

        <p>
            <a href="#" class="link-black text-sm mr-2" onclick="cadCurtidas(<?php echo $row['id']; ?>, 1)"><i class="fa fa-thumbs-up mr-1"></i> Gostei</a>
            <a href="#" class="link-black text-sm" onclick="cadCurtidas(<?php echo $row['id']; ?>, 2)"><i class="fa fa-thumbs-down mr-1"></i> Não gostei</a>

            <span class="float-right">
                <a href="#" class="link-black text-sm">
                    <i class="fa fa-eye mr-1"></i> Visualizações (<?php echo $row['views'] == null ? 0 : $row['views']; ?>)
                </a>
            </span>
        </p>
    </div>

    <!-- Modal Visualizar-->
    <div class="modal fade" id="visuArtigo<?php echo $row['id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Artigo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center">
                        <?php echo $row['titulo']; ?> <br>
                        <small class="text-muted"><?php echo $row['nome_user']; ?> | <?php echo $row['data']; ?></small>
                    </h4>
                    <?php echo adicionarClasseImg($row['conteudo'], "img-fluid rounded"); ?>
                </div>
            </div>
        </div>
    </div>

<?php } ?>