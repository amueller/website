<?php

class Api_gamification extends Api_model {

    protected $version = 'v1';
    
    private $scores = array();
    

    function __construct() {
        parent::__construct();

        // load models
        $this->load->model('Like');
        $this->load->model('Download');
        $this->load->model('Dataset');
        $this->load->model('Implementation');
        $this->load->model('Task');
        $this->load->model('Run');
        $this->scores['activity']['uploads'] = 3;
        $this->scores['activity']['likes'] = 2;
        $this->scores['activity']['downloads'] = 1;
        $this->scores['reach']['likes'] = 2;
        $this->scores['reach']['downloads'] = 1;
    }

    function bootstrap($format, $segments, $request_type, $user_id) {
        $getpost = array('get', 'post');

        if(count($segments)>3){
            $score = $segments[0];
            $type = $segments[1];
            $id = $segments[2];       
            
            if($segments[3]=='today'){
                $meth = 'get_progress_'.$score;
                $this->$meth($type,$id,date("Y-m-d"));
                return;
            }else if($segments[3]=='thismonth'){
                $meth = 'get_progress_'.$score;
                $this->$meth($type,$id,date("Y-m"));
                return;
            }else if($segments[3]=='thismonth_perday'){
                $meth = 'get_progress_per_day';
                $this->$meth($score,$type,$id,date("m"), date("Y"));
                return;
            }else if($segments[3]=='thisyear'){
                $meth = 'get_progress_'.$score;
                $this->$meth($type,$id,date("Y"));
                return;
            }else if($segments[3]=='thisyear_permonth'){
                $meth = 'get_progress_per_month';
                $this->$meth($score,$type,$id,date("Y"));
                return;
            }else if($segments[3]=='lastday'){
                $meth = 'get_progress_'.$score;
                $now = date("Y-m-d H:i:s");
                $this->$meth($type,$id,date('Y-m-d H:i:s', strtotime($now . ' -1 day'),$now));
                return;
            }else if($segments[3]=='lastmonth'){
                $meth = 'get_progress_'.$score;
                $now = date("Y-m-d");
                $this->$meth($type,$id,date("Y-m-d",strtotime($now. ' -1 month')));
                return;
            }else if($segments[3]=='lastmonth_perday'){
                $meth = 'get_progress_per_day';
                $this->$meth($score,$type,$id,date("m"), date("Y"),date("d"));
                return;
            }else if($segments[3]=='lastyear'){
                $meth = 'get_progress_'.$score;
                $now = date("Y-m-d");
                $this->$meth($type,$id,date("Y-m-d",strtotime($now. ' -1 year')));
                return;
            }else if($segments[3]=='lastyear_permonth'){
                $meth = 'get_progress_per_month';
                $this->$meth($score,$type,$id,date("Y"),date("m"));
                return;
            }else if(count($segments)==4 && is_numeric($segments[3])){
                $meth = 'get_progress_'.$score;
                $this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,1,1,$segments[3])),date('Y-m-d',mktime(0,0,0,1,1,$segments[3]+1)));
                return;
            }else if(count($segments)==4 && is_numeric(explode("_",$segments[3])[0]) && explode("_",$segments[3])[1]=="permonth"){
                $meth = 'get_progress_per_month';
                $this->$meth($score,$type,$id,explode("_",$segments[3])[0]);
                return;
            }else if(count($segments)==5 && is_numeric($segments[3]) && is_numeric($segments[4])){
                $meth = 'get_progress_'.$score;
                $this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$segments[4],1,$segments[3])),date('Y-m-d',mktime(0,0,0,$segments[4]+1,1,$segments[3])));
                return;
            }else if(count($segments)==5 && is_numeric($segments[3]) && is_numeric(explode("_",$segments[4])[0]) && explode("_",$segments[4])[1]=="perday"){
                $meth = 'get_progress_per_day';
                $this->$meth($score,$type,$id,intval(explode("_",$segments[4])[0]),$segments[3]);
                return;
            }else if(count($segments)==6 && is_numeric($segments[3]) && is_numeric($segments[4])&& is_numeric($segments[5])){
                $meth = 'get_progress_'.$score;
                $this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$segments[4],$segments[5],$segments[3])));
                return;
            }
        
        }

        $this->returnError(100, $this->version, 450, implode($segments));
    }
    
    private function get_progress_impact($type,$id,$from,$to=null,$return=false){
        $score_obj = new stdClass();
        $score = 0;
        if($type=='u'){
            $likes_res = [];
            $downloads_res = [];
            $data = $this->Dataset->getDatasetsOfUser($id);
            if($data){
                foreach($data as $d){
                    $score += $this->get_progress_reach('d',$d->id,$from,$to,true)->value;
                }
            }
            $flows = $this->Implementation->getImplementationsOfUser($id);
            if($flows){
                foreach($flows as $f){
                    $score += $this->get_progress_reach('f',$f->id,$from,$to,true)->value;
                }
            }
            $runs = $this->Run->getRunsOfUser($id);
            if($runs){
                foreach($runs as $r){
                    $score += $this->get_progress_reach('r',$r->id,$from,$to,true)->value;
                }
            }
            $tasks = $this->Task->getTasksOfUser($id);
            if($tasks){
                foreach($tasks as $t){
                    $score += $this->get_progress_reach('t',$t->id,$from,$to,true)->value;
                }
            }
        }else{
            $likes_res = $this->Like->getFromToKnowledge($type,$id,$from,$to);
            $downloads_res = $this->Download->getFromToKnowledge($type,$id,$from,$to);
            if(!$likes_res){
                $likes_res = [];
            }
            if(!$downloads_res){
                $downloads_res = [];
            }
            $score = $this->scores['reach']['likes'] * count($likes_res) + $this->scores['reach']['downloads'] * count($downloads_res);
        }
        $score_obj->type = 'reach';
        $score_obj->value = $score;
        $from_e = explode("-",$from);
        $score_obj->from = date('l Y-m-d',mktime(0,0,0,$from_e[1],$from_e[2],$from_e[0]));
        if($to!=null){
            $to_e = explode("-",$to);
            $score_obj->to = date('l Y-m-d',mktime(0,0,0,$to_e[1],$to_e[2],$to_e[0]));
        }else{
            $score_obj->to = null;
        }
        if ($return) {
            return $score_obj;
        } else {
            $this->xmlContents('score', $this->version, $score_obj);
        }  
    }
    
    private function get_progress_reach($type,$id,$from,$to=null,$return=false){
        $score_obj = new stdClass();
        $score = 0;
        if($type=='u'){
            $likes_res = [];
            $downloads_res = [];
            $data = $this->Dataset->getDatasetsOfUser($id);
            if($data){
                foreach($data as $d){
                    $score += $this->get_progress_reach('d',$d->id,$from,$to,true)->value;
                }
            }
            $flows = $this->Implementation->getImplementationsOfUser($id);
            if($flows){
                foreach($flows as $f){
                    $score += $this->get_progress_reach('f',$f->id,$from,$to,true)->value;
                }
            }
            $runs = $this->Run->getRunsOfUser($id);
            if($runs){
                foreach($runs as $r){
                    $score += $this->get_progress_reach('r',$r->id,$from,$to,true)->value;
                }
            }
            $tasks = $this->Task->getTasksOfUser($id);
            if($tasks){
                foreach($tasks as $t){
                    $score += $this->get_progress_reach('t',$t->id,$from,$to,true)->value;
                }
            }
        }else{
            $likes_res = $this->Like->getFromToKnowledge($type,$id,$from,$to);
            $downloads_res = $this->Download->getFromToKnowledge($type,$id,$from,$to);
            if(!$likes_res){
                $likes_res = [];
            }
            if(!$downloads_res){
                $downloads_res = [];
            }
            $score = $this->scores['reach']['likes'] * count($likes_res) + $this->scores['reach']['downloads'] * count($downloads_res);
        }
        $score_obj->type = 'reach';
        $score_obj->value = $score;
        $from_e = explode("-",$from);
        $score_obj->from = date('l Y-m-d',mktime(0,0,0,$from_e[1],$from_e[2],$from_e[0]));
        if($to!=null){
            $to_e = explode("-",$to);
            $score_obj->to = date('l Y-m-d',mktime(0,0,0,$to_e[1],$to_e[2],$to_e[0]));
        }else{
            $score_obj->to = null;
        }
        if ($return) {
            return $score_obj;
        } else {
            $this->xmlContents('score', $this->version, $score_obj);
        }  
    }

    private function get_progress_activity($type, $id, $from, $to=null, $return=false) {
        $score_obj = new stdClass();
        if($type=='u'){
            $likes_res = $this->Like->getFromToUser($id,$from,$to);
            $downloads_res = $this->Download->getFromToUser($id,$from,$to);
            $data_ft = $this->Dataset->getDatasetsOfUser($id,$from,$to);
            $implementation_ft = $this->Implementation->getImplementationsOfUser($id,$from,$to);
            $runs_ft = $this->Run->getRunsOfUser($id,$from,$to);
            $tasks_ft = $this->Task->getTasksOfUser($id,$from,$to);
            if(!$likes_res){
                $likes_res = [];
            }
            if(!$downloads_res){
                $downloads_res = [];
            }
            if(!$data_ft){
                $data_ft = [];
            }
            if(!$implementation_ft){
                $implementation_ft = [];
            }
            if(!$runs_ft){
                $runs_ft = [];
            }
            if(!$tasks_ft){
                $tasks_ft = [];
            }
            $score = ($this->scores['activity']['uploads'] * (count($data_ft)+count($implementation_ft)+count($runs_ft)+count($tasks_ft))) + $this->scores['activity']['likes'] * count($likes_res) + $this->scores['activity']['downloads'] * count($downloads_res);
            $score_obj->type = 'activity';
            $score_obj->value = $score;
            $from_e = explode("-",$from);
            $score_obj->from = date('l Y-m-d',mktime(0,0,0,$from_e[1],$from_e[2],$from_e[0]));
            if($to!=null){
                $to_e = explode("-",$to);
                $score_obj->to = date('l Y-m-d',mktime(0,0,0,$to_e[1],$to_e[2],$to_e[0]));
            }else{
                $score_obj->to = null;
            }
            if ($return) {
                return $score_obj;
            } else {
                $this->xmlContents('score', $this->version, $score_obj);
            }
        }else{
            $this->returnError(100, $this->version);
        }        
    }
    
    private function get_progress_per_day($score,$type, $id, $month, $year, $day=null){
        $meth = 'get_progress_'.$score;
        $scores = array();
        if($day==null){
            $max = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for($i=1; $i<$max; $i++){
                $scores[$i-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$month,$i,$year)),date('Y-m-d',mktime(0,0,0,$month,$i+1,$year)),true);
            }
            $scores[$max-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$month,$max,$year)),date('Y-m-d',mktime(0,0,0,$month+1,1,$year)),true);
        }else{
            if($month>1){
                $lmonth=$month-1;
                $lyear = $year;
            }else{
                $lmonth=12;
                $lyear = $year-1;
            }
            $max = cal_days_in_month(CAL_GREGORIAN,$lmonth,$year);
            for($i=$day; $i<$max; $i++){
                $scores[$i-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$lmonth,$i,$lyear)),date('Y-m-d',mktime(0,0,0,$lmonth,$i+1,$lyear)),true);
            }
            $scores[$max-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$lmonth,$max,$lyear)),date('Y-m-d',mktime(0,0,0,$lmonth+1,1,$lyear)),true);
            for($i=1; $i<$day; $i++){
                $scores[$max-1 + $i-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$month,$i,$year)),date('Y-m-d',mktime(0,0,0,$month,$i+1,$year)),true);
            }
            $scores[$max-1+$day-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$month,$day,$year)),null,true);
        }
        $this->xmlContents('scores', $this->version, array('type'=>$score,'scores'=>$scores));
    }

    private function get_progress_per_month($score,$type, $id, $year, $month=null){
        $meth = 'get_progress_'.$score;
        $scores = array();
        if($month==null){
            $max = 12;
            for($i=1; $i<$max; $i++){
                $scores[$i-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$i,1,$year)),date('Y-m-d',mktime(0,0,0,$i+1,1,$year)),true);
            }
            $scores[$max-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$max,1,$year)),date('Y-m-d',mktime(0,0,0,1,1,$year+1)),true);
        }else{
            $lyear = $year -1;
            $max = 12;
            for($i=$month; $i<$max; $i++){
                $scores[$i-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$i,1,$lyear)),date('Y-m-d',mktime(0,0,0,$i+1,1,$lyear)),true);
            }
            $scores[$max-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$max,1,$lyear)),date('Y-m-d',mktime(0,0,0,1,1,$year)),true);
            for($i=1; $i<$month; $i++){
                $scores[$max-1 + $i-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$i,1,$year)),date('Y-m-d',mktime(0,0,0,$i+1,1,$year)),true);
            }
            $scores[$max-1+$month-1]=$this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$month,1,$year)),null,true);
        }
        $this->xmlContents('scores', $this->version, array('type'=>$score,'scores'=>$scores));
    }
    
}

?>

