<?php

/* * *****************************************************************
 * Essa página verificará que tipo de ação esta sendo solicitada   *
 * Com relação a edição de usuário e solicitará a página correta   *
 * Utilizará a variável GET "eu" de editar usuário                 *
 * **************************************************************** */
@$eu = $_GET['eu'];
switch ($eu) {
    case "65889c0730cad3b5d0940dbcd668e1d8":/* hasch de cadastrarUsuario */
        require_once './view/forms/cadastrar_usuario.php';
        break;
    case "2cf645348f09e3d712780081c2576169":/*hasch de reenviarLinkConfirmação*/
        require_once 'requireds/reenvio_link_confirmacao_novo_usuario.php';    
        break;
    default :
        echo "<script language= \"JavaScript\">
            alert('Houve algum erro de redirecionamento. Utilize o menu para se direcionar. Em caso de persistir o erro, entre em contato com o suporte.');
             document.location = './';
              </script>";
        break;
}
?>