<?php
    if(!isset($seguranca)){
        exit;
    }
    // Modulo Controle de acesso
    //Botões do menu pesquisar
    $botao_cad_user     = carregar_botao('pages/modulo/controle_de_acesso/cadastrar/cad_usuario', $conn);
    $botao_proc_cad_user     = carregar_botao('pages/modulo/controle_de_acesso/cadastrar/processa/proc_cad_usuario', $conn);
    $botao_edit_user    = carregar_botao('pages/modulo/controle_de_acesso/editar/edit_usuario', $conn);
    $botao_apagar_user  = carregar_botao('pages/modulo/controle_de_acesso/apagar/proc_del_usuario', $conn);

    //Botões do menu cargo
    $botao_cad_cargo    = carregar_botao('pages/modulo/controle_de_acesso/cadastrar/cad_cargo', $conn);
    $botao_edit_cargo   = carregar_botao('pages/modulo/controle_de_acesso/editar/edit_cargo', $conn);
    $botao_apagar_cargo = carregar_botao('pages/modulo/controle_de_acesso/apagar/proc_del_cargo', $conn);
    
    //Botões do menu grupo
    $botao_cad_grupo    = carregar_botao('pages/modulo/controle_de_acesso/cadastrar/cad_grupo', $conn);
    $botao_edit_grupo   = carregar_botao('pages/modulo/controle_de_acesso/editar/edit_grupo', $conn);
    $botao_apagar_grupo = carregar_botao('pages/modulo/controle_de_acesso/apagar/proc_del_grupo', $conn);
    
    //Botões do menu unidade
    $botao_cad_unidade      = carregar_botao('pages/modulo/controle_de_acesso/cadastrar/cad_unidade', $conn);
    $botao_edit_unidade     = carregar_botao('pages/modulo/controle_de_acesso/editar/edit_unidade', $conn);
    $botao_apagar_unidade   = carregar_botao('pages/modulo/controle_de_acesso/apagar/proc_del_unidade', $conn);
    
    //Botões do menu perfil
    $botao_cad_perfil       = carregar_botao('pages/modulo/controle_de_acesso/cadastrar/cad_permissao', $conn);
    $botao_edit_perfil      = carregar_botao('pages/modulo/controle_de_acesso/editar/edit_perfil', $conn);
    $botao_apagar_perfil    = carregar_botao('pages/modulo/controle_de_acesso/apagar/proc_del_perfil', $conn);    
    $botao_perm_perfil      = carregar_botao('pages/modulo/controle_de_acesso/listar/list_permissao', $conn);
    
    //Botão historico de atualização
    $botao_hist_atualizacao = carregar_botao('pages/modulo/controle_de_acesso/listar/list_hist_atualizacao', $conn);
    
    //Botões menu departamento
    $botao_cad_departamento     = carregar_botao('pages/modulo/controle_de_acesso/cadastrar/cad_departamento', $conn);
    $botao_edit_departamento    = carregar_botao('pages/modulo/controle_de_acesso/editar/edit_departamento', $conn);
    $botao_apagar_departamento  = carregar_botao('pages/modulo/controle_de_acesso/apagar/proc_del_departamento', $conn);
    // Modulo Controle de acesso

    // Modulo Sistema 
    $botao_edit_mod     = carregar_botao('pages/modulo/sistema/editar/processa/proc_edit_modulo', $conn);
    $botao_del_mod      = carregar_botao('pages/modulo/sistema/apagar/processa/proc_del_modulo', $conn);
    $botao_edit_fluxo   = carregar_botao('pages/modulo/sistema/editar/processa/proc_edit_fluxo', $conn);
    // Modulo Sistema    

    //Modulo Perfil
    $btn_altera_usuario_perfil  = carregar_botao('pages/modulo/meu_perfil/processa/proc_altera_usuario', $conn);
    $btn_altera_senha_perfil    = carregar_botao('pages/modulo/meu_perfil/processa/proc_altera_senha', $conn);
    //Modulo Perfil

    //Modulo cadastro
    $btn_cad_titular  = carregar_botao('pages/modulo/cadastro/cadastrar/cad_titular', $conn);
    $btn_edit_beneficiario  = carregar_botao('pages/modulo/cadastro/editar/edit_beneficiario', $conn);
    $btn_add_dependente    = carregar_botao('pages/modulo/cadastro/cadastrar/cad_dependente', $conn);
    $btn_emitir_carteira   = carregar_botao('pages/modulo/cadastro/carteira/emitir', $conn);
    //Modulo cadastro

    //Modulo base de conhecimento
    $btn_cad_artigo  = carregar_botao('pages/modulo/base-de-conhecimento/cadastrar/cad_artigo', $conn);

    //Modulo Controle de acesso
    $btn_del_nvl   = carregar_botao('pages/modulo/controle_de_acesso/apagar/proc_del_mod_permissao', $conn);
    
?>

