<?php
session_start();
$seguranca = true;
include_once("../../../../config/seguranca.php");
include_once("../../../../config/config.php");
include_once("../../../../config/conexao.php");
include_once("../../../../lib/lib_funcoes.php");

$dataInicio = filter_input(INPUT_GET, 'dtinicio', FILTER_DEFAULT);
$dataFinal  = filter_input(INPUT_GET, 'dtfim', FILTER_DEFAULT);
$status     = filter_input(INPUT_GET, 'status', FILTER_DEFAULT);

if ((empty($dataInicio)) and (empty($dataFinal)) and (empty($status))) {
    die("Preencha todos os campos para continuar com a pesquisa");
}

$query = "SELECT 
        id,
        cidade,
        ass_medica,
        sexo,
        faixaEtaria,
        qtd,
        nomeEmpresa,
        cnpj,
        email,
        nomeContato,
        telefone,
        DATE_FORMAT(created, '%d/%m/%Y às %H:%i:%s') AS criado
        FROM site_simulacao WHERE date(created) >= '$dataInicio' AND date(created) <= '$dataFinal' AND status = '$status'
    ";
$result = $conn->query($query);
$linha = 1;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Relatório para capturar simulações">
    <meta name="author" content="Company cloud">
    <meta name="generator" content="Bootstrap 4.6">
    <title>Relatório · Simulações</title>
    <style>

        .starter-template {
            text-align: center;
        }

        @media print {
            @page {
                size: landscape;
            }
        }
    </style>


    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <main role="main" class="container">

        <div class="starter-template">
            <h1>Simulações</h1>
            <p class="lead">Periodo: <?php echo date('d/m/Y', strtotime($dataInicio)) . " à " . date('d/m/Y', strtotime($dataFinal)) ?> </p>
            <p>Status: <?php echo $status ?></p>
        </div>

        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">CNPJ</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>

                <?php while ($row = $result->fetch_assoc()) { ?>

                    <tr>
                        <th scope="row" rowspan="2"><?php echo $linha++; ?></th>
                        <td><?php echo $row['nomeEmpresa']; ?></td>
                        <td><?php echo $row['cnpj']; ?> </td>
                        <td><?php echo $row['email']; ?> </td>
                        <td><?php echo $row['criado']; ?> </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <th scope="row">Nome:</th>
                                        <td><?php echo $row['nomeContato']; ?></td>
                                        <th>Telefone:</th>
                                        <td colspan="5"><?php echo $row['telefone']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Cidade:</th>
                                        <td><?php echo $row['cidade']; ?></td>
                                        <th>Possui assistência médica?</th>
                                        <td colspan="3"><?php echo $row['ass_medica']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sexo:</th>
                                        <td><?php echo $row['sexo']; ?></td>
                                        <th>Faixa Etária:</th>
                                        <td><?php echo $row['faixaEtaria']; ?></td>
                                        <th>Quantidade</th>
                                        <td><?php echo $row['qtd']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                <?php } ?>

            </tbody>
        </table>

    </main><!-- /.container -->


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://getbootstrap.com/docs/4.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>