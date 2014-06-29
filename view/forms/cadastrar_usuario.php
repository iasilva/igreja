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
            <div class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="emailNovoUsuario" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-6">
                        <div id="contornoEmail" class="input-group"> 
                            
                            <span class="input-group-addon">@</span>
                            <input type="email" class="form-control " id="emailNovoUsuario" title="Insira o email da pessoa que deseja cadastrar" placeholder="Email">
                        </div>
                    
                    </div>
                    <div class="col-sm-4">
                        <div class="msgEmail"></div>
                    </div>



                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button id="btn-inicio-novo-usuario" data-loading-text="Carregando..." class="btn btn-default">Cadastrar</button>
                    </div>
                </div>
            </div>


        </div>
        
    </div>

</section>

<div class="modal fade" id="modal-reenvio-hasch-usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content"  id="modal-reenvio-hasch-usuario-conteudo">
     <!--Receberá conteudo via javascript-->
    </div>
  </div>
</div>