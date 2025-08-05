<?php  
  $contrato = filter_input(INPUT_GET, 'contrato', FILTER_SANITIZE_NUMBER_INT);
  $infoContrato = ListarDadosContrato($contrato, $conn);
  if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
  }
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
          <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/home/home">Página inicial</a></li>
          <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/sistema/sistema">Sistema</a></li>
          <li class="breadcrumb-item ">Contrato</li>
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
      <div class="col-7">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title">Dados do contrato</h5>
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
            <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/editar/processa/proc_edit_contrato">
              <div class="form-row">
                <div class="col-8 form-group">
                  <label for="Razão social">Razão social</label>
                  <input type="text" class="form-control" name="razao_social" value="<?php echo $infoContrato['razao_social']; ?>" required autocomplete="off" autofocus placeholder="Nome da empresa" oninput="upperCase(event)"/>
                </div>
                <div class="col-4 form-group">
                  <label for="CNPJ">CNPJ</label>
                  <input type="text" class="form-control" name="cnpj" id="cnpj" value="<?php echo $infoContrato['cnpj'] ?>" required autocomplete="off" placeholder="CNPJ" maxlength="14" />
                </div>                
              </div>
              <div class="form-row">
                <div class="col-6 form-group">
                  <label for="Nome fantasia">Nome fantasia</label>
                  <input type="text" class="form-control" name="nomeFantasia" value="<?php echo $infoContrato['nome_fantasia'] ?>" required autocomplete="off" placeholder="Nome fantasia" />
                </div>
                <div class="col-6 form-group">
                  <label for="E-mail">E-mail</label>
                  <input type="text" class="form-control" name="email" value="<?php echo $infoContrato['email'] ?>" required autocomplete="off" placeholder="E-mail" />
                </div>
              </div>
              <div class="form-row">
                <div class="col-6 form-group">
                  <label for="Responsavel financeiro">Responsável financeiro</label>
                  <input type="text" class="form-control" name="resp_financeiro" value="<?php echo $infoContrato['resp_financeiro'] ?>" required autocomplete="off" placeholder="Nome" />
                </div>
                <div class="col-6 form-group">
                  <label for="Telefone">Telefone</label>
                  <input type="text" class="form-control telefone" name="telefone" required autocomplete="off" placeholder="Número de contato" value="<?php echo $infoContrato['telefone'] ?>" />
                </div>
              </div>
              <h5>Endereço <hr></h5>
              <div class="form-row">
                <div class="col-3 form-group">
                  <label for="CEP">CEP</label>
                  <input type="text" name="cep" id="cep" class="form-control" required autocomplete="off" placeholder="CEP" maxlength="9" onblur="pesquisacep(this.value);" onkeypress="return somenteNumeros(event)" value="<?php echo $infoContrato['cep'] ?>" />
                </div>
                <div class="col-6 form-group">
                  <label for="Endereço">Logradouro</label>
                  <input type="text" class="form-control" name="endereco" id="rua" required placeholder="Rua" oninput="upperCase(event)" value="<?php echo $infoContrato['rua'] ?>" />
                </div>                                        
                <div class="col-3 form-group">
                  <label for="Número">Nº</label>
                  <input type="text" class="form-control" name="numero" required placeholder="Número" onkeypress="return somenteNumeros(event)" value="<?php echo $infoContrato['numero']; ?>" />
                </div>                                    
              </div>
              <div class="form-row">
                <div class="col-4 form-group">
                  <label for="Bairro">Bairro</label>
                  <input type="text" class="form-control" name="bairro" id="bairro" required autocomplete="off" placeholder="Bairro" oninput="upperCase(event)" value="<?php echo $infoContrato['bairro']; ?>" />
                </div>
                <div class="col-4 form-group">
                  <label for="Cidade">Cidade</label>
                  <input type="text" class="form-control" name="cidade" id="cidade" required autocomplete="off" placeholder="Cidade" oninput="upperCase(event)" value="<?php echo $infoContrato['cidade']; ?>" />
                </div>
                <div class="col-4 form-group">
                  <label for="Estado">Estado</label>
                  <input type="text" class="form-control" name="estado" id="uf" required autocomplete="off" placeholder="Ex: AC" maxlength="2" oninput="upperCase(event)" value="<?php echo $infoContrato['estado']; ?>" />
                </div>
              </div>
              <h5>Canais de atendimento <hr></h5>
              <div class="form-row">
                <div class="colform-group">
                  <label for="Telefone">Telefone 1</label>
                  <input type="text" class="form-control telefone" name="telefone1" autocomplete="off" placeholder="Número de contato" value="<?php echo $infoContrato['telefone1'] ?>" />
                </div>
                <div class="col form-group">
                  <label for="Telefone">Telefone 2</label>
                  <input type="text" class="form-control telefone" name="telefone2" autocomplete="off" placeholder="Número de contato" value="<?php echo $infoContrato['telefone2'] ?>" />
                </div>
                <div class="col form-group">
                  <label for="Telefone">Telefone 3</label>
                  <input type="text" class="form-control telefone" name="telefone3" autocomplete="off" placeholder="Número de contato" value="<?php echo $infoContrato['telefone3'] ?>" />
                </div>
                <div class="col form-group">
                  <label for="Telefone">Telefone 4</label>
                  <input type="text" class="form-control telefone" name="telefone4" autocomplete="off" placeholder="Número de contato" value="<?php echo $infoContrato['telefone4'] ?>" />
                </div>
              </div>
              <h5>Plano contratado <hr></h5>
              <div class="form-row">
                <div class="col-4 form-group">
                  <label for="Plano">Plano</label>
                  <select class="form-control" name="plano" onchange="Select_plano(this.value);" required>
                    <option value="">Selecione um plano</option>
                    <?php echo ListarPlanos($infoContrato['plano'], "opcao_select", $conn); ?>
                  </select>
                </div>
                <div class="col-4 form-group">
                  <label for="Modelo de Plano">Modelo de plano</label>
                  <select class="form-control" name="modelo_plano" id="modelo_plano" onchange="Select_valor_plano(this.value);" required>
                    <option value="">Selecione um modelo</option>
                    <?php echo ListarModeloPlanoEdit($infoContrato['modelo_plano'], $conn); ?>
                  </select>
                </div>                
                <div class="col-4 form-group">
                  <label for="Valor">Valor(R$)</label>
                  <input type="text" class="form-control" name="valor" id="valor_contrato" placeholder="R$ 0,00" readonly value="<?php echo $infoContrato['valor_contrato']; ?>" />
                </div>                                  
              </div>
              <div class="form-row">
                <div class="col-4 form-group">
                  <label for="Vencimento mensal">Vencimento</label>
                  <input type="date" class="form-control" name="vencimento_mensal" value="<?php echo $infoContrato['vencimento']; ?>" />
                </div>
                <div class="col-4 form-group">
                  <label for="Inicio do contrato">Inicio contrato</label>
                  <input type="date" class="form-control" name="inicio_contrato" value="<?php echo $infoContrato['inicio_contrato']; ?>" required />
                </div>
                <div class="col-4 form-group">
                  <label for="Fim do contrato">Fim contrato</label>
                  <input type="date" class="form-control" name="fim_contrato" value="<?php echo $infoContrato['fim_contrato']; ?>" required />
                </div>
              </div>
              <div class="form-row">
                <div class="col-6 form-group">
                  <label for="Quantidade de usuários">Usuários</label>
                  <select class="form-control" name="qtd_user_liberados" required>
                    <option value="">Selecione...</option>
                    <?php foreach (ListarQtdUsuariosPorContrato($conn) as $Qtd_user) { ?>
                      <option value="<?php echo $Qtd_user['qtd']; ?>"
                        <?php if ($infoContrato['qtd_usuarios_liberados'] == $Qtd_user['qtd']) {
                          echo "selected";
                        } ?>
                      ><?php echo $Qtd_user['situacao']; ?></option>
                    <?php } ?> 
                  </select>
                </div>
                <div class="col-6 form-group">
                  <label for="Situação">Situação do contrato</label>
                  <select class="form-control" name="situacao" required>
                    <option value="">Selecione...</option>
                    <?php echo ListarSituacaoContrato($infoContrato['situacao_contrato_id'], $conn); ?>
                  </select>
                </div> 
              </div>              
              <input type="hidden" name="contrato" value="<?php echo $infoContrato['idcontratosistema']; ?>">
              <div class="form-group">
                <input type="submit" name="SendUpContrato" class="btn btn-primary" value="Salvar" />
                <a href="<?php echo pg; ?>/pages/modulo/sistema/sistema">
                  <button type="button" class="btn btn-secondary">Voltar</button>
                </a>
              </div>
            </form>
            <?php ?>            
          </div>
        </div>  
      </div>
      <div class="col-5">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title">Usuários vinculados</h5>
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
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Usuário</th>
                  <th scope="col">Data</th>
                </tr>
              </thead>
              <tbody>
                <?php echo ListarUsuarios($contrato, $conn) ?>                
              </tbody>
            </table>        
          </div>
        </div>
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title">Anexo do contrato</h5>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#CadNovoAnexo" data-card-widget="">
                  <i class="fa fa-plus-square"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fa fa-times"></i>
                </button>
              </div>
          </div>
          <div class="card-body">
            <ul class="list-unstyled">
              <li class="item">
                <i class="fa fa-file fa-1x" aria-hidden="true"></i>
                <a href="" data-toggle="modal" data-target="#anexo_contrato_xl"><?php echo $infoContrato['anexo_contrato']; ?></a>
              </li>
            </ul>            
          </div>
        </div>  
      </div>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div><!-- /.content -->
<div class="modal fade" id="anexo_contrato_xl">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Visualizar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe src="<?php echo pg; ?>/pages/modulo/sistema/contratos/<?php echo $infoContrato['anexo_contrato']; ?>" width="100%" height="500px"></iframe>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Modal Cadastrar novo anexo-->
<div class="modal fade" id="CadNovoAnexo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Atualizar anexo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo pg; ?>/pages/modulo/sistema/editar/processa/proc_edit_anexo" enctype="multipart/form-data">
            <div class="form-group">
              <label>Arquivo</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="arquivo">
                <label class="custom-file-label" for="customFile">Selecione o contrato</label>
              </div>
            </div>
            <input type="hidden" name="contrato" value="<?php echo $infoContrato['idcontratosistema']; ?>">
            <input type="submit" class="btn btn-primary" name="sendAtualizarAnexo" value="Salvar">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>    
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Cadastrar novo anexo-->