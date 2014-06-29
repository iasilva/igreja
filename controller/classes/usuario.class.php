<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuario
 *
 * @author Ivan
 */
class usuario {

    public $db;

    /**
     * @var string  Recebe a situação do usuário. Confirmado, aguardando confirmação ou null
     */
    protected $situação;
    protected $idIgrejaDoUsuario;
    protected $tituloIgrejaUsuario;
    protected $mensagem;

    public function __construct() {
        $bd = new database();
        $this->db = $bd->instance();
    }

    /**
     * 
     * @param String $email
     * @param Integer $idIgreja
     * @param Date $dataCadastro
     * @param Integer $idCadastrante 
     */
    public function preCadastro($email, $idIgreja, $dataCadastro) {

        try {
            $hasch = $this->executePreCadastro($email, $idIgreja, $dataCadastro);
            $this->emailPreCadastro($email, $hasch);
            $this->mensagem = "Cadastro efetuado com sucesso estaremos aguardando a confirmação do email do usuário.";
            return TRUE;
        } catch (Exception $ex) {
            echo $exc->getTraceAsString();
            $this->erroInterno($exc->getMessage() . "  [Algo deu errado #Exception Usuario] ");
            return FALSE;
        }
    }

    /**
     * Verifica se determinado usuário é tesoureiro
     * @return True or false
     */
    public function isTesoureiro($idUsuario) {
        try {
            $sql = "SELECT tipos_usuario_cod_tipo FROM usuario WHERE id=:idUsuario";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                    array("idUsuario" => $idUsuario)
            );
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $tipoUsuarioAtual = $result['tipos_usuario_cod_tipo'];
            $tipoTesoureiro = $this->qualIdDoTipo("tesoureiro");
            /* Compara o tipo do usuário atual com o tesoureiro */
            if ($tipoTesoureiro === $tipoUsuarioAtual) {
                return TRUE;
            } else {
                $this->mensagem = "Usuário não é tesoureiro.";
                return FALSE;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->erroInterno($exc->getMessage() . "  [Justamente quando tentávamos consultar se o usuário era tesoureiro] ");
        }
    }

    public function getEmailUsuarioById($idUsuario) {
        try {
            $sql = "SELECT email FROM usuario WHERE id=:idUsuario";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                    array("idUsuario" => $idUsuario)
            );
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $qtdResult = $stmt->rowCount();
            if ($qtdResult > 0) {
                return $result['email'];
            } else {
                return NULL;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->erroInterno($exc->getMessage() . "  [Justamente quando tentávamos consultar se o usuário era tesoureiro] ");
        }
    }

