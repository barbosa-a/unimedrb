<?php  
  if (!isset($seguranca)) {
    exit;
  }

  $quiz = confQuiz($conn);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?php echo $Pagina_Atual; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">
                        <a href="<?php echo pg; ?>/pages/modulo/home/home">Página inicial</a>
                    </li>
                    <li class="breadcrumb-item"><?php echo $Pagina_Atual; ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <!--<div class="card-header">
        <h5 class="card-title">Home</h5>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fa fa-times"></i>
            </button>
          </div>
      </div> -->
            <div class="card-body">

                <div class="row">
                    <div class="col-5 col-sm-3">
                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                            aria-orientation="vertical">
                            <a class="nav-link active" id="vert-tabs-perguntas-tab" data-toggle="pill"
                                href="#vert-tabs-perguntas" role="tab" aria-controls="vert-tabs-perguntas"
                                aria-selected="true">Perguntas</a>
                            <a class="nav-link" id="vert-tabs-premiacoes-tab" data-toggle="pill"
                                href="#vert-tabs-premiacoes" role="tab" onclick="todosPremio()">Premiações</a>
                            <a class="nav-link" id="vert-tabs-configuracoes-tab" data-toggle="pill"
                                href="#vert-tabs-configuracoes" role="tab" aria-controls="vert-tabs-configuracoes"
                                aria-selected="false">Configurações</a>
                            <!--<a class="nav-link" id="vert-tabs-relatorios-tab" data-toggle="pill"
                                href="#vert-tabs-relatorios" role="tab" aria-controls="vert-tabs-relatorios"
                                aria-selected="false">Relatórios</a> -->

                        </div>
                    </div>
                    <div class="col-7 col-sm-9">
                        <div class="tab-content" id="vert-tabs-tabContent">
                            <div class="tab-pane text-left fade active show" id="vert-tabs-perguntas" role="tabpanel"
                                aria-labelledby="vert-tabs-perguntas-tab">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Pergunta</th>
                                            <th scope="col">Data</th>
                                            <th scope="col">Status</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="todasPerguntas">

                                    </tbody>
                                </table>

                                <hr>

                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#novaPergunta">
                                    Nova pergunta
                                </button>

                                <!-- Modal nova pergunta-->
                                <div class="modal fade" id="novaPergunta" data-backdrop="static" data-keyboard="false"
                                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Nova pergunta</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form id="formDataPergunta">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="pergunta"
                                                            name="pergunta[]" autocomplete="off" required
                                                            placeholder="Digite a pergunta">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-primary"
                                                                id="add-input-btn">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div id="inputs-wrapper">
                                                        <!-- Inputs dinâmicos serão adicionados aqui -->
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Status">Status</label>
                                                        <select class="form-control" id="status" name="status" required>
                                                            <option selected value="">Selecione...</option>
                                                            <option value="Publicado">Publicado</option>
                                                            <option value="Rascunho">Rascunho</option>
                                                        </select>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary"
                                                        id="btnSavePergunta">Salvar</button>
                                                    <button id="clear-all-btn" class="btn btn-danger">Limpar
                                                        campos</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Fechar</button>
                                                </form>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="novaResposta" data-backdrop="static" data-keyboard="false"
                                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Nova resposta <small
                                                        class="text-muted" id="title-pergunta"></small></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form id="formDataResposta">

                                                    <div id="input-container">
                                                        <div class="row input-row">
                                                            <div class="col-3">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="status[]"
                                                                        required>
                                                                        <option selected value="">Situação...</option>
                                                                        <option value="Correta">Correta</option>
                                                                        <option value="Incorreta">Incorreta</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        name="resposta[]" autocomplete="off" required
                                                                        placeholder="Digite a resposta">
                                                                    <div class="input-group-append">
                                                                        <button type="button"
                                                                            class="btn btn-primary add-input-btn-resp">
                                                                            <i class="fa fa-plus"
                                                                                aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="perguntaID" name="perguntaID">

                                                    <div id="inputs-wrapper-respostas">
                                                        <!-- Inputs dinâmicos serão adicionados aqui -->
                                                    </div>

                                                    <button type="submit" class="btn btn-primary"
                                                        id="btnSaveResposta">Salvar</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Fechar</button>
                                                </form>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="verRespostas" data-backdrop="static" data-keyboard="false"
                                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Ver respostas <small
                                                        class="text-muted" id="title-pergunta-resposta"></small></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Resposta</th>
                                                            <th scope="col">Situação</th>
                                                            <th scope="col">Data</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="todasRespostas">
                                                        
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="vert-tabs-premiacoes" role="tabpanel" aria-labelledby="vert-tabs-premiacoes-tab">
                                
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Prêmio</th>
                                            <th scope="col">Quantidade</th>
                                            <th scope="col">Data</th>
                                            <th scope="col">Status</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="todosPremio">

                                    </tbody>
                                </table>

                                <hr>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#novoPremio">
                                    Novo Prêmio
                                </button>

                                <!-- Modal novo prêmio -->
                                <div class="modal fade" id="novoPremio" data-backdrop="static" data-keyboard="false"
                                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Novo Prêmio</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form id="formDataPremio">
                                                    
                                                    <div class="form-group">
                                                        <label for="Prêmio">Prêmio</label>
                                                        <input type="text" class="form-control" id="premio" name="premio" autocomplete="off" required placeholder="Nome">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Quantidade">Quantidade</label>
                                                        <input type="number" class="form-control" id="qtd" name="qtd" autocomplete="off" required placeholder="Ex: 10">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Status">Status</label>
                                                        <select class="form-control" id="status" name="status" required>
                                                            <option selected value="">Selecione...</option>
                                                            <option value="Ativo">Ativo</option>
                                                            <option value="Inativo">Inativo</option>
                                                        </select>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary"
                                                        id="btnSavePremio">Salvar</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Fechar</button>
                                                </form>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="tab-pane fade" id="vert-tabs-configuracoes" role="tabpanel" aria-labelledby="vert-tabs-configuracoes-tab">

                                
                                <div class="row">
                                    <div class="col">
                                        <h5>Configurações do Quiz</h5>
                                    </div>
                                    <div class="col-3 text-right">
                                        <a href="<?php echo pg ?>/quiz/" target="_blank">
                                            <button type="button" class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-external-link" aria-hidden="true"></i> Acessar quiz
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <hr>

                                <form id="formDataConfig">
                                    <div class="form-group">
                                        <label for="Titulo">Titulo</label>
                                        <input type="text" class="form-control" name="titulo" required placeholder="Quiz" value="<?php echo isset($quiz['titulo']) ? $quiz['titulo'] : "" ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Subtitulo">Subtitulo</label>
                                        <input type="text" class="form-control" name="subtitulo" required placeholder="Digite aqui..." value="<?php echo isset($quiz['subtitulo']) ? $quiz['subtitulo'] : "" ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Descrição">Descrição</label>
                                        <input type="text" class="form-control" name="descricao" required placeholder="Quiz" value="<?php echo isset($quiz['descricao']) ? $quiz['descricao'] : "" ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Número de questões">Número de questões</label>
                                        <input type="number" class="form-control" name="totalPerguntas" required placeholder="Quiz" value="<?php echo isset($quiz['totalPerguntas']) ? $quiz['totalPerguntas'] : 5 ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Habilitar roleta">Habilitar roleta</label>
                                        <select class="form-control" name="habilitarRoleta" required>
                                            <option value="">Selecione...</option>
                                            <?php foreach ($habilitarQuiz as $op) { ?>
                                                <option value="<?php echo $op; ?>" <?php echo @$quiz['habilitarRoleta'] == $op ? "selected" : "" ?>>
                                                    <?php echo $op; ?>
                                                </option>
                                            <?php } ?>

                                        </select>
                                    </div>

                                    <input type="hidden" name="id" value="<?php echo @$quiz['id']; ?>">
                                    
                                    <button type="submit" class="btn btn-primary" id="sendConfig">Salvar</button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editLogo">
                                        Logo
                                    </button>
                                </form>

                                <div class="modal fade" id="editLogo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Alterar logo</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" id="formDataLogo">
                                                    <div class="form-group">
                                                        <label for="Arquivo de imagem">Arquivo de imagem</label>
                                                        <input type="file" class="form-control-file" name="arquivo" required>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary" id="btnLogo">Salvar</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>     
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="vert-tabs-relatorios" role="tabpanel" aria-labelledby="vert-tabs-relatorios-tab">
                                
                                

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->