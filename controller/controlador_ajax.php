<?php

require_once 'classes/database.class.php';
require_once 'classes/correio.class.php';
require_once 'classes/usuario.class.php';
$acao = $_GET['acao'];
switch ($acao) {
    case "emailCadastroInicial":        
        require 'requireds/controlador_preCadastro_usuario.php';
        break;
    case "reeviarLinkConfirmacao":
        require_once 'requireds/reenvio_link_confirmacao_novo_usuario.php';    
        break;
    default:
        echo 'Sei não o que deu!';
        break;
}



//$msg=new correio();
//$msg->mensagemCadastroInicial($email, 'http://casadosirmaos.com.br/teste');
//$msg->emailTeste();



    






/************************************************
 *  Antes de qualquer cadastro,                 *
 *  Deve verificar, qual usuário está logado    *
 *  Verificar se ele tem permissão              *
 *  Verificar a que igreja ele tem permissão    *
 ******************************************** **/

/*
 * Outra verificação importante é se aquele email não foi cadastrado
 * Se tiver cadastrado, informar negativa
 * Mas caso ainda não esteja confirmado pelo usuário deverá ser reenviado o link de confirmação, 
 * e nesse caso emitir orientações mais detalhadas ao Cadastrante
 * 
 */
