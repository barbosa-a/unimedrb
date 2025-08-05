<?php

if (!isset($seguranca)) {
    exit;
}
$sendCadastrarModulo = filter_input(INPUT_POST, 'sendCadastrarModulo', FILTER_DEFAULT);

if ($sendCadastrarModulo) {
    $nvl_atual = filter_input(INPUT_POST, 'nvl_atual', FILTER_DEFAULT);
    $modulo = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $ordem = 0;
    foreach ($modulo['modulo'] as $key => $menu_mod) {              
        //consultar modulo
        $cons_mod = "SELECT id_mod FROM modulos where id_mod = '$menu_mod' ";
        $query_cons_mod = mysqli_query($conn, $cons_mod);
        while ($row_mod = mysqli_fetch_array($query_cons_mod)){
            //echo "MOD: ".$row_mod['nome_mod']."<br>";
            //liberar permissoes conforme o modulo selecionado
            $cons_pg = "SELECT id_pg, menu_lateral FROM paginas WHERE modulo_id = '".$row_mod['id_mod']."' ORDER BY id_pg ASC ";
            $query_cons_pg = mysqli_query($conn, $cons_pg);
            while ($row_cons_pg = mysqli_fetch_array($query_cons_pg)){
                //echo "Endereço: ".$row_cons_pg['endereco_pg']."<br>";
                if($row_cons_pg['menu_lateral'] == 1){
                    $permissao = 1;
                } else {
                    $permissao = 2;
                }
                $ordem++;
                //Salva no BD
                $cad_nvl_perm_pg = "INSERT INTO niveis_acessos_paginas 
                    (niveis_acesso_id, pagina_id, permissao, menu, ordem, criado_nvl_pg)
                        VALUES 
                    ('$nvl_atual', '".$row_cons_pg['id_pg']."', '$permissao', '$permissao', '$ordem', NOW()) ";
                $query_cad_nvl_perm_pg = mysqli_query($conn, $cad_nvl_perm_pg);                    
             }
        }
    }
    //mensagem
    if (mysqli_affected_rows($conn) != 0) {
        $_SESSION['msg'] = '
            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Sucesso!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center">Perfil atualizado com sucesso.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/listar/list_permissao?nvl=$nvl_atual";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }else{
        $_SESSION['msg'] = '
            <div class="modal fade" id="procmsg" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Erro!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center">Erro ao atualizar perfil, tente novamente.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
        $url_destino = pg . "/pages/modulo/controle_de_acesso/listar/list_permissao?nvl=$nvl_atual";
        echo '<script> location.replace("' . $url_destino . '"); </script>';
    }
} else {
    $url_destino = pg . "/pages/modulo/404/404";
    echo '<script> location.replace("' . $url_destino . '"); </script>';
}
