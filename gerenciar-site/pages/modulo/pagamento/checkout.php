<?php
if (!isset($seguranca)) {
    exit;
}

$cart = dadosCartao($conn);
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
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-four-faturas-tab" data-toggle="pill" href="#custom-tabs-four-faturas" role="tab">Faturas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-pagamentos-tab" data-toggle="pill" href="#custom-tabs-four-pagamentos" role="tab">Dados do cartão</a>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Settings</a>
                    </li> -->
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-four-faturas" role="tabpanel" aria-labelledby="custom-tabs-four-faturas-tab">

                        <table class="table table-striped projetcs">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Forma de pagamento</th>
                                    <th scope="col">Plano</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Data</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (faturas($conn) as $ft) { ?>
                                    
                                    <tr>
                                        <th scope="row"><?php echo $ft['nFatura']; ?></th>
                                        <td><?php echo $ft['pagamento']; ?></td>
                                        <td><?php echo $ft['nome_mod_plano']; ?></td>
                                        <td><?php echo number_format($ft['valorPago'], 2, ",", "."); ?></td>
                                        <td><?php echo $ft['status']; ?></td>
                                        <td><?php echo $ft['data']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm">Print</button>
                                        </td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-pagamentos" role="tabpanel" aria-labelledby="custom-tabs-four-pagamentos-tab">

                        <h5> <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Dados do cartão <small class="text-muted">para débito automatico</small><hr></h5>

                        <form id="formDataCartao" method="POST">

                            <div class="form-row">
                                <div class="form-group col-8">
                                    <label for="Titular">Titular</label>
                                    <input type="text" class="form-control" name="titular" require autocomplete="off" placeholder="Impresso no cartão" value="<?php echo isset($cart['titular']) ? $cart['titular'] : "" ?>">
                                </div>
                                <div class="form-group col">
                                    <label for="CPF">CPF</label>
                                    <input type="number" class="form-control" name="cpf" require autocomplete="off" placeholder="CPF" value="<?php echo isset($cart['cpf']) ? $cart['cpf'] : "" ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Número">Número</label>
                                <input type="number" class="form-control" name="ncartao" require autocomplete="off" placeholder="Cartão" value="<?php echo isset($cart['ncartao']) ? $cart['ncartao'] : "" ?>">
                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="Mês">Mês de validade</label>
                                    <input type="number" class="form-control" name="mes" maxlength="2" require autocomplete="off" placeholder="02" value="<?php echo isset($cart['mes']) ? $cart['mes'] : "" ?>">
                                </div>

                                <div class="form-group col">
                                    <label for="Ano de validade">Ano de validade</label>
                                    <input type="number" class="form-control" name="ano" maxlength="4" require autocomplete="off" placeholder="2055" value="<?php echo isset($cart['ano']) ? $cart['ano'] : "" ?>">
                                </div>

                                <div class="form-group col">
                                    <label for="Código de segurança">Código de segurança</label>
                                    <input type="number" class="form-control" name="cod" require autocomplete="off" placeholder="123" value="<?php echo isset($cart['cod']) ? $cart['cod'] : "" ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Função">Função</label>
                                <select class="form-control" name="funcao" require>
                                    <option value="">Selecione...</option>
                                    <?php foreach (funcaoCartao($conn) as $fun) { ?>
                                        <option value="<?php echo $fun['id']; ?>" <?php echo $fun['id'] == $cart['usuarios_cartao_funcao_id'] ? "selected" : "" ; ?>>
                                            <?php echo $fun['funcao']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <h5> <i class="fa fa-address-card" aria-hidden="true"></i> Endereço de cobrança <hr></h5>

                            <div class="form-row">
                                <div class="form-group col-3">
                                    <label for="CEP">CEP</label>
                                    <input type="number" class="form-control" name="cep" id="cep" require autocomplete="off" placeholder="CEP" onblur="pesquisacep(this.value)" value="<?php echo isset($cart['cep']) ? $cart['cep'] : "" ?>">
                                </div>

                                <div class="form-group col">
                                    <label for="Logradouro">Logradouro</label>
                                    <input type="text" class="form-control" name="rua" id="rua" require autocomplete="off" placeholder="Logradouro" value="<?php echo isset($cart['rua']) ? $cart['rua'] : "" ?>">
                                </div>

                                <div class="form-group col-3">
                                    <label for="Número">Número</label>
                                    <input type="number" class="form-control" name="numero" id="numero" require autocomplete="off" placeholder="Número" value="<?php echo isset($cart['numero']) ? $cart['numero'] : "" ?>">
                                </div>
                            </div>

                            

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="Bairro">Bairro</label>
                                    <input type="text" class="form-control" name="bairro" id="bairro" require autocomplete="off" placeholder="Bairro" value="<?php echo isset($cart['bairro']) ? $cart['bairro'] : "" ?>">
                                </div>

                                <div class="form-group col">
                                    <label for="Cidade">Cidade</label>
                                    <input type="text" class="form-control" name="cidade" id="cidade" require autocomplete="off" placeholder="Cidade" value="<?php echo isset($cart['cidade']) ? $cart['cidade'] : "" ?>">
                                </div>

                                <div class="form-group col">
                                    <label for="UF">UF</label>
                                    <input type="text" class="form-control" name="uf" id="uf" maxlength="2" require autocomplete="off" placeholder="UF" value="<?php echo isset($cart['estado']) ? $cart['estado'] : "" ?>">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="btncartao">Salvar</button>
                        </form>

                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">

                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">

                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->