<?php
session_start();
$seguranca = true;
include_once "../../../../config/config.php";
include_once "../../../../config/conexao.php";
include_once "../../../../lib/ModInformativo.php";

$linha = 1;

$buscar = filter_input(INPUT_GET, 'buscar', FILTER_DEFAULT);

$cons = "SELECT
    i.id,
    i.assunto,
    i.conteudo,
    ic.categoria,
    DATE_FORMAT(i.created_on, '%d/%m/%Y') AS data,
    un.nome_uni,
    u.nome_user AS userPublicado,
    us.nome_user AS userAlt
    FROM informativos i
    INNER JOIN informativos_categorias ic ON ic.id = i.informativo_categoria_id
    INNER JOIN unidade un ON un.id_uni = i.unidade_id 
    INNER JOIN usuarios u ON u.id_user = ic.usuario_id_on
    LEFT JOIN usuarios us ON us.id_user = ic.usuario_id_at WHERE i.assunto LIKE '%$buscar%' ORDER BY i.created_on DESC LIMIT 100
";
$query_cons = mysqli_query($conn, $cons);
while ($row = mysqli_fetch_array($query_cons)) {?>
<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-6 d-flex align-items-stretch flex-column">
    <div class="card d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">
            <?php echo $row['nome_uni']; ?>
            <div class="card-tools">
                <?php echo $row['data']; ?>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="row">

                <div class="col-12">
                    <h2 class="lead">
                        <a href="#" data-toggle="modal" data-target="#abrirInfo<?php echo $row['id']; ?>">
                            <b class="text-dark"><?php echo $row['assunto']; ?></b>
                        </a>
                    </h2>
                    <p class="text-bold">
                        <span class="badge badge-primary"><?php echo $row['categoria']; ?></span>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="abrirInfo<?php echo $row['id']; ?>" data-backdrop="static" data-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><?php echo $row['assunto']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-12 col-md-12 col-lg-9 order-1 order-md-1">
                      <?php echo $row['conteudo']; ?>
                    </div>

                    <div class="col-12 col-md-12 col-lg-3 order-2 order-md-2">

                        <div class="text-muted">
                            <p class="text-sm">Autor
                                <b class="d-block"><?php echo $row['userPublicado']; ?></b>
                            </p>
                            <p class="text-sm">Categoria
                                <b class="d-block"><?php echo $row['categoria']; ?></b>
                            </p>
                            <p class="text-sm">Unidade
                                <b class="d-block"><?php echo $row['nome_uni']; ?></b>
                            </p>
                            <p class="text-sm">Data publicação
                                <b class="d-block"><?php echo $row['data']; ?></b>
                            </p>
                        </div>

                        <h5 class="mt-5 text-muted">Arquivos</h5>

                        <ul class="list-unstyled">
                            
                            <li>

                              <?php foreach (anexosInfos($conn, $row['id']) as $anx) { ?>
                                <a href="<?php echo pg . "/" . $anx['caminho']; ?>" class="btn-link text-dark" download="">
                                  <i class="fa fa-file-pdf-o"></i>
                                  <?php echo $anx['titulo']; ?>
                                </a>
                              <?php } ?>
                                
                            </li>
                            
                        </ul>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php }?>