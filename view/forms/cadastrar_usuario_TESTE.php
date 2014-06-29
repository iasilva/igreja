<section class="container-fluid" id="pag-cadatro-usuario">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="text-muted">Cadastrar novo usuário</h3>
        </div>
        <!--SESSÃO DE NOTIFICAÇÕES DA PÁGINA- AVISOS E RETORNOS -->
        <div class="row">
            <div class="col-sm-12" id="avisos-cadastro-usuario">

            </div>
        </div>

        <!--SESSÃO DE NOTIFICAÇÕES DA PÁGINA- AVISOS E RETORNOS -->
        <div class="panel-body"> 
            <form method="POST" action="controller/controlador_ajax.php?acao=emailCadastroInicial" id="form-cadastro-usuario-inicial"><!------------------------------------------------------------------------------>
                <div class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="emailNovoUsuario" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-6">
                            <div id="contornoEmail" class="input-group"> 

                                <span class="input-group-addon">@</span>
                                <input type="email" class="form-control " name="email" id="emailNovoUsuario" title="Insira o email da pessoa que deseja cadastrar" placeholder="Email">
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="msgEmail"></div>
                        </div>



                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit"  class="btn btn-default" value="Cadastrar"> <!--id="btn-inicio-novo-usuario"-->
                        </div>
                    </div>
                </div>
            </form><!------------------------------------------------------------------------------>

        </div>
        <div class="panel-footer">
            <p class="text-muted"> Será enviado um link para o email cadastrado com as instruções complementares.</p>

            <p class="text-info">Comunique o usuário sobre o cadastro e oriente pra que caso ele não visualize o email na caixa de entrada, ele deve procurar na
                caixa de <span class="label label-warning">SPAN</span> ou <span class="label label-warning">Lixo Eletrônico</span>.
            </p>

        </div>
    </div>

</section>

