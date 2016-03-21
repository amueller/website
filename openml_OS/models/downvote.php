<?php

class Downvote extends Database_write {

    function __construct() {
        parent::__construct();
        $this->table = 'downvotes';
        $this->id_column = 'vid';
        $this->user_id_column = 'user_id';
        $this->knowledge_id_column = 'knowledge_id';
        $this->knowledge_type_column = 'knowledge_type';
        $this->reason_column = 'reason_given';
        $this->time_column = 'time';
    }

    function getDownvote($id) {
        $sql = 'SELECT `l`.*
            FROM `' . $this->table . '` AS `l`
            WHERE `l`.`' . $this->id_column . '` = "' . $id . '"';

        return $this->Downvote->query($sql);
    }

    function getDownvotesByUser($userid) {
        $sql = 'SELECT `l`.*
            FROM `' . $this->table . '` AS `l`
            WHERE `l`.`' . $this->user_id_column . '` = "' . $userid . '"';

        return $this->Downvote->query($sql);
    }

    function getDownvotesByType($type) {
        $sql = 'SELECT `l`.*
            FROM `' . $this->table . '` AS `l`
            WHERE `l`.`' . $this->knowledge_type_column . '` = "' . $type . '"';
        return $this->Downvote->query($sql);
    }

    function getDownvotesByUserAndType($userid, $type) {
        $sql = 'SELECT `l`.*
            FROM `' . $this->table . '` AS `l`
            WHERE `l`.`' . $this->user_id_column . '` = "' . $userid . '"
            AND `l`.`' . $this->knowledge_type_column . '` = "' . $type . '"';

        return $this->Downvote->query($sql);
    }

    function getDownvotesByKnowledgePiece($type, $id) {
        $sql = 'SELECT `l`.*
            FROM `' . $this->table . '` AS `l`
            WHERE `l`.`' . $this->knowledge_type_column . '` = "' . $type . '"
            AND `l`.`' . $this->knowledge_id_column . '` = "' . $id . '"';

        return $this->Downvote->query($sql);
    }

    function getByIds($u_id, $k_type, $k_id) {
        $sql = 'SELECT `l`.*
            FROM `' . $this->table . '` AS `l`
            WHERE `l`.`' . $this->knowledge_type_column . '` = "' . $k_type . '"
            AND `l`.`' . $this->knowledge_id_column . '` = "' . $k_id . '"
            AND `l`.`' . $this->user_id_column . '` = "' . $u_id . '"';
        return $this->Downvote->query($sql);
    }
    
    function getFromToUser($u_id, $from, $to){
         $sql = 'SELECT `l`.*
            FROM `' . $this->table . '` AS `l`
            WHERE `l`.`' . $this->user_id_column . '` = ' . $u_id . '
                AND `'.$this->time_column.'`>="'.$from.'"';
         if($to!=null){
            $sql.='AND `'.$this->time_column.'` < "'.$to.'"';
         }

        return $this->Downvote->query($sql);
    }
    
    function getFromToKnowledge($k_type, $k_id, $from, $to){
         $sql = 'SELECT `l`.*
            FROM `' . $this->table . '` AS `l`
            WHERE `l`.`' . $this->knowledge_type_column . '` = "' . $k_type . '"
                AND `l`.`' . $this->knowledge_id_column . '` = "' . $k_id . '"
                AND `'.$this->time_column.'`>="'.$from.'"';
         if($to!=null){
            $sql.='AND `'.$this->time_column.'` < "'.$to.'"';
         }

        return $this->Like->query($sql);
    }

    function deleteByIds($u_id, $k_type, $k_id) {
        $sql = 'DELETE FROM `' . $this->table . '`
            WHERE `l`.`' . $this->knowledge_type_column . '` = "' . $k_type . '"
            AND `l`.`' . $this->knowledge_id_column . '` = "' . $k_id . '"
            AND `l`.`' . $this->user_id_column . '` = "' . $u_id . '"';

        return $this->Downvote->query($sql);
    }

    function insertByIds($u_id, $k_type, $k_id, $reason) {
        $like_data = array(
            $this->user_id_column => $u_id,
            $this->knowledge_type_column => $k_type,
            $this->knowledge_id_column => $k_id,
            $this->reason_column => $reason
        );

        return $this->Downvote->insert($like_data);
    }

}
