<?php
$email = $_POST['email'];

$usuarioACadastrar = new usuario();
if ($usuarioACadastrar->reenviaHasch($email)) {
    
    ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-success" id="myModalLabel"><span class="glyphicon glyphicon-thumbs-up"></span> <strong>SUCESSO!</strong></h4>
    </div>
    <div class="modal-body">

        <p class="text-success"> <?php echo $usuarioACadastrar->getMensagem() ?></p>
        <p>O email <strong><?php echo $email ?></strong> foi cadastrado com sucesso.</p>
        <p>Oriente o usuário para que verifique sua caixa de entrada, no email <?php echo $email ?>, e caso não tenha recebido a mensagem de verificação, informe 
            que essa mensagem pode estar na lixeira ou caixa de spam. Nesse caso, ele deverá marcar esse email como um email confiável.</p>


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Sair</button>                
    </div>

    <?php
}
?>