<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class KnowledgePiece extends Database_write{
    
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
    
    function getAllUploadsOfUser($u_id, $from=null, $to=null){
        $data_sql = "SELECT d.did as id, d.uploader, d.upload_date as time, 'd' as kt FROM dataset as d WHERE d.uploader=".$u_id;
        $flow_sql = "SELECT f.id, f.uploader, f.uploadDate as time, 'f' as kt FROM implementation as f WHERE f.uploader=".$u_id;
        $task_sql = "SELECT t.task_id as id, t.creator as uploader, t.creation_date as time, 't' as kt FROM task as t WHERE t.creator=".$u_id;
        $run_sql = "SELECT r.rid as id, r.uploader, r.processed as time, 'r' as kt FROM run as r WHERE r.uploader=".$u_id;
        $upload_sql = "SELECT uploads.kt, count(uploads.id) as count, DATE(uploads.time) as date FROM (".$data_sql." UNION ".$flow_sql." UNION ".$task_sql." UNION ".$run_sql.") as uploads";
        if ($from != null && $to!=null) {
            $upload_sql .= ' WHERE uploads.time>="' . $from . '"';
            $upload_sql .= ' AND uploads.time<"' . $to . '"';
            $upload_sql.=" GROUP BY uploads.kt, DATE(uploads.time) ORDER BY date;";
        }else if ($to != null) {
            $upload_sql .= ' WHERE uploads.time<"' . $to . '"';
            $upload_sql.=" GROUP BY uploads.kt, DATE(uploads.time) ORDER BY date;";
        }else if($from!=null){
            $upload_sql .= ' WHERE uploads.time>="' . $from . '"'; 
            $upload_sql.=" GROUP BY uploads.kt, DATE(uploads.time) ORDER BY date;";           
        }else{            
            $upload_sql.=" GROUP BY uploads.kt;";
        }
        
        return $this->KnowledgePiece->query($upload_sql);
    }
    
    function getLikesOnUploadsOfUser($u_id, $from=null, $to=null){
        $like_sql = "SELECT uploads.*,likes.user_id, likes.time FROM `likes`, (SELECT d.did as id, d.uploader, 'd' as kt FROM dataset as d WHERE d.uploader=".$u_id."
                                                                    UNION
                                                                    SELECT f.id, f.uploader, 'f' as kt FROM implementation as f WHERE f.uploader=".$u_id."
                                                                    UNION
                                                                    SELECT t.task_id as id, t.creator as uploader, 't' as kt FROM task as t WHERE t.creator=".$u_id."
                                                                    UNION
                                                                    SELECT r.rid as id, r.uploader, 'r' as kt FROM run as r WHERE r.uploader=".$u_id.") as uploads
                    WHERE likes.knowledge_id=uploads.id AND likes.knowledge_type=uploads.kt";
        if ($from != null) {
            $like_sql.=' AND `time`>="' . $from . '"';
        }
        if ($to != null) {
            $like_sql.=' AND `time` < "' . $to . '"';
        }
        $like_sql.=" ORDER BY likes.time";
        return $this->KnowledgePiece->query($like_sql);
    }
    
    function getDownloadsOnUploadsOfUser($u_id, $from=null, $to=null){
        $download_sql = "SELECT uploads.*,downloads.user_id, downloads.time FROM `downloads`, (SELECT d.did as id, d.uploader, 'd' as kt FROM dataset as d WHERE d.uploader=".$u_id."
                                                                                UNION
                                                                                SELECT f.id, f.uploader, 'f' as kt FROM implementation as f WHERE f.uploader=".$u_id."
                                                                                UNION
                                                                                SELECT t.task_id as id, t.creator as uploader, 't' as kt FROM task as t WHERE t.creator=".$u_id."
                                                                                UNION
                                                                                SELECT r.rid as id, r.uploader, 'r' as kt FROM run as r WHERE r.uploader=".$u_id.") as uploads
                    WHERE downloads.knowledge_id=uploads.id AND downloads.knowledge_type=uploads.kt";
        if ($from != null) {
            $download_sql.=' AND `time`>="' . $from . '"';
        }
        if ($to != null) {
            $download_sql.=' AND `time` < "' . $to . '"';
        }
        $download_sql.=" ORDER BY downloads.time";
        return $this->KnowledgePiece->query($download_sql);
    }
    
    function getLikesAndDownloadsOnUploadsOfUser($u_id, $from=null, $to=null){
        $sql = "SELECT uploads.kt,count(ld.user_id) as count, SUM(ld.count) as sum, ld.ldt, DATE(ld.time) as date FROM (SELECT d.did as id, d.uploader, 'd' as kt FROM dataset as d WHERE d.uploader=".$u_id."
                                                                    UNION
                                                                    SELECT f.id, f.uploader, 'f' as kt FROM implementation as f WHERE f.uploader=".$u_id."
                                                                    UNION
                                                                    SELECT t.task_id as id, t.creator as uploader, 't' as kt FROM task as t WHERE t.creator=".$u_id."
                                                                    UNION
                                                                    SELECT r.rid as id, r.uploader, 'r' as kt FROM run as r WHERE r.uploader=".$u_id.") as uploads,";
        $like_sql = "SELECT user_id, knowledge_id, knowledge_type, 1 as count, time, 'l' as ldt FROM likes";
        $download_sql = "SELECT user_id, knowledge_id, knowledge_type, count, time, 'd' as ldt FROM downloads";
        $sql.="(".$like_sql." UNION ".$download_sql.") as ld WHERE ld.knowledge_id=uploads.id AND ld.knowledge_type=uploads.kt";
        if ($from != null) {
            $sql.=' AND ld.time>="' . $from . '"';
        }
        if ($to != null) {
            $sql.=' AND ld.time < "' . $to . '"';
        }
        if($from!=null || $to!=null){
            $sql.=" GROUP BY DATE(ld.time), ld.ldt, uploads.kt ORDER BY date;";
        }else{
            $sql.=" GROUP BY ld.ldt, uploads.kt;";
        }

        return $this->KnowledgePiece->query($sql);
    }
    
    function getLikesAndDownloadsOnUpload($type,$id,$from=null,$to=null){
        $sql = "SELECT upload.kt, count(ld.user_id) as count, SUM(ld.count) as sum, ld.ldt, DATE(ld.time) as date FROM (";
        if($type=='d'){
            $sql.="SELECT d.did as id, d.uploader, 'd' as kt FROM dataset as d WHERE d.did=".$id;
        }else if($type=='f'){
            $sql.="SELECT f.id, f.uploader, 'f' as kt FROM implementation as f WHERE f.id=".$id;
        }else if($type=='t'){
            $sql.="SELECT t.task_id as id, t.creator as uploader, 't' as kt FROM task as t WHERE t.task_id=".$id;
        }else /*if($type=='r')*/{
            $sql.="SELECT r.rid as id, r.uploader, 'r' as kt FROM run as r WHERE r.rid=".$id;
        }
        $sql.=") as upload,";
        $like_sql = "SELECT user_id, knowledge_id, knowledge_type, 1 as count, time, 'l' as ldt FROM likes";
        $download_sql = "SELECT user_id, knowledge_id, knowledge_type, count, time, 'd' as ldt FROM downloads";
        $sql.="(".$like_sql." UNION ".$download_sql.") as ld WHERE ld.knowledge_id=upload.id AND ld.knowledge_type=upload.kt";
        if ($from != null) {
            $sql.=' AND ld.time>="' . $from . '"';
        }
        if ($to != null) {
            $sql.=' AND ld.time < "' . $to . '"';
        }
        if($from!=null || $to!=null){
            $sql.=" GROUP BY DATE(ld.time), ld.ldt ORDER BY date;";
        }else{
            $sql.=" GROUP BY ld.ldt;";
        }
        return $this->KnowledgePiece->query($sql);        
    }
    
    function getLikesAndDownloadsOfuser($u_id, $from=null, $to=null){
        $like_sql = "SELECT user_id, knowledge_id, knowledge_type, 1 as count, time, 'l' as ldt FROM likes WHERE user_id=".$u_id;
        $download_sql = "SELECT user_id, knowledge_id, knowledge_type, count, time, 'd' as ldt FROM downloads WHERE user_id=".$u_id;
        $sql = "SELECT ld.ldt, count(ld.user_id), sum(ld.count), DATE(ld.time) as date FROM (".$like_sql." UNION ".$download_sql.") as ld ";
        if ($from != null && $to!=null) {
            $sql .= ' WHERE ld.time>="' . $from . '"';
            $sql .= ' AND ld.time<"' . $to . '"';
            $sql.=" GROUP BY ld.ldt, DATE(ld.time) ORDER BY date;";
        }else if ($to != null) {
            $sql .= ' WHERE ld.time<"' . $to . '"';
            $sql.=" GROUP BY ld.ldt, DATE(ld.time) ORDER BY date;";
        }else if($from!=null){
            $sql .= ' WHERE ld.time>="' . $from . '"'; 
            $sql.=" GROUP BY ld.ldt, DATE(ld.time) ORDER BY date;";           
        }else{            
            $sql.=" GROUP BY ld.ldt;";
        }
        
        return $this->KnowledgePiece->query($sql);        
    }
    
    function getReuseOfUploadsOfUser($u_id,$from=null,$to=null){
        $datareuse_sql = "SELECT dataset.did as oringal_id, 'd' as ot, task_inputs.task_id as reuse_id, 't' as rt, task.creation_date as time FROM  task`, `task_inputs`, `dataset` WHERE dataset.uploader=".$u_id." AND task_inputs.value=dataset.did AND task_inputs.input='source_data' AND task.task_id=task_inputs.task_id";
        $flowreuse_sql = "SELECT implementation.id as oringal_id, 'f' as ot, run.rid as reuse_id, 'r' as rt, run.processed as time FROM `implementation`, `run`, `algorithm_setup` WHERE implementation.uploader=".$u_id." AND algorithm_setup.implementation_id=implementation.id AND run.setup=algorithm_setup.sid";
        $taskreuse_sql = "SELECT task.task_id as oringal_id, 't' as ot, run.rid as reuse_id, 'r' as rt, run.processed as time FROM `task`, `run` WHERE task.creator=".$u_id." AND run.task_id=task.task_id";
        $sql="SELECT reuse.ot, count(reuse.reuse_id), DATE(reuse.time) as date FROM (".$datareuse_sql." UNION ".$flowreuse_sql." UNION ".$taskreuse_sql.") as reuse";
        if ($from != null && $to!=null) {
            $sql .= ' WHERE reuse.time>="' . $from . '"';
            $sql .= ' AND reuse.time<"' . $to . '"';
            $sql.=" GROUP BY reuse.ot, DATE(reuse.time) ORDER BY date;";
        }else if ($to != null) {
            $sql .= ' WHERE reuse.time<"' . $to . '"';
            $sql.=" GROUP BY reuse.ot, DATE(reuse.time) ORDER BY date;";
        }else if($from!=null){
            $sql .= ' WHERE reuse.time>="' . $from . '"'; 
            $sql.=" GROUP BY reuse.ot, DATE(reuse.time) ORDER BY date;";           
        }else{            
            $sql.=" GROUP BY reuse.ot;";
        }
        return $this->KnowledgePiece->query($sql);
    }
    
    function getLikesAndDownloadsOnReuseOfUploadsOfUser($u_id,$from=null,$to=null){
        $datareuse_sql = "SELECT dataset.did as oringal_id, 'd' as ot, task_inputs.task_id as reuse_id, 't' as rt FROM  `task`, `task_inputs`, `dataset` WHERE dataset.uploader=".$u_id." AND task_inputs.value=dataset.did AND task_inputs.input='source_data' AND task.task_id=task_inputs.task_id";
        $flowreuse_sql = "SELECT implementation.id as oringal_id, 'f' as ot, run.rid as reuse_id, 'r' as rt FROM `implementation`, `run`, `algorithm_setup` WHERE implementation.uploader=".$u_id." AND algorithm_setup.implementation_id=implementation.id AND run.setup=algorithm_setup.sid";
        $taskreuse_sql = "SELECT task.task_id as oringal_id, 't' as ot, run.rid as reuse_id, 'r' as rt FROM `task`, `run` WHERE task.creator=".$u_id." AND run.task_id=task.task_id";
        
        $sql="SELECT reuse.ot,count(ld.user_id) as count, SUM(ld.count) as sum, ld.ldt, DATE(ld.time) as date FROM (".$datareuse_sql." UNION ".$flowreuse_sql." UNION ".$taskreuse_sql.") as reuse, (";
        
        $like_sql = "SELECT user_id, knowledge_id, knowledge_type, 1 as count, time, 'l' as ldt FROM likes";
        $download_sql = "SELECT user_id, knowledge_id, knowledge_type, count, time, 'd' as ldt FROM downloads";
        
        $sql.=$like_sql." UNION ".$download_sql.") as ld WHERE ld.knowledge_type=reuse.rt AND ld.knowledge_id=reuse.reuse_id";
        if ($from != null) {
            $sql.=' AND ld.time>="' . $from . '"';
        }
        if ($to != null) {
            $sql.=' AND ld.time < "' . $to . '"';
        }
        if($from!=null || $to!=null){
            $sql.=" GROUP BY DATE(ld.time), ld.ldt, reuse.ot ORDER BY date;";
        }else{
            $sql.=" GROUP BY ld.ldt, reuse.ot;";
        }
        
        return $this->KnowledgePiece->query($sql);        
    }
    
    function getLikesAndDownloadsOnReuseOfUpload($type,$id,$from=null,$to=null){
        if($type=='d'){
            $reuse_sql = "SELECT dataset.did as oringal_id, 'd' as ot, task_inputs.task_id as reuse_id, 't' as rt FROM  `task`, `task_inputs`, `dataset` WHERE dataset.uploader=".$id." AND task_inputs.value=dataset.did AND task_inputs.input='source_data' AND task.task_id=task_inputs.task_id";
        }else if($type=='f'){
            $reuse_sql = "SELECT implementation.id as oringal_id, 'f' as ot, run.rid as reuse_id, 'r' as rt FROM `implementation`, `run`, `algorithm_setup` WHERE implementation.uploader=".$id." AND algorithm_setup.implementation_id=implementation.id AND run.setup=algorithm_setup.sid";
        }else /*if($type=='t')*/{
            $reuse_sql = "SELECT task.task_id as oringal_id, 't' as ot, run.rid as reuse_id, 'r' as rt FROM `task`, `run` WHERE task.creator=".$id." AND run.task_id=task.task_id";
        }
        $sql="SELECT reuse.ot,count(ld.user_id) as count, SUM(ld.count) as sum, ld.ldt, DATE(ld.time) as date FROM (".$reuse_sql.") as reuse, (";
        
        $like_sql = "SELECT user_id, knowledge_id, knowledge_type, 1 as count, time, 'l' as ldt FROM likes";
        $download_sql = "SELECT user_id, knowledge_id, knowledge_type, count, time, 'd' as ldt FROM downloads";
        
        $sql.=$like_sql." UNION ".$download_sql.") as ld WHERE ld.knowledge_type=reuse.rt AND ld.knowledge_id=reuse.reuse_id";
        if ($from != null) {
            $sql.=' AND ld.time>="' . $from . '"';
        }
        if ($to != null) {
            $sql.=' AND ld.time < "' . $to . '"';
        }
        if($from!=null || $to!=null){
            $sql.=" GROUP BY DATE(ld.time), ld.ldt, reuse.ot ORDER BY date;";
        }else{
            $sql.=" GROUP BY ld.ldt, reuse.ot;";
        }
        
        return $this->KnowledgePiece->query($sql);        
    }
    
    
}

