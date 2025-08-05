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
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="bs-stepper linear">
                    <div class="bs-stepper-header" role="tablist">
                        <!-- your steps here -->
                        <div class="step active" data-target="#planos-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="planos-part" id="planos-part-trigger" aria-selected="true">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Plano</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#logins-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger" aria-selected="false" disabled="disabled">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Forma de pagamento</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#information-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger" aria-selected="false" disabled="disabled">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Endereço de cobrança</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#confirmacao-part">
                            <button type="button" class="step-trigger" role="tab" aria-controls="confirmacao-part" id="confirmacao-part-trigger" aria-selected="false" disabled="disabled">
                                <span class="bs-stepper-circle">4</span>
                                <span class="bs-stepper-label">Confirmação</span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <!-- your steps content here -->
                        <div id="planos-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="planos-part-trigger">

                            <form id="formDataCartPlano" method="post">
                                <?php foreach (planos($conn) as $plano) { ?>
                                    <div class="info-box mb-3 bg-primary">
                                        <span class="info-box-icon">
                                            <input type="radio" name="planoAtual" id="plano<?php echo $plano['idmodeloplano']; ?>" value="<?php echo $plano['idmodeloplano']; ?>" require onclick="escolherPlano(this.value)">
                                            <i class="ml-3 fa fa-cart-plus"></i>
                                        </span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">
                                                <?php echo $plano['nome_mod_plano']; ?> <i class="">(<?php echo $plano['descricao']; ?>)</i>
                                            </span>
                                            <span class="info-box-number">R$ <?php echo number_format($plano['valor_plano'], 2, ",", "."); ?> reais</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                <?php } ?>

                                <button type="submit" class="btn btn-primary" id="btnPayPlano">Continuar</button>
                            </form>
                        </div>
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">

                            <div class="form-group clearfix text-center">

                                <?php foreach (formasPagamento($conn) as $fun) { ?>

                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="fpag<?php echo $fun['id']; ?>" name="fpag" value="<?php echo $fun['id']; ?>" onclick="formPag('pay'+this.value)">
                                        <label for="fpag<?php echo $fun['id']; ?>">
                                            <?php echo $fun['pagamento']; ?>
                                        </label>
                                    </div>

                                <?php } ?>

                            </div>

                            <div id="pay2" class="hidden-pay">

                                <h5>Pagar com cartão de débito
                                    <hr>
                                </h5>

                                <form id="formDataPayDebito" method="post">

                                    <div class="form-row">
                                        <div class="form-group col-8">
                                            <label for="Titular">Titular</label>
                                            <input type="text" class="form-control" id="titular" name="titular" placeholder="Nome impresso no cartão" require value="<?php echo isset($cart['titular']) ? $cart['titular'] : "" ?>">
                                        </div>
                                        <div class="form-group col">
                                            <label for="CPF">CPF</label>
                                            <input type="number" class="form-control" id="cpf" name="cpf" placeholder="CPF" require value="<?php echo isset($cart['cpf']) ? $cart['cpf'] : "" ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="Número do cartão">E-mail do titular</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" require value="<?php echo isset($cart['emailTitular']) ? $cart['emailTitular'] : "" ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="Número do cartão">Número do cartão</label>
                                        <input type="number" class="form-control" id="ncartao" name="ncartao" placeholder="Impresso no cartão" require value="<?php echo isset($cart['ncartao']) ? $cart['ncartao'] : "" ?>">
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="Mês">Mês</label>
                                            <input type="number" class="form-control" id="mes" name="mes" maxlength="2" placeholder="02" require value="<?php echo isset($cart['mes']) ? $cart['mes'] : "" ?>">
                                        </div>
                                        <div class="form-group col">
                                            <label for="Ano">Ano</label>
                                            <input type="number" class="form-control" id="ano" name="ano" maxlength="4" placeholder="2055" require value="<?php echo isset($cart['ano']) ? $cart['ano'] : "" ?>">
                                        </div>
                                        <div class="form-group col">
                                            <label for="Código de segurança">Código de segurança</label>
                                            <input type="number" class="form-control" id="cod" name="cod" maxlength="4" placeholder="123" require value="<?php echo isset($cart['cod']) ? $cart['cod'] : "" ?>">
                                        </div>
                                    </div>

                                    <input type="hidden" name="funcao" value="<?php echo isset($cart['usuarios_cartao_funcao_id']) ? $cart['usuarios_cartao_funcao_id'] : 1 ?>">

                                    <button type="button" class="btn btn-primary" onclick="stepper.previous()">Voltar</button>
                                    <button class="btn btn-primary" id="btnDebito">Continuar</button>
                                </form>

                            </div>

                            <div id="pay1" class="hidden-pay">

                                <h5>Pagar com cartão de crédito
                                    <hr>
                                </h5>

                                <form id="formDataPayCredito" method="post">

                                    <div class="form-row">
                                        <div class="form-group col-8">
                                            <label for="Titular">Titular</label>
                                            <input type="text" class="form-control" id="titular" name="titular" placeholder="Nome impresso no cartão" require value="<?php echo isset($cart['titular']) ? $cart['titular'] : "" ?>">
                                        </div>
                                        <div class="form-group col">
                                            <label for="CPF">CPF</label>
                                            <input type="number" class="form-control" id="cpf" name="cpf" placeholder="CPF" require value="<?php echo isset($cart['cpf']) ? $cart['cpf'] : "" ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="Número do cartão">E-mail do titular</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" require value="<?php echo isset($cart['emailTitular']) ? $cart['emailTitular'] : "" ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="Número do cartão">Número do cartão</label>
                                        <input type="number" class="form-control" id="ncartao" name="ncartao" placeholder="Impresso no cartão" require value="<?php echo isset($cart['ncartao']) ? $cart['ncartao'] : "" ?>">
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="Mês">Mês</label>
                                            <input type="number" class="form-control" id="mes" name="mes" maxlength="2" placeholder="02" require value="<?php echo isset($cart['mes']) ? $cart['mes'] : "" ?>">
                                        </div>
                                        <div class="form-group col">
                                            <label for="Ano">Ano</label>
                                            <input type="number" class="form-control" id="ano" name="ano" maxlength="4" placeholder="2055" require value="<?php echo isset($cart['ano']) ? $cart['ano'] : "" ?>">
                                        </div>
                                        <div class="form-group col">
                                            <label for="Código de segurança">Código de segurança</label>
                                            <input type="number" class="form-control" id="cod" name="cod" maxlength="4" placeholder="123" require value="<?php echo isset($cart['cod']) ? $cart['cod'] : "" ?>">
                                        </div>
                                    </div>

                                    <input type="hidden" name="funcao" value="<?php echo isset($cart['usuarios_cartao_funcao_id']) ? $cart['usuarios_cartao_funcao_id'] : 2 ?>">

                                    <button type="button" class="btn btn-primary" onclick="stepper.previous()">Voltar</button>
                                    <button type="submit" class="btn btn-primary" id="btnCredito">Continuar</button>
                                </form>

                            </div>

                            <div id="pay3" class="hidden-pay">

                                <h5>Pagar com Pix
                                    <hr>
                                </h5>

                            </div>

                            <div id="pay4" class="hidden-pay">

                                <h5>Pagar com Boleto
                                    <hr>
                                </h5>

                            </div>


                        </div>
                        <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">

                            <form id="formDataPayEndereco" method="post">

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

                                <button type="button" class="btn btn-primary" onclick="stepper.previous()">Voltar</button>
                                <button type="submit" class="btn btn-primary" id="btnEndereco">Continuar</button>

                            </form>
                        </div>

                        <div id="confirmacao-part" class="content" role="tabpanel" aria-labelledby="confirmacao-part-trigger">
                            <h5>Resumo de pagamento</h5>

                            <div class="row">

                                <div class="col">
                                    <dl>
                                        <dt>Nome:</dt>
                                        <dd id="nomeResumo"></dd>

                                        <dt>Plano:</dt>
                                        <dd id="planoResumo"></dd>

                                        <dt>Valor:</dt>
                                        <dd id="valorResumo"></dd>

                                        <dt>Total:</dt>
                                        <dd id="totalResumo"></dd>
                                    </dl>
                                </div>

                                <div class="col">
                                    <dl>

                                        <dt>Titular do cartão:</dt>
                                        <dd id="titularResumo"></dd>

                                        <dt>Cartão:</dt>
                                        <dd id="numberResumo"></dd>

                                        <dt>Validade:</dt>
                                        <dd id="valResumo"></dd>

                                        <dt>Código de segurança:</dt>
                                        <dd id="cvvResumo"></dd>
                                    </dl>
                                </div>

                            </div>

                            <button type="button" class="btn btn-primary" onclick="stepper.previous()">Voltar</button>
                            <button type="button" class="btn btn-success" id="btnPagarAgora">Pagar agora</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->