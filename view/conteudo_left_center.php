<?php
/*Variável a - de ação, ou seja o tipo de movimentação que se pretende*/
/*   O Valor da variável passada é um hasch md5 de casaDosIrmaos + a função                  */
@$conteudoMaster=$_GET['a']
?>
                <div class="col-lg-9" id="content-center">                    
                    <?php     
                        switch ($conteudoMaster) {
                            case "f1583eb976c21e92c6db1a1764df1cfc":/* hasch de RegistrarEntrada */
                                require_once 'forms/reg_entrada_financeira.php';
                            break;
                        
                            case "9c4446f7bd31b9fcea0e78f7f1a702e8":/* hasch de RegistrarSaida */
                                require_once 'forms/reg_saida_financeira.php';
                            break;
                        
                            case "a9294f33f8f0a6b2aab58c326a771e8e":/*hash de controlarUsuários*/
                                /*******************************************************************************************
                                 *    Todas solicitações relacionadas a edição de usuários serão enviadas com esse hasch   *
                                 *    Uma vez aqui será chamado o controller de edição de usuário para que ele             *
                                 *    Decida com base em outras variaveis passadas, que serviço de usuário está            * 
                                 *    Sendo solicitado.                                                                    *
                                 *******************************************************************************************/
                                require_once './controller/controlar_edicao_usuarios.php';
                            break;    
                            default:
                                require_once 'formulario_publicacao_geral.php';
                                 require_once 'publicacoes_gerais.php';
                                break;
                        }
                        
                    ?>                                 

                </div><!-- FIM content-center -->