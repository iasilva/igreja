$(document).ready(function() {

//  CADASTRO DE USUARIO---------------------------------------------
    /*******************************************************
     * A primeira função do cadastro de novos usuários     *
     * É a verificação no ato do clique no botão CADASTRAR *
     * Nesse caso o sistema valida o campo email, chamando *
     * a função validaEmail() e caso o email seja válido e-* 
     * le remete o email ao php para passos seguintes.     *
     * -Caso o email não seja válido ele emite um aviso    * 
     *******************************************************/
    $("#btn-inicio-novo-usuario").click(function() {  
        
        email = $("#emailNovoUsuario").val();
        validacao=validaEmail(email);         
       
        if (validacao==true) {//vERIFICA SE O EMAIL É VALIDO
        $("#modal-reenvio-hasch-usuario").modal("show");
        $("#modal-reenvio-hasch-usuario-conteudo").html("carregando...");
            $.ajax({
                type: "POST",
                url: "controller/controlador_ajax.php?acao=emailCadastroInicial",
                data: {email: email}
            })
                    .done(function(msg) {                       
//                            $("#avisos-cadastro-usuario").html(msg);
//                            $("#avisos-cadastro-usuario").show(900);
                              $("#modal-reenvio-hasch-usuario-conteudo").html(msg);
                              
                        
                    });


        } else {
            $("#emailNovoUsuario").focus();
            $("#emailNovoUsuario").val("");
            $("#contornoEmail").addClass("has-error");
            $(".msgEmail").html("<span class=\"label label-danger\">Email (" + email + ") inválido</span>");

        }

    });
    /***************************************************************************
     * função que reenvia o email de confirmação do usuário já pré cadastrado  *
     * Anteriormente , consta no arquivo controlador_preCadastro_usuario.php   *
     **************************************************************************/
   
    
    
    
    /*********************************************************
     * Essa função não envia o email, apenas já verifica     *
     * se o email é válido e caso não seja, informa o usuário*
     * *******************************************************/
    $("#emailNovoUsuario").change(function() {

        email = $("#emailNovoUsuario").val();
        if (!validaEmail(email)) {//vERIFICA SE O EMAIL É VALIDO
            $("#contornoEmail").addClass("has-error");
            $(".msgEmail").html("<span class=\"label label-danger\">Email inválido</span>");

        }
    });
    /***********************************************************
     * Essa função apenas retorna o input ao seu estado incial *
     * a cada vez que recebe o focu.                           *
     ***********************************************************/
    $("#emailNovoUsuario").focus(function() {
        $("#contornoEmail").removeClass("has-error");
        $(".msgEmail").html("");

    });




});
function verificacoesEmailNovoUsuario() {






}


/**********************************************************************
 * @function validaEmail                                              *
 * @param {String} email                                              *
 * @returns {Boolean}                                                 *
 * Função padrão de verificação se email é válido                     *
 **********************************************************************/

function validaEmail(email) {
    if (email !="")
    {
        var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        if (filtro.test(email))
        {
            return true;
        } else {

            return false;
        }
    } else {
       
       $("#modal-reenvio-hasch-usuario").modal("show");
        $("#modal-reenvio-hasch-usuario-conteudo").html("<div class=\"modal-body\"><div class=\"alert alert-danger\">Digite um email válido.</div></div");
        return false;
    }

}

 