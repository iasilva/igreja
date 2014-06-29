<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of correio
 *
 * @author Ivan
 */
class correio {

    public $db;

    public function __construct() {
        $bd = new database();
        $this->db = $bd->instance();
    }

    public function mensagemCadastroInicial($email, $link_hasch) {
        $email_remetente = "nao_responda@casadosirmaos.com.br";
        $assunto = "Confirmação de cadastro no portal Casa Dos Irmãos";
        $conteudo = "<h2>Confirme o seu cadastro no site da sua igreja</h2>";
        $conteudo.="<p>O representante da sua igreja cadastrou você no site, confirme através do link abaixo e tenha acesso a todas as informações de sua igreja.</p>";
        $conteudo.="<p><a href=\"$link_hasch\">$link_hasch</a></p>";
        $conteudo.="<p>Caso não consiga clicar no link por estar bloqueado, copie o código e cole na barra de endereços do seu navegador.</p>";

        $headers = "MIME-Version: 1.1\n";
        $headers .= "Content-type: text/html; charset=UTF-8\n";
         $headers .= "From: $email_remetente\n"; // remetente
        $headers .= "Return-Path: $email_remetente\n"; // return-path
        $headers .= "Reply-To: $email_remetente\n"; // Endereço (devidamente validado) que o seu usuário informou no contato
        $envio = mail($email, $assunto, $conteudo, $headers,"-f$email_remetente");

        if ($envio) {
            echo "Mensagem enviada com sucesso";
        } else {
            echo "A mensagem não pode ser enviada";
        }
    }

   
}
