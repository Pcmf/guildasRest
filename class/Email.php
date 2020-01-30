<?php

require_once 'db/DB.php';
require_once 'sendEmail.php';
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
        if($to == 99) {
            $list = $this->db->query("SELECT id, name, email, guilda FROM players WHERE ative=1 AND email<>'' ");
        } else {
           $list = $this->db->query("SELECT id, name, email, guilda FROM players WHERE ative=1 AND email IS NOT NULL AND guilda=:guilda ", [':guilda'=>$to]);
        }
        $email = new sendEmail();
        $enviados_para ='';
        foreach ($list as $ln) {
            $obj->emailTo = $ln->email;
            $obj->name = $ln->name;
            $obj->guilda = $ln->guilda;
            $erro = $email->send($obj);
            $enviados_para .= $obj->emailTo."; erro: ".$erro."; "; 
        }
     //   $erro = "Não implementado";
        //Registar na BD
        // return $enviados_para;
        return $this->insert($obj, $enviados_para);
      
    }

    private function insert($obj, $report) {
        try {
            $this->db->queryInsert("INSERT INTO emails(assunto, guilda, corpoemail, report) "
                    . " VALUES(:assunto, :guilda, :corpoemail, :report)",
                    [':assunto' => $obj->assunto, ':guilda' => $obj->guilda, ':corpoemail' => $obj->corpoemail, ':report' => $report]);
            return $this->db->lastInsertId();
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
