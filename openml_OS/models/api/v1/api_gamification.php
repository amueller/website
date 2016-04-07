<?php

class Api_gamification extends Api_model {

    protected $version = 'v1';
    
    private $scores = array();
    //private $badges = array();
    

    function __construct() {
        parent::__construct();

        // load models
        $this->load->model('KnowledgePiece');
        $this->scores['activity']['uploads'] = 3;
        $this->scores['activity']['likes'] = 2;
        $this->scores['activity']['downloads'] = 1;
        $this->scores['reach']['likes'] = 2;
        $this->scores['reach']['downloads'] = 1;
        $this->scores['impact']['reach'] = 0.5;
    }

    function bootstrap($format, $segments, $request_type, $user_id) {
        $this->outputFormat = $format;
        
        $getpost = array('get', 'post');

        if(count($segments)>=3){
            $score = $segments[0];
            $type = $segments[1];
            $id = $segments[2];
            
            if($score=='badges'){
                $this->checkBadges($id);
                return;
            }else if($segments[3]=='today'){
                $meth = 'get_progress_'.$score.'_whole';
                $this->$meth($type,$id,date("Y-m-d"));
                return;
            }else if($segments[3]=='thismonth'){ //progress from the start of the current month until today
                $meth = 'get_progress_'.$score.'_whole';
                $this->$meth($type,$id,date("Y-m"));
                return;
            }else if($segments[3]=='thismonth_perday'){ //progress for each day from the start of the current month until today
                $meth = 'get_progress_'.$score.'_perday';
                $now = date("Y-m-d");
                $this->$meth($type,$id,date("Y-m")."-1",date("Y-m-d",strtotime($now. ' +1 day')));
                return;
            }else if($segments[3]=='thisyear'){ //progress form the start of the current year until today
                $meth = 'get_progress_'.$score.'_whole';
                $this->$meth($type,$id,date("Y"));
                return;
            }else if($segments[3]=='thisyear_perday'){//progress for each day from the start of the current year until today
                $meth = 'get_progress_'.$score.'_perday';
                $now = date("Y-m-d");
                $this->$meth($type,$id,date("Y")."-1-1",date("Y-m-d",strtotime($now. ' +1 day')));
                return;
            }else if($segments[3]=='lastday'){//progress of the last 24 hours
                $meth = 'get_progress_'.$score.'_whole';
                $now = date("Y-m-d H:i:s");
                $this->$meth($type,$id,date('Y-m-d H:i:s', strtotime($now . ' -1 day'),$now));
                return;
            }else if($segments[3]=='lastmonth'){//progress of the last 28/29/30/31 days
                $meth = 'get_progress_'.$score.'_whole';
                $now = date("Y-m-d");
                $this->$meth($type,$id,date("Y-m-d",strtotime($now. ' -1 month')));
                return;
            }else if($segments[3]=='lastmonth_perday'){//progress for each day of the last 28/29/30/31 days
                $meth = 'get_progress_'.$score.'_perday';
                $now = date("Y-m-d");
                $this->$meth($type,$id,date("Y-m-d",strtotime($now. ' -1 month')),$now);
                return;
            }else if($segments[3]=='lastyear'){//progress of the last 365/366 days
                $meth = 'get_progress_'.$score."_whole";
                $now = date("Y-m-d");
                $this->$meth($type,$id,date("Y-m-d",strtotime($now. ' -1 year')));
                return;
            }else if($segments[3]=='lastyear_perday'){//progress for each day of the last 365/366 days
                $meth = 'get_progress_'.$score.'_perday';
                $now = date("Y-m-d");
                $this->$meth($type,$id,date("Y-m-d",strtotime($now. ' -1 year')),$now);
                return;                
            }else if(count($segments)==4 && is_numeric($segments[3])){ //progress of $segment[3] (ex. 2014)
                $meth = 'get_progress_'.$score.'_whole';
                $this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,1,1,$segments[3])),date('Y-m-d',mktime(0,0,0,1,1,$segments[3]+1)));
                return;
            }else if(count($segments)==4 && is_numeric(explode("_",$segments[3])[0]) && explode("_",$segments[3])[1]=="perday"){//progress for each day of (first part of) $segment[3] (ex. 2014)
                $meth = 'get_progress_'.$score.'_perday';
                $this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,1,1,explode("_",$segments[3])[0])),date('Y-m-d',mktime(0,0,0,1,1,explode("_",$segments[3])[0]+1)));
                return;
            }else if(count($segments)==5 && is_numeric($segments[3]) && is_numeric($segments[4])){//progress of $segment[3]-$segment[4] (ex. 2014-2)
                $meth = 'get_progress_'.$score.'_whole';
                $this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$segments[4],1,$segments[3])),date('Y-m-d',mktime(0,0,0,$segments[4]+1,1,$segments[3])));
                return;
            }else if(count($segments)==5 && is_numeric($segments[3]) && is_numeric(explode("_",$segments[4])[0]) && explode("_",$segments[4])[1]=="perday"){//progress for each day of {$segment[3]-(first part of) $segment[4]} (ex. 2014-2)
                $meth = 'get_progress_'.$score.'_perday';
                $this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,explode("_",$segments[4])[0],1,$segments[3])),date('Y-m-d',mktime(0,0,0,explode("_",$segments[4])[0],1,$segments[3]+1)));
                return;
            }else if(count($segments)==6 && is_numeric($segments[3]) && is_numeric($segments[4])&& is_numeric($segments[5])){ //progress of $segment[3]-$segment[4]-$segment[5] (ex. 2014-2-24)
                $meth = 'get_progress_'.$score.'_whole';
                $this->$meth($type,$id,date('Y-m-d',mktime(0,0,0,$segments[4],$segments[5],$segments[3])),date('Y-m-d',mktime(0,0,0,$segments[4],$segments[5]+1,$segments[3])));
                return;
            }
        
        }

        $this->returnError(100, $this->version, 450, implode($segments));
    }
    
    private function get_progress_impact_perday($type,$id,$from,$to){
        $size = $this->getNumberOfDaysFromTo($from,$to);
        $empty_val = array("reuse_reach"=>0,"recursive_impact"=>0,"impact"=>0,"date"=>"");
        $result = array_fill(0,$size,$empty_val);
        if($type=='u'){
            $ld_reuse = $this->KnowledgePiece->getLikesAndDownloadsOnReuseOfUploadsOfUser($id,$from,$to);
        }else{
            $ld_reuse = $this->KnowledgePiece->getLikesAndDownloadsOnReuseOfUpload($type,$id,$from,$to);
        }
        if($ld_reuse){
            foreach($ld_reuse as $likeordownload){
                $datediff = (strtotime($likeordownload->date) - strtotime($from))/(60*60*24);
                if($likeordownload->ldt=='d'){
                    $result[floor($datediff)]['reuse_reach']+=($likeordownload->count*$this->scores['reach']['downloads']);
                    $result[floor($datediff)]['impact']+=(($likeordownload->count*$this->scores['reach']['downloads'])*$this->scores['impact']['reach']);
                }else if($likeordownload->ldt=='l'){
                    $result[floor($datediff)]['reuse_reach']+=($likeordownload->count*$this->scores['reach']['likes']);
                    $result[floor($datediff)]['impact']+=(($likeordownload->count*$this->scores['reach']['likes'])*$this->scores['impact']['reach']);
                }
            }
        }        
        for($i=0; $i<count($result); $i++){
            $result[$i]['date'] = date("l Y-m-d",strtotime($from. '+'.$i.' days'));
        }
        $result_wrapper = array("results"=>$result);
        $this->xmlContents('impact-progress', $this->version, $result_wrapper);
    }
    
    private function get_progress_impact_whole($type,$id,$from,$to=null){
        $result_val = array("reuse_reach"=>0,"recursive_impact"=>0,"impact"=>0,"date"=>$from);
        if($type=='u'){
            $ld_reuse = $this->KnowledgePiece->getLikesAndDownloadsOnReuseOfUploadsOfUser($id,$from,$to);
        }else{
            $ld_reuse = $this->KnowledgePiece->getLikesAndDownloadsOnReuseOfUpload($type,$id,$from,$to);
        }
        if($ld_reuse){
            foreach($ld_reuse as $likeordownload){
                if($likeordownload->ldt=='d'){
                    $result_val['reuse_reach']+=($likeordownload->count*$this->scores['reach']['downloads']);
                    $result_val['impact']+=(($likeordownload->count*$this->scores['reach']['downloads'])*$this->scores['impact']['reach']);
                }else if($likeordownload->ldt=='l'){
                    $result_val['reuse_reach']+=($likeordownload->count*$this->scores['reach']['likes']);
                    $result_val['impact']+=(($likeordownload->count*$this->scores['reach']['likes'])*$this->scores['impact']['reach']);
                }
            }
        }
        $result_wrapper = array("results"=>array($result_val));
        $this->xmlContents('impact-progress', $this->version, $result_wrapper);
    }
    
    private function get_progress_reach_perday($type,$id,$from,$to){
        $size = $this->getNumberOfDaysFromTo($from,$to);
        $empty_val = array("likes"=>0,"downloads"=>0,"reach"=>0,"date"=>"");
        $result = array_fill(0,$size,$empty_val);
        if($type=='u'){
            $ld_received = $this->KnowledgePiece->getLikesAndDownloadsOnUploadsOfUser($id,$from,$to);
        }else{
            $ld_received = $this->KnowledgePiece->getLikesAndDownloadsOnUpload($type,$id,$from,$to);
        }
        if($ld_received){
            foreach($ld_received as $likeordownload){
                $datediff = (strtotime($likeordownload->date) - strtotime($from))/(60*60*24);
                if($likeordownload->ldt=='d'){
                    $result[floor($datediff)]['downloads']+=$likeordownload->count;
                    $result[floor($datediff)]['reach']+=($likeordownload->count*$this->scores['reach']['downloads']);
                }else if($likeordownload->ldt=='l'){
                    $result[floor($datediff)]['likes']+=$likeordownload->count;
                    $result[floor($datediff)]['reach']+=($likeordownload->count*$this->scores['reach']['likes']);
                }
            }
        }
        for($i=0; $i<count($result); $i++){
            $result[$i]['date'] = date("l Y-m-d",strtotime($from. '+'.$i.' days'));
        }
        $result_wrapper = array("results"=>$result);
        $this->xmlContents('reach-progress', $this->version, $result_wrapper);
    }
    
    private function get_progress_reach_whole($type,$id,$from,$to=null){
        $result_val = array("likes"=>0,"downloads"=>0,"reach"=>0,"date"=>$from);
        if($type=='u'){
            $ld_received = $this->KnowledgePiece->getLikesAndDownloadsOnUploadsOfUser($id,$from,$to);
        }else{
            $ld_received = $this->KnowledgePiece->getLikesAndDownloadsOnUpload($type,$id,$from,$to);
        }
        if($ld_received){
            foreach($ld_received as $likeordownload){
                if($likeordownload->ldt=='d'){
                    $result_val['downloads']+=$likeordownload->count;
                    $result_val['reach']+=($likeordownload->count*$this->scores['reach']['downloads']);
                }else if($likeordownload->ldt=='l'){
                    $result_val['likes']+=$likeordownload->count;
                    $result_val['reach']+=($likeordownload->count*$this->scores['reach']['likes']);
                }
            }
        }
        $result_wrapper = array("results"=>array($result_val));
        $this->xmlContents('reach-progress', $this->version, $result_wrapper);
    }
    
    private function get_progress_activity_perday($type,$id,$from,$to){
        $size = $this->getNumberOfDaysFromTo($from,$to);
        $empty_val = array("uploads"=>0,"likes"=>0,"downloads"=>0,"activity"=>0,"date"=>"");
        $result = array_fill(0,$size,$empty_val);
        if($type=='u'){
            $uploads = $this->KnowledgePiece->getAllUploadsOfUser($id,$from,$to);
            $ld = $this->KnowledgePiece->getLikesAndDownloadsOfuser($id,$from,$to);
            if($uploads){
                foreach($uploads as $up){
                    $datediff = (strtotime($up->date) - strtotime($from))/(60*60*24);
                    $result[floor($datediff)]['uploads']+=$up->count;
                    $result[floor($datediff)]['activity']+=($up->count*$this->scores['activity']['uploads']);
                }
            }
            if($ld){
                foreach($ld as $likeordownload){
                    $datediff = (strtotime($likeordownload->date) - strtotime($from))/(60*60*24);
                    if($likeordownload->ldt=='d'){
                        $result[floor($datediff)]['downloads']+=$likeordownload->count;
                        $result[floor($datediff)]['activity']+=($likeordownload->count*$this->scores['activity']['downloads']);
                    }else if($likeordownload->ldt=='l'){
                        $result[floor($datediff)]['likes']+=$likeordownload->count;
                        $result[floor($datediff)]['activity']+=($likeordownload->count*$this->scores['activity']['likes']);
                    }
                }
            }
        }
        for($i=0; $i<count($result); $i++){
            $result[$i]['date'] = date("l Y-m-d",strtotime($from. '+'.$i.' days'));
        }
        $result_wrapper = array("results"=>$result);
        $this->xmlContents('activity-progress', $this->version, $result_wrapper);
    }
    
    private function get_progress_activity_whole($type,$id,$from,$to=null){
        $result_val = array("uploads"=>0,"likes"=>0,"downloads"=>0,"activity"=>0,"date"=>$from);
        if($type=='u'){
            $uploads = $this->KnowledgePiece->getAllUploadsOfUser($id,$from,$to);
            $ld = $this->KnowledgePiece->getLikesAndDownloadsOfuser($id,$from,$to);
            if($uploads){
                foreach($uploads as $up){
                    $result_val['uploads']+=$up->count;
                    $result_val['activity']+=($up->count*$this->scores['activity']['uploads']);
                }
            }
            if($ld){
                foreach($ld as $likeordownload){
                    if($likeordownload->ldt=='d'){
                        $result_val['downloads']+=$likeordownload->count;
                        $result_val['activity']+=($likeordownload->count*$this->scores['activity']['downloads']);
                    }else if($likeordownload->ldt=='l'){
                        $result_val['likes']+=$likeordownload->count;
                        $result_val['activity']+=($likeordownload->count*$this->scores['activity']['likes']);
                    }
                }
            }
        }
        $result_wrapper = array("results"=>array($result_val));
        $this->xmlContents('activity-progress', $this->version, $result_wrapper);
    }    
    
    private function getNumberOfDaysFromTo($from,$to){        
        $from_e = explode("-",$from);
        $to_e = explode("-",$to);
        $size = 0;
        if ($to_e[0] == $from_e[0]) {
            if ($to_e[1] == $from_e[1]) {
                $size = $to_e[2] - $from_e[2]; //begin month and year are equal to end month and year, so count number of days
            } else {
                $size = cal_days_in_month(CAL_GREGORIAN, $from_e[1], $to_e[0]) - $from_e[2]; //number of days in the first month
                for ($i = $from_e[1] + 1; $i < $to_e[1]; $i++) { //skip first month and last month
                    $size+=cal_days_in_month(CAL_GREGORIAN, $i, $to_e[0]); //number of days for all middle months
                }
                $size+=$to_e[2]; //numer of days in final month
            }
        } else {
            $size = cal_days_in_month(CAL_GREGORIAN, $from_e[1], $to_e[0]) - $from_e[2]; //number of days in the first month
            //var_dump($size);
            for ($i = $from_e[1] + 1; $i < 13; $i++) { //number of months in the first year, skip first one
                $size+=cal_days_in_month(CAL_GREGORIAN, $i, $from_e[0]);
            }
            //var_dump($size);
            for ($j = $from_e[0] + 1; $j < $to_e[0]; $j++) { //skip first year and last year
                for ($i = 1; $i < 13; $i++) { //count all months in middle years
                    $size+=cal_days_in_month(CAL_GREGORIAN, $i, $j);
                }
            }
            //var_dump($size);
            for ($i = 1; $i < $to_e[1]; $i++) {//number of months in final year, skip last one
                $size+=cal_days_in_month(CAL_GREGORIAN, $i, $to_e[0]);
            }
            //var_dump($size);
            $size+=$to_e[2]; //number of days in final month
            //var_dump($size);
        }
        return $size;
    }

}
?>

