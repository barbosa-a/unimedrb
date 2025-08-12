<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?php echo $Pagina_Atual; ?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">Página inicial</li>
          <li class="breadcrumb-item active"><a href="<?php echo pg; ?>/pages/modulo/home/home">Inicio</a></li>
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
      <div class="card-header">
        <h5 class="card-title">Formulário de cadastro</h5>
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
        <div class="bs-stepper">
          <div class="bs-stepper-header" role="tablist">
            <!-- your steps here -->
            <div class="step" data-target="#logins-part">
              <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                <span class="bs-stepper-circle">1</span>
                <span class="bs-stepper-label">Dados do contrato</span>
              </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#information-part">
              <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                <span class="bs-stepper-circle">2</span>
                <span class="bs-stepper-label">Dados de acesso</span>
              </button>
            </div>
          </div>
          <div class="bs-stepper-content">
            <form method="POST" action="<?php echo pg;  ?>/pages/modulo/sistema/cadastrar/processa/proc_cad_contrato" enctype="multipart/form-data">
              <!-- your steps content here -->
              <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">                                        
                <div class="form-row">
                  <div class="col-9 form-group">
                    <label for="Razão social">Razão social</label>
                    <input type="text" class="form-control" name="razao_social" value="" required autocomplete="off" autofocus placeholder="Nome da empresa" oninput="upperCase(event)"/>
                  </div>
                  <div class="col-3 form-group">
                    <label for="CNPJ">CNPJ</label>
                    <input type="text" class="form-control" name="cnpj" id="cnpj" value="" required autocomplete="off" placeholder="CNPJ" maxlength="14" />
                  </div>
                  
                </div>
                <div class="form-row">
                  <div class="col-6 form-group">
                    <label for="Nome fantasia">Nome fantasia</label>
                    <input type="text" class="form-control" name="nomeFantasia" required autocomplete="off" placeholder="Nome fantasia" />
                  </div>
                  <div class="col-6 form-group">
                    <label for="E-mail">E-mail</label>
                    <input type="text" class="form-control" name="email" value="" required autocomplete="off" placeholder="E-mail" />
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-6 form-group">
                    <label for="Responsavel financeiro">Responsável financeiro</label>
                    <input type="text" class="form-control" name="resp_financeiro" value="" required autocomplete="off" placeholder="Nome" />
                  </div>
                  <div class="col-6 form-group">
                    <label for="Telefone">Telefone</label>
                    <input type="text" class="form-control telefone" name="telefone" required autocomplete="off" placeholder="Número de contato"/>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-3 form-group">
                    <label for="CEP">CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control" required autocomplete="off" placeholder="CEP" maxlength="9" onblur="pesquisacep(this.value);" onkeypress="return somenteNumeros(event)"/>
                  </div>
                  <div class="col-6 form-group">
                    <label for="Endereço">Logradouro</label>
                    <input type="text" class="form-control" name="endereco" id="rua" required placeholder="Rua" oninput="upperCase(event)"/>
                  </div>                                        
                  <div class="col-3 form-group">
                    <label for="Número">Nº</label>
                    <input type="text" class="form-control" name="numero" required placeholder="Número" onkeypress="return somenteNumeros(event)"/>
                  </div>                                    
                </div>
                <div class="form-row">
                  <div class="col-4 form-group">
                    <label for="Bairro">Bairro</label>
                    <input type="text" class="form-control" name="bairro" id="bairro" required autocomplete="off" placeholder="Bairro" oninput="upperCase(event)" />
                  </div>
                  <div class="col-4 form-group">
                    <label for="Cidade">Cidade</label>
                    <input type="text" class="form-control" name="cidade" id="cidade" required autocomplete="off" placeholder="Cidade" oninput="upperCase(event)" />
                  </div>
                  <div class="col-4 form-group">
                    <label for="Estado">Estado</label>
                    <input type="text" class="form-control" name="estado" id="uf" required autocomplete="off" placeholder="Ex: AC" maxlength="2" oninput="upperCase(event)" />
                  </div>
                </div>
                <h5>Canais de atendimento <hr></h5>
                <div class="form-row">
                  <div class="colform-group">
                    <label for="Telefone">Telefone 1</label>
                    <input type="text" class="form-control telefone" name="telefone1" autocomplete="off" placeholder="Número de contato"/>
                  </div>
                  <div class="col form-group">
                    <label for="Telefone">Telefone 2</label>
                    <input type="text" class="form-control telefone" name="telefone2" autocomplete="off" placeholder="Número de contato"/>
                  </div>
                  <div class="col form-group">
                    <label for="Telefone">Telefone 3</label>
                    <input type="text" class="form-control telefone" name="telefone3" autocomplete="off" placeholder="Número de contato"/>
                  </div>
                  <div class="col form-group">
                    <label for="Telefone">Telefone 4</label>
                    <input type="text" class="form-control telefone" name="telefone4" autocomplete="off" placeholder="Número de contato"/>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-3 form-group">
                    <label for="Plano">Plano</label>
                    <select class="form-control" name="plano" onchange="Select_plano(this.value);" required>
                      <option value="">Selecione um plano</option>
                      <?php echo ListarPlanos($PlanoNome = null, "opcao_select", $conn); ?>
                    </select>
                  </div>
                  <div class="col-3 form-group">
                    <label for="Modelo de Plano">Modelo de plano</label>
                    <select class="form-control" name="modelo_plano" id="modelo_plano" onchange="Select_valor_plano(this.value);" required>
                      <option value="">Selecione um modelo</option>
                    </select>
                  </div>
                  <div class="col-3 form-group">
                    <label for="Vencimento mensal">Vencimento</label>
                    <input type="date" class="form-control" name="vencimento_mensal" value="" />
                  </div>
                  <div class="col-3 form-group">
                    <label for="Valor">Valor(R$)</label>
                    <input type="text" class="form-control" name="valor" id="valor_contrato" placeholder="R$ 0,00" readonly />
                  </div>                                  
                </div>
                <div class="form-row">
                  <div class="col-4 form-group">
                    <label for="Inicio do contrato">Inicio contrato</label>
                    <input type="date" class="form-control" name="inicio_contrato" value="" required />
                  </div>
                  <div class="col-4 form-group">
                    <label for="Fim do contrato">Fim contrato</label>
                    <input type="date" class="form-control" name="fim_contrato" value="" required />
                  </div>    
                  <div class="col-4 form-group">
                    <label for="Quantidade de usuários">Usuários</label>
                    <select class="form-control" name="qtd_user_liberados" required>
                      <option value="">Selecione...</option>
                      <?php foreach (ListarQtdUsuariosPorContrato($conn) as $Qtd_user) { ?>
                        <option value="<?php echo $Qtd_user['qtd']; ?>"><?php echo $Qtd_user['situacao']; ?></option>
                      <?php } ?>                       
                    </select>
                  </div>              
                </div>
                
                <div class="form-row">
                  <div class="form-group col-12">
                    <label for="Contrato">Contrato</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="arquivo">
                      <label class="custom-file-label" for="customFile">Selecione o contrato</label>
                    </div>
                  </div>
                </div>                                           
                <button class="btn btn-primary" onclick="stepper.next()">Próximo</button>
                <a href="<?php echo pg;  ?>/pages/modulo/sistema/sistema">
                  <button type="button" class="btn btn-secondary">Voltar</button>
                </a>
              </div>
              <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="Nome completo do usuário">Nome completo</label>
                    <input type="text" class="form-control" name="nome_completo" placeholder="Nome completo" required="" autofocus="" oninput="upperCase(event)" />
                  </div>
                  <div class="form-group col-md-6">
                    <label for="E-mail do usuário">E-mail</label>
                    <input type="email" class="form-control" name="email_user" placeholder="E-mail" required="">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="Usuário de acesso ao sistema">Usuário</label>
                    <input type="text" class="form-control" name="usuario" placeholder="Nome de usuário" required="" >
                  </div>
                  <div class="form-group col-md-4">
                    <label for="senha de acesso ao sistema">Senha</label>
                    <input type="password" class="form-control" name="senha" placeholder="Senha de acesso de no mínimo 6 caracteres" required="">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="Status do usuário">Status</label>
                    <select name="status" class="form-control" required="">
                      <option value="">Selecione...</option>
                      <?php echo statusUsuario($conn) ?>  
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="Local de trabalho do usuário">Unidade</label>
                    <select name="unidade" class="form-control" required="">
                      <option value="">Selecione...</option>
                      <?php foreach (unidadeUsuario($conn) as $row_unidade) { ?>
                        <option value="<?php echo $row_unidade['id_uni']; ?>"><?php echo $row_unidade['nome_uni']; ?></option> 
                      <?php } ?>                                        
                    </select>
                  </div>
                  <div class="form-group col-4">
                    <label for="Locação ou função do usuário">Cargo</label>
                    <select name="cargo" class="form-control" required="">
                      <option value="">Selecione...</option>
                      <?php foreach (cargoUsuario($conn) as $row_cargo) { ?>
                        <option value="<?php echo $row_cargo['id_cargo']; ?>"><?php echo $row_cargo['nome_cargo']; ?></option> 
                      <?php } ?> 
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="Perfil de acesso do usuário">Perfil de acesso</label>
                    <select name="perfil_acesso" class="form-control" required="">
                      <option value="">Selecione...</option>
                      <?php echo perfilUsuario($_SESSION['usuarioNIVEL'], $_SESSION['usuarioORDEM'], $conn) ?>  
                    </select>
                  </div>                        
                </div>
                <div class="form-row">
                  <div class="form-group col-12">
                    <label for="Descrição">Descrição</label>
                    <textarea name="anotacao" class="form-control" placeholder="Observação do usuário" rows="3"></textarea>
                  </div>
                </div>
                <input type="submit" name="SendCadContrato" class="btn btn-primary" value="Salvar" />
                <button class="btn btn-secondary" onclick="stepper.previous()">Anterior</button>                
              </div>
            </form>
          </div>
        </div> 
      </div>          
    </div><!-- /.card card-primary card-outline -->    
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->