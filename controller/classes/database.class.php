<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of database
 *
 * @author Ivan Alves
 */
class database {
    protected $dsn = 'mysql:host=localhost;dbname=casa_dos_irmaos';
    protected $username = "root";
    protected $passwd = "@Estevao2210";
    /*Para acesso online*/
//    protected $dsn = 'mysql:host=186.202.152.42;dbname=iasilva_casa_dos_irmaos';
//    protected $username = "iasil_igrejaCO";
//    protected $passwd = "@Estevao2210iae";
    
    public static $db;

        //put your code here
    public function instance(){
        if(!self::$db){
            self::$db=  $this->connect();
        }
        return self::$db;
    }
    private function connect(){
        try {
            $db= new PDO($this->dsn,  $this->username,  $this->passwd );
            $db->setAttribute(PDO::ATTR_ERRMODE, 'ERRMODE_EXCEPTION');
            return $db;
        } catch (PDOException $exc) {
            echo "Conexão falhou: " . $exc->getMessage();
        }
            
        
    }
}

?>
