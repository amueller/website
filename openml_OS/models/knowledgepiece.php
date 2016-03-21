<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KnowledgePiece extends CI_Model{
    
    function __construct() {
        parent::__construct();        
        
        $this->load->model('Dataset');
        $this->load->model('Implementation');
        $this->load->model('Task');
        $this->load->model('Run');
    }
    
    
    function getUploader($type, $id){
        if($type === 'd' || $type === 'data'){
            $d = $this->Dataset->getUploaderOf($id);
        }else if($type === 'f' || $type === 'flow'){
            $d = $this->Implementation->getUploaderOf($id);
        }else if($type === 't' || $type === 'task'){
            $d = $this->Task->getUploaderOf($id);
        }else if($type === 'r' || $type === 'run'){
            $d = $this->Run->getUploaderOf($id);
        }
        if($d){
            return $d[0]->uploader;
        }else{
            return -1;
        }
    }
}

