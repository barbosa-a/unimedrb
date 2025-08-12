<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?php echo $Pagina_Atual; ?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">          
          <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/home/home">Página inicial</a></li>
          <li class="breadcrumb-item">Importação</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-4">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title">Menu de importação</h5>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fa fa-times"></i>
                </button>
              </div>
          </div>
          <div class="card-body">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-pills-usuarios-tab" data-toggle="pill" href="#v-pills-usuarios" role="tab" aria-controls="v-pills-usuarios" aria-selected="true">Usuários</a>
              <a class="nav-link" id="v-pills-beneficiario-tab" data-toggle="pill" href="#v-pills-beneficiario" role="tab" aria-controls="v-pills-beneficiario" aria-selected="true">Beneficiários</a>
            </div> 
          </div>
        </div><!-- /.card -->  
      </div>
      <div class="col-8">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title">Importação de dados</h5>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fa fa-times"></i>
                </button>
              </div>
          </div>
          <div class="card-body">
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-usuarios" role="tabpanel" aria-labelledby="v-pills-usuarios-tab">
                <form method="POST" action="<?php echo pg; ?>/pages/modulo/importar/processa/proc_import_usuario" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="Contrato">Contrato</label>
                    <select class="form-control" name="contrato" required>
                      <option value="">Selecione...</option>
                      <?php foreach (ListarContratosAtivos($conn) as $dadoContrato) { ?>
                        <option value="<?php echo $dadoContrato['idcontratosistema']; ?>"><?php echo $dadoContrato['razao_social']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-row">
                    <div class="form-group col">
                      <label for="Cargo">Cargo</label>
                      <select class="form-control" name="cargo" required>
                        <option value="">Selecione...</option>
                        <?php foreach (cargoUsuario($conn) as $row_cargo) { ?>
                          <option value="<?php echo $row_cargo['id_cargo']; ?>"><?php echo $row_cargo['nome_cargo']; ?></option> 
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col">
                      <label for="Unidade">Unidade</label>
                      <select class="form-control" name="unidade" required>
                        <option value="">Selecione...</option>
                        <?php foreach (unidadeUsuario($conn) as $row_unidade) { ?>
                          <option value="<?php echo $row_unidade['id_uni']; ?>"><?php echo $row_unidade['nome_uni']; ?></option> 
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Arquivo">Arquivo</label>
                    <input type="file" class="form-control-file" name="arquivo" required>
                  </div>
                  <hr>
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="SendImportUsuario" value="Importar">
                  </div>
                </form>
                <ul class="list-unstyled">
                  <li>Preparação do arquivo:
                    <ul>
                      <li>Coluna 1: Nome completo</li>
                      <li>Coluna 2: E-mail</li>
                      <li>Coluna 3: Login de acesso</li>
                      <li>Coluna 4: Senha de acesso</li>                      
                      <li>Retirar o cabeçalho da planilha</li>
                      <li>Formato: XML(Planilha xml 2003)</li>
                    </ul>
                  </li>
                </ul>
              </div>

              <div class="tab-pane fade" id="v-pills-beneficiario" role="tabpanel" aria-labelledby="v-pills-beneficiario-tab">
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-add-api-tab" data-toggle="pill" href="#custom-content-below-add-api" role="tab" aria-controls="custom-content-below-add-api" aria-selected="true">Adicionar API</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-apis-tab" data-toggle="pill" href="#custom-content-below-apis" role="tab" aria-controls="custom-content-below-apis" aria-selected="false">APIs</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-consumir-tab" data-toggle="pill" href="#custom-content-below-consumir" role="tab" aria-controls="custom-content-below-consumir" aria-selected="false">Consumir dados</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-importar-tab" data-toggle="pill" href="#custom-content-below-importar" role="tab" aria-controls="custom-content-below-importar" aria-selected="false">Importar</a>
                  </li>
                </ul>
                <div class="tab-content mt-3" id="custom-content-below-tabContent">
                  <div class="tab-pane fade active show" id="custom-content-below-add-api" role="tabpanel" aria-labelledby="custom-content-below-add-api-tab">

                    <form id="formDataApi" enctype="multipart/form-data">
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="API">API</label>
                          <input type="text" class="form-control" name="api" id="api" required placeholder="Link" />
                        </div>
                        <div class="form-group col-3">
                          <label for="Cron">Cron</label>
                          <input type="time" step="2" class="form-control" name="cron" id="cron" placeholder="Cron" />
                        </div>
                        <div class="form-group col-3">
                          <label for="Requisição">Requisição</label>
                          <select class="form-control" name="requisicao" id="requisicao" required>
                            <option value="">Selecione...</option>
                            <option value="POST">POST</option>
                            <option value="GET">GET</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="submit" class="btn btn-primary" id="sendCadApi" value="Salvar">
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="custom-content-below-apis" role="tabpanel" aria-labelledby="custom-content-below-apis-tab">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Url</th>
                          <th scope="col">Cron</th>
                          <th scope="col">Método</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody id="list-apis">
                        
                        
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane fade" id="custom-content-below-consumir" role="tabpanel" aria-labelledby="custom-content-below-consumir-tab">
                    <form id="formDataCurlApi" method="POST">
                      <div class="form-row align-items-center">
                        <div class="col-auto my-1">
                          <label class="mr-sm-2 sr-only" for="API">API</label>
                          <select class="custom-select mr-sm-2" id="cons_api" name="cons_api" required>
                            
                          </select>
                        </div>
                        <div class="col-auto my-1">
                          <input type="submit" class="btn btn-primary" id="consCurlApi" value="Consultar API">
                        </div>
                      </div>
                    </form>
                    <textarea id="" class="p-3 form-control listCUrlApi" rows="10"></textarea>
                  </div>
                  <div class="tab-pane fade" id="custom-content-below-importar" role="tabpanel" aria-labelledby="custom-content-below-importar-tab">
                    
                    <div class="row">
                      <div class="col-5 col-sm-3">
                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                          <a class="nav-link active" id="vert-tabs-beneficiario-tab" data-toggle="pill" href="#vert-tabs-beneficiario" role="tab" aria-controls="vert-tabs-beneficiario" aria-selected="true">Beneficiário</a>
                          <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Carteira</a>
                          <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Documentação</a>
                        </div>
                      </div>
                      <div class="col-7 col-sm-9">
                        <div class="tab-content" id="vert-tabs-tabContent">
                          <div class="tab-pane text-left fade show active" id="vert-tabs-beneficiario" role="tabpanel" aria-labelledby="vert-tabs-beneficiario-tab">
                          
                            <form id="formDataImportApi" method="POST">
                              <div class="form-row align-items-center">
                                <div class="col-auto my-1">
                                  <label class="mr-sm-2 sr-only" for="Metodo">Metodo</label>
                                  <select class="custom-select mr-sm-2" id="tipo_import" name="tipo_import" required>
                                    <option value="">Selecione...</option>
                                    <option value="Update">Atualizar</option>
                                    <option value="Insert">Cadastrar</option> 
                                  </select>
                                </div>
                                <div class="col-auto my-1">
                                  <label class="mr-sm-2 sr-only" for="API">API</label>
                                  <select class="custom-select mr-sm-2" id="cons_api_import" name="cons_api_import" required>
                                    
                                  </select>
                                </div>
                                <div class="col-auto my-1">
                                  <input type="submit" class="btn btn-primary" id="importDadosApi" value="Importar dados">
                                </div>
                              </div>
                            </form>

                          </div>
                          <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                            
                            <form id="formDataImportCarteiraApi" method="POST">
                              <div class="form-row align-items-center">
                                <div class="col-auto my-1">
                                  <label class="mr-sm-2 sr-only" for="Metodo">Metodo</label>
                                  <select class="custom-select mr-sm-2" id="tipo_import_carteira" name="tipo_import_carteira" required>
                                    <option value="">Selecione...</option>
                                    <option value="Update">Atualizar</option>
                                    <option value="Insert">Cadastrar</option> 
                                  </select>
                                </div>
                                <div class="col-auto my-1">
                                  <label class="mr-sm-2 sr-only" for="API">API</label>
                                  <select class="custom-select mr-sm-2" id="api_carteiras" name="api_carteiras" required>
                                    
                                  </select>
                                </div>
                                <div class="col-auto my-1">
                                  <input type="submit" class="btn btn-primary" id="importDadosCarteirasApi" value="Importar dados">
                                  <input type="button" class="btn btn-secondary" id="updateQrcodeCarteiras" value="Gerar qrcode">
                                </div>
                              </div>
                            </form>

                          </div>
                          <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                            
                            <form id="formDataImportDocApi" method="POST">
                              <div class="form-row align-items-center">
                                <div class="col-auto my-1">
                                  <label class="mr-sm-2 sr-only" for="Metodo">Metodo</label>
                                  <select class="custom-select mr-sm-2" id="tipo_import_docs" name="tipo_import_docs" required>
                                    <option value="">Selecione...</option>
                                    <option value="Update">Atualizar</option>
                                    <option value="Insert">Cadastrar</option> 
                                  </select>
                                </div>
                                <div class="col-auto my-1">
                                  <label class="mr-sm-2 sr-only" for="API">API</label>
                                  <select class="custom-select mr-sm-2" id="api_doc" name="api_doc" required>
                                    
                                  </select>
                                </div>
                                <div class="col-auto my-1">
                                  <input type="submit" class="btn btn-primary" id="importDadosDocApi" value="Importar dados">
                                </div>
                              </div>
                            </form>

                          </div>
                          
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
                
              </div>

            </div>
          </div>
        </div><!-- /.card -->
      </div>
    </div>
  </div><!-- /.container-fluid -->
</div><!-- /.content -->

<div class="modal fade" id="editApiModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Editar API</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formDataEditApis">
          <div class="row">
            <div class="form-group col-6">
              <label for="API">API</label>
              <input type="text" class="form-control" id="editApiLink" name="editApiLink" required placeholder="Link"/>
            </div>
            <div class="form-group col-3">
              <label for="Cron">Cron</label>
              <input type="time" step="2" class="form-control" id="editApiCron" name="editApiCron" placeholder="Cron"/>
            </div>
            <div class="form-group col-3">
              <label for="Requisição">Requisição</label>
              <select class="form-control" id="editApiMetodo" name="editApiMetodo" required>
                <option value="">Selecione...</option>
                
              </select>
            </div>
            <input type="hidden" id="editApiId" name="editApiId">
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" id="sendEditApi" value="Salvar">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>