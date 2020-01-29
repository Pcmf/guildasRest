<?php

require_once 'db/DB.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Email
 *
 * @author pedro
 */
class Email {

    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM emails ORDER by dataenvio DESC");
    }

    public function getById($id) {
        return $this->db->query("SELECT * FROM emails WHERE id=:id ORDER by dataenvio DESC", [':id' => $id]);
    }

    public function sendEmail($to, $obj) {
        //chamar as funções para enviar email
        //TODO
        $erro = "Não implementado";
        //Registar na BD
        
        return $this->insert($obj, $erro);
      
    }

    private function insert($obj, $erro) {
        try {
            $this->db->queryInsert("INSERT INTO emails(assunto, guilda, corpoemail, erro) "
                    . " VALUES(:assunto, :guilda, :corpoemail, :erro)",
                    [':assunto' => $obj->assunto, ':guilda' => $obj->guilda, ':corpoemail' => $obj->corpoemail, ':erro' => $erro]);
            return $this->db->lastInsertId();
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