    /**
     * Metodo que efetiva o cadastro do pré no Banco de dados
     * Deve ser chamada apenas pelo método preCadastro
     * @param String $email
     * @param Integer $idIgreja
     * @param Date $dataCadastro
     * @param Integer $idCadastrante 
     * @return String hasch de confirmação do cadastro
     */
    protected function executePreCadastro($email, $idIgreja, $dataCadastro) {
        try {
            /**
             * @var String Váriável que armazena o hash unico gerado para confirmação do usuário
             */
            $haschAtivacao = uniqid(time()) . "oacaroedasac";
            $sql = "INSERT INTO user_temp (email,igreja_id_igreja,data_cadastro,hasch) VALUES(:email,:id_igreja,:data_cadastro,:hasch)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                "email" => "$email",
                "id_igreja" => $idIgreja,
                "data_cadastro" => $dataCadastro,
                "hasch" => $haschAtivacao)
            );
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->erroInterno($exc->getMessage() . "  [Justamente quando tentávamos inserir o cadastro no banco de dados] ");
        }
        return $haschAtivacao;
    }

    /**
     * Verifica se é usuário cadastrado, não verifica o tipo
     * @param String $email email a ser pesquisado
     */
    public function isUsuario($email) {

        try {
            $sql = "SELECT email,igreja_id_igreja,titulo FROM usuario,igreja WHERE (usuario.email=:email) and (usuario.igreja_id_igreja=igreja.id_igreja)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array("email" => $email));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $qtdResult = $stmt->rowCount();
            if ($qtdResult > 0) {
                $this->idIgrejaDoUsuario=$result['igreja_id_igreja'];
                $this->mensagem = "usuario ja cadastrado na igreja " . $result['titulo'];
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $ex) {
            echo $exc->getTraceAsString();
            $this->erroInterno($exc->getMessage() . "  [Justamente quando tentávamos verificar se esse email era de de algum de nossos usuários] ");
        }
    }

    /**
     * Verifica se é um pré usuario
     * @param String $email Email a ser pesquisado
     */
    public function isPreUsuario($email) {
        try {
            $sql = "SELECT igreja_id_igreja,titulo FROM user_temp,igreja WHERE (user_temp.email=:email) and (user_temp.igreja_id_igreja=igreja.id_igreja)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array("email" => $email));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $qtdResult = $stmt->rowCount();
            if ($qtdResult > 0) {
                $this->idIgrejaDoUsuario=$result['igreja_id_igreja'];
                $this->tituloIgrejaUsuario=$result['titulo'];
                $this->mensagem = "usuario ja pré cadastrado na igreja " . $result['titulo'];
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $ex) {
            echo $exc->getTraceAsString();
            $this->erroInterno($exc->getMessage() . "  [Justamente quando tentávamos verificar se esse email era de de algum de nossos usuários] ");
        }
    }

    /**
     * 
     * @param integer $idUsuario, pesquisa a igreja do usuário,pelo id
     */
    protected function qualIgrejaUsuario($idUsuario) {
        
    }

    /**
     * 
     * @param String $emailUsuario, Pesquisa a qual igreja pré usuário está cadastrado
     */
    protected function qualIgrejaPreUsuario($emailUsuario) {
        
    }
    /**
     * 
     * @param String $email
     * Metodo Reenvia link de confirmação, para determinado email
     */
    public function reenviaHasch($email){
        $sql = ("SELECT hasch FROM user_temp where email =:email");
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array("email"=>$email));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $qtdResult = $stmt->rowCount();
            if(($qtdResult>0) and (!$this->isUsuario($email))){
                $hasch=$result['hasch'];
                $this->emailPreCadastro($email, $hasch);
                return TRUE;
            }  else {
                $this->mensagem="Pré cadastrado não encontrado, ou já foi confirmado pelo usuário"; 
                return FALSE;
            }
            
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->erroInterno($exc->getMessage() . "  [Justamente quando tentávamos consultar o id do tipo $descricao] ");
        }
        
    }

    private function enviaEmailConfirmacao($email, $nomeIgreja, $hasch) {
        
    }
    public function getIdIgrejaUsuario(){
        return $this->idIgrejaDoUsuario;
    }

    public function getMensagem() {
        return $this->mensagem;
    }

    public function qualIdDoTipo($descricao) {
        $query = ("SELECT tipo FROM tipos_usuario where descricao_tipo = '$descricao'");
        try {
            $stmt = $this->db->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['tipo'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->erroInterno($exc->getMessage() . "  [Justamente quando tentávamos consultar o id do tipo $descricao] ");
        }
    }

    private function emailPreCadastro($email, $hasch) {
        try {
            $link_hasch = "http://casadosirmaos.com.br/verify/fr.php?security=$hasch";
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
            if (mail($email, $assunto, $conteudo, $headers, "-f$email_remetente")) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            
            $this->erroInterno($exc->getMessage() . "  [Justamente quando tentávamos enviar um email de confirmação, mas você poderá refazer isso em breve! ");
        }
    }
    /**
     * 
     * @param String $email email do usuário
     * @param String $senha Senha do usuário
     * @return String  Retorna True ou False caso tenha ou não sucesso na tentativa de efetuar login
     */
    public function getHashSenha($email){
                   
            $sql = "select senha from usuario where email=:email";
           try {            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                    array("email" => $email)
            );
            /**
             * @var Integer Armazena a quantidade de combinações emcontradas entre email e senha
             */
             $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $qtdResult = $stmt->rowCount();
            
      
            /**
             * Verifica se o batimento usuário senha retornou ao menos uma combinação
             */
            if($qtdResult>0){                
                return $result['senha'];
                
            }  else {
                return FALSE;
            }
            
            
            
            
           }  catch (Exception $exc){     
               echo $exc->getTraceAsString();
           
            
            $this->erroInterno($exc->getMessage() . "  Isso aconteceu enquanto tentávamos consultar seu usuário e senha para registrar-te");
           }
    }
    public function getEmailByHash($hasch){
        $sql = ("SELECT email FROM user_temp where hasch =:hasch");
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array("hasch"=>$hasch));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $qtdResult = $stmt->rowCount();
            if($qtdResult>0){
                return $result['email'];               
            }  else {
                $this->mensagem="Pré cadastrado não encontrado em nossos bancos de dados"; 
                return FALSE;
            }
            
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->erroInterno($exc->getMessage() . "  [Justamente quando tentávamos consultar o id do tipo $descricao] ");
        }
        
        
        
        
        
        
    }

    
    private function erroInterno($mensagemExcessao) {

        echo "<p class=\"error\"> Ops! adentramos pela porta larga com o seguinte erro</p><p>" . $mensagemExcessao . "</p><p>Faremos uma oração e retornaremos ao caminho certo</p>";
    }

}
