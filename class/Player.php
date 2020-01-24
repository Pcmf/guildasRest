<?php

require_once 'db/DB.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Player
 *
 * @author pedro
 */
class Player {

    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM players");
    }

    public function getById($id) {
        return $this->db->query("SELECT * FROM players WHERE id=:id", [':id' => $id]);
    }

    public function insert($obj) {
        $obj = $this->validateObj($obj, null);
        try {
            $this->db->queryInsert("INSERT INTO players(name, birthyear, telm, email, linkface, guilda, txdeath, txheadshot, ative, nikname, date)"
                    . " VALUES(:name, :birthyear, :telm, :email, :linkface, :guilda, :txdeath, :txheadshot, :ative, :nikname, NOW())",
                    [':name' => $obj->name, ':birthyear' => $obj->birthyear, ':telm' => $obj->telm, ':email' => $obj->email, ':linkface' => $obj->linkface,
                        ':guilda' => $obj->guilda, ':txdeath' => $obj->txdeath, ':txheadshot' => $obj->txheadshot, ':ative' => $obj->ative,
                        ':nikname' => $obj->nikname]);
            return $this->db->lastInsertId();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function update($id, $obj) {
        $obj = $this->validateObj($obj, $this->getById($id)[0]);

        try {
            return $this->db->query("UPDATE players SET name=:name, birthyear=:birthyear, telm=:telm, email=:email, linkface=:linkface,"
                            . " guilda=:guilda, txdeath=:txdeath, txheadshot=:txheadshot, ative=:ative, nikname=:nikname, data=NOW()"
                            . " WHERE id=:id",
                            [':name' => $obj->name, ':birthyear' => $obj->birthyear, ':telm' => $obj->telm, ':email' => $obj->email, ':linkface' => $obj->linkface,
                                ':guilda' => $obj->guilda, ':txdeath' => $obj->txdeath, ':txheadshot' => $obj->txheadshot, ':ative' => $obj->ative,
                                ':nikname' => $obj->nikname, ':id' => $id]);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    
    public function delete($id) {
        try {
            return $this->db->query("DELETE FROM players WHERE id=:id", [':id'=>$id]);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        
    }
    

    private function validateObj($obj, $old) {
        isset($obj->name) ? null : isset($old->name) ? $obj->name = $old->name : $obj->name = 'NULL';
        isset($obj->birthyear) ? null : isset($old->birthyear) ? $obj->birthyear = $old->birthyear : $obj->birthyear = 'NULL';
        isset($obj->telm) ? null : isset($old->telm) ? $obj->telm = $old->telm : $obj->telm = 'NULL';
        isset($obj->email) ? null : isset($old->email) ? $obj->email = $old->email : $obj->email = 'NULL';
        isset($obj->linkface) ? null : isset($old->linkface) ? $obj->linkface = $old->linkface : $obj->linkface = 'NULL';
        isset($obj->guilda) ? null : isset($old->guilda) ? $obj->guilda = $old->guilda : $obj->guilda = 'NULL';
        isset($obj->txdeath) ? null : isset($old->txdeath) ? $obj->txdeath = $old->txdeath : $obj->txdeath = 'NULL';
        isset($obj->txheadshot) ? null : isset($old->txheadshot) ? $obj->txheadshot = $old->txheadshot : $obj->txheadshot = 'NULL';
        isset($obj->ative) ? null : isset($old->ative) ? $obj->ative = $old->ative : $obj->ative = 'NULL';
        isset($obj->nikname) ? null : isset($old->nikname) ? $obj->nikname = $old->nikname : $obj->nikname = 'NULL';
    }

}
