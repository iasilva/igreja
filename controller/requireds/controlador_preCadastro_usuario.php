<?php
/*
 * Esse arquivo possui o codigo que é requerido pelo controlador ajax, caso a solicitação seja para um pré cadastro de usuário
 */
$email = $_POST['email'];

$usarioACadastrar = new usuario();
$usuarioLogado = new usuario();
$idUsuarioLogado = 1; /* Deve pegar no cookie */
$idIgrejaUsuarioLogado = 1; /* Deve pegar no cookie */
$emailUsuarioLogado = $usuarioLogado->getEmailUsuarioById($idUsuarioLogado);


/**
 * Verifica se usuario que está logado tem permissão para cadastrar novos usuários
 */
if ($usuarioLogado->isTesoureiro($idUsuarioLogado)) {
    /*
     * Caso tenha prossegue e verifica, se o o email novo já não está cadastrado com algum usuário
     */
    if ($usarioACadastrar->isUsuario($email)) {
        ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title text-info" id="myModalLabel"><strong>Atenção!</strong></h4>
        </div>
        <div class="modal-body">

            <div class="alert alert-info"><?php echo $usarioACadastrar->getMensagem() ?></div>
            <p>Pelas regras atuais, um usuário não pode estar vinculado a mais de uma igreja ao mesmo tempo.</p>
            <p>Caso, ele não esteja mais vinculado a igreja anterior, solicite que ele nos comunique enviando um email para <strong>usuario@casadosirmaos.com.br</strong>.</p>
            <p>Porém, é importante que o email seja enviado do email <strong><?php echo $email ?></strong>.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>                
        </div>

        <?php
    } else {
        /*
         * Caso são seja um usuário, verifica-se ele não é um pré usuário cadastrado 
         */
        if ($usarioACadastrar->isPreUsuario($email)) {/* Se sim receberá opções diferentes */         
            if ($usarioACadastrar->getIdIgrejaUsuario() == $idIgrejaUsuarioLogado) {
 /*************************************************************************************************************************************************************
 * ************************************* TODO ESSE CODIGO SERA EXECUTADO SE O PRE CADASTRO FOR DA MESMA IGREJA ATUAL******************************************
 ************************************************************************************************************************************************************/   
                ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirme!</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning"><strong>Atenção!</strong> esse email já consta em nossos bancos de dados.</div>
                    <div class="alert alert-danger">Porém o usuário ainda não confirmou o cadastro.</div>
                    <div class="alert alert-info">veja essas dicas e oriente o usuário corretamente.</div>
                    <ul class="list-group">
                        <li class="list-group-item">Você pode reenviar o link de confirmação para o email do usuário.</li>
                        <li class="list-group-item">Ou clicar em cancelar e aguardar que o usuário confirme o cadastro anterior.</li>
                        <li class="list-group-item"><span class="text-info"><strong>Email: </strong></span><?php echo $email ?></li>
                        <input type="hidden" value="<?php echo $email ?>" id="email-reenviar-link-confirmacao-usuario">
                    </ul>
                    <p>Antes de qualquer procedimento, confirme o email acima e verifique se é este o email que deseja cadastrar.</p>
                    <p>Caso o email esteja correto, reenvie o link e oriente o usuário para que verifique sua caixa de entrada, no email <?php echo $email ?>, e caso não tenha recebido a mensagem de verificação, informe 
                        que essa mensagem pode estar na lixeira ou caixa de spam. Nesse caso, ele deverá marcar esse email como um email confiável.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="button-reenviar-link-confirmacao-usuario">Reenviar confirmação</button>
                </div>

                <script type="text/javascript">
                    $("#button-reenviar-link-confirmacao-usuario").click(function() {
                       email = $("#email-reenviar-link-confirmacao-usuario").val();

                        $("#modal-reenvio-hasch-usuario").modal("show");
                        $("#modal-reenvio-hasch-usuario-conteudo").html("Reenviando confirmação...");
                        $.ajax({
                            type: "POST",
                            url: "controller/controlador_ajax.php?acao=reeviarLinkConfirmacao",
                            data: {email: email}
                        })
                                .done(function(msg) {
                                    $("#modal-reenvio-hasch-usuario-conteudo").html(msg);
                                });
                    });
                </script>    


                <?php } else {
/*************************************************************************************************************************************************************
 * ************************************* CASO SE TRATE DE PRÉ USUARIO DE OUTRA IGREJA  SEGUIRA PARA CODIGO ABAIXO ********************************************
 ************************************************************************************************************************************************************/                       
                ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-danger" id="myModalLabel"><strong>Atenção!</strong></h4>
                </div>
                <div class="modal-body">

                    <div class="alert alert-danger"><?php echo $usarioACadastrar->getMensagem() ?></div>
                    <p>Pelas regras atuais, um usuário não pode estar vinculado a mais de uma igreja ao mesmo tempo.</p>
                    <p>Caso, ele não esteja mais vinculado a igreja anterior, solicite que ele nos comunique enviando um email para <strong>usuario@casadosirmaos.com.br</strong>.</p>
                    <p>Porém, é importante que o email seja enviado do email <strong><?php echo $email ?></strong>.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>                
                </div>

                <?php
            }
//            
        } else {/* Se ainda não, prossegue cadastramento */
            if($usarioACadastrar->preCadastro($email, $idIgrejaUsuarioLogado, date('Y') . '-' . date('m') . '-' . date('d'), $idUsuarioLogado/* Deve pegar informação do usuário logado */)){
                /*se o pré cadastro funcionar*/?>
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-success" id="myModalLabel"><span class="glyphicon glyphicon-thumbs-up"></span> <strong>SUCESSO!</strong></h4>
                </div>
                <div class="modal-body">

                    <div class="alert alert-danger"><?php echo $usarioACadastrar->getMensagem() ?></div>
                    <p>O email <strong><?php echo $email ?></strong> foi cadastrado com sucesso.</p>
                    <p>oriente o usuário para que verifique sua caixa de entrada, no email <?php echo $email ?>, e caso não tenha recebido a mensagem de verificação, informe 
                        que essa mensagem pode estar na lixeira ou caixa de spam. Nesse caso, ele deverá marcar esse email como um email confiável.</p>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Sair</button>                
                </div>
                
                
                
                <?php                
                
            }
        }
    }
} else {
    ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-danger" id="myModalLabel"><strong>Atenção!</strong></h4>
    </div>
    <div class="modal-body">

        <div class="alert alert-danger">Usuário <strong>sem permissão</strong> para cadastrar novos usuários.</div>
        <p>Se você deveria ter permissão para efetuar essa ação, entre em contato com o suporte!</p>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>     
        <a href="./suporte/"<button type="button" class="btn btn-danger">Contatar o suporte</button></a>
    </div>
    <?php
}
?>
    
