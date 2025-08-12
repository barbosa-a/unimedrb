<?php

$seguranca = true;

$linha = 1;

//echo $dir;
include_once '../../../../config/config.php';
include_once '../../../../config/conexao.php';

$cons = "SELECT 
			id_pg, 
            icon,
            nome_pg,
            pagina_id
		FROM paginas
		WHERE menu_lateral = 1 AND (pagina_id IS NULL OR pagina_id = 0)
		ORDER BY ordem_menu ASC
	";
$query_cons = mysqli_query($conn, $cons);
if (($query_cons) and ($query_cons->num_rows > 0)) {
    while ($serv = mysqli_fetch_array($query_cons)) { ?>
        <li class="sortable-item-pg" data-id="<?php echo $serv['id_pg'] ?>">
            
            <div class="d-flex align-items-center">

                <span class="badge badge-secondary"><?php echo $linha++; ?></span>
                <!-- drag handle -->
                <span class="handle ui-sortable-handle">
                    <i class="fa fa-ellipsis-v"></i>
                    <i class="fa fa-ellipsis-v"></i>
                </span>
                <!-- Emphasis label -->
                <small class="badge badge-primary"><i class="<?php echo $serv['icon'] ?>"></i> </small>

                <!-- todo text -->
                <span class="text">
                    <span class="text-primary"><?php echo $serv['nome_pg'] ?></span>
                </span>

            </div>

        </li>
        <?php 
            $consSub = "SELECT 
                    id_pg, 
                    icon,
                    nome_pg
                FROM paginas
                WHERE menu_lateral = 1 AND pagina_id = '{$serv['id_pg'] }'
                ORDER BY ordem_menu ASC
            ";
            $query_consSub = mysqli_query($conn, $consSub);
            while ($servSub = mysqli_fetch_array($query_consSub)) { ?>

            <li class="sortable-item-pg" data-id="<?php echo $servSub['id_pg'] ?>">
            
                <div class="d-flex align-items-center" style="margin-left: 20px">

                    <span class="badge badge-secondary"><?php echo $linha++; ?></span>
                    <!-- drag handle -->
                    <span class="handle ui-sortable-handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                    </span>

                    <!-- todo text -->
                    <span class="text">
                        <span class="text-primary"><?php echo $servSub['nome_pg'] ?></span>
                    </span>

                </div>

            </li>

        <?php } ?>
    <?php } ?>
<?php } else { ?>
    <li>Nenhum registro encontrado</li>
<?php } ?>