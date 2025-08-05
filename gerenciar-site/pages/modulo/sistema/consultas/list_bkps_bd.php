<?php
include_once("../../../../lib/ModSistema.php");
$dir = "../backup/BD/"; // Substitua pelo caminho do diretório que você deseja listar
$linhasDir = 1;

//Pegar o diretorio atual
//echo getcwd();

if (is_dir($dir)) {
    $files = scandir($dir);

    // Remova as entradas "." e ".." da lista, que se referem ao diretório atual e ao diretório pai
    $files = array_diff($files, array('.', '..'));


    foreach ($files as $file) { ?>
        <tr>
            <th scope="row"><?php echo $linhasDir++; ?></th>
            <td><?php echo $file; ?></td>
            <td><?php echo formatFileSize($dir . $file); ?></td>
            <td>
                <a href="<?php echo "sistema/BD/" . $dir . $file; ?>" download class="mr-2">
                    <i class="fa fa-download" aria-hidden="true"></i>
                </a>
                <a href="#" onclick="excluirBkpBD('<?php echo $file; ?>')">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    <?php } ?>
<?php } else { ?>
    <tr class="text-center">
        <td colspan="3">O diretório não existe.</td>
    </tr>
<?php } ?>