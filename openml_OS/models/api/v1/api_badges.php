<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Api_badges extends Api_model {

    protected $version = 'v1';
    
    private $badges = array();

    function __construct() {
        parent::__construct();
        // load models
        $this->load->model('api/v1/Api_gamification');
        $this->load->model('Badge');
        $this->load->model('KnowledgePiece');
        
        $descriptions = array();
        $descriptions[0] = "You don't have this badge yet.";
        $descriptions[1] = "Increase your activity by at least 1 every day, for a week.";
        $descriptions[2] = "Increase your activity by at least 1 every day, for 30 days.";
        $descriptions[3] = "Increase your activity by at least 1 every day, for a year.";
        $images = array();
        $id = 0;
        $name = "Clockwork Scientist";        
        $this->badges[0] = new BadgeStruct($id,$name,$images,$descriptions);
        
        $descriptions = array();
        $descriptions[0] = "You don't have this badge yet.";
        $descriptions[1] = "Have at least one of your uploads achieve a Reach of at least 10";
        $descriptions[2] = "Have at least one of your uploads achieve a Reach of at least 100";
        $descriptions[3] = "Have at least one of your uploads of every category (data,flow,task,run) achieve a Reach of at least 100";
        $images = array();
        $id = 1;
        $name = "Good News Everyone";
        $this->badges[1] = new BadgeStruct($id,$name,$images,$descriptions);
    }
    
    function bootstrap($format, $segments, $request_type, $user_id){
        $this->testAward($segments[0],$segments[1]);
    }
    
    function testAward($u_id,$b_id){
        
        $b = new stdClass();
        $b->key = 'description';
        $method = 'testAward'.str_replace(" ","",$this->badges[$b_id]->name);
        $b->value = $this->$method($u_id,$b_id);
        
        $this->xmlContents('simplepair',$this->version,$b);
    }
    
    private function testAwardGoodNewsEveryone($u_id){
        $uploads = $this->KnowledgePiece->getAllUploadsOfUser($u_id);
        $d_two = false;
        $f_two = false;
        $t_two = false;
        $r_two = false;
        $rank = 0;
        //var_dump($uploads['d']);
        if($uploads['d']){
            foreach($uploads['d'] as $d){
                $score = $this->Api_gamification->get_progress_reach('d',$d->id,"1-1-2013",null,true);
                //var_dump($d);
                //var_dump($score);
                //echo $d->id." ".$score->value."\n";
                if($score->value>=100){
                    $rank = 2;
                    $d_two = true;
                    break;
                }else if($score->value>=10 && $rank!=2){
                    $rank = 1;
                }
            }
        }        
        if($uploads['f']){
            foreach($uploads['f'] as $f){
                $score = $this->Api_gamification->get_progress_reach('f',$f->id,"1-1-2013",null,true);
                if($score->value>=100){
                    $rank = 2;
                    $f_two = true;
                    break;
                }else if($score->value>=10 && $rank!=2){
                    $rank = 1;
                }
            }
        }        
        if($uploads['t']){
            foreach($uploads['t'] as $t){
                $score = $this->Api_gamification->get_progress_reach('t',$t->id,"1-1-2013",null,true);
                if($score->value>=100){
                    $rank = 2;
                    $t_two = true;
                    break;
                }else if($score->value>=10 && $rank!=2){
                    $rank = 1;
                }
            }
        }        
        if($uploads['r']){
            foreach($uploads['r'] as $r){
                $score = $this->Api_gamification->get_progress_reach('r',$r->id,"1-1-2013",null,true);
                if($score->value>=100){
                    $rank = 2;
                    $r_two = true;
                    break;
                }else if($score->value>=10 && $rank!=2){
                    $rank = 1;
                }
            }
        }
        if($d_two && $f_two && $t_two && $r_two){
            $rank = 3;
        }
        $this->Badge->award($u_id,$rank,1);
        return $rank;
    }
    
    private function testAwardClockworkScientist($u_id){
        $d = explode("-", date('Y-m-d'));
        $scores = $this->Api_gamification->get_progress_per_day_foryear('activity','u',$u_id,$d[1],$d[0],$d[2],true);
        $rank=3;
        for($i=0; $i<count($scores); $i++){
            if($scores[$i]->value<1 && $i<count($scores)-30){
                $rank=2;
                $i=count($scores)-30;
            }else if($scores[$i]->value<1 && $i<count($scores)-7){
                $rank=1;
                $i=count($scores)-7;
            }else if($scores[$i]->value<1){
                $rank=0;
                $i=count($scores);
            }
        }
        $this->Badge->award($u_id,$rank,0);
        return $rank;
    }
    
    private function getDescriptionCurrentRank($u_id,$b_id){
        $rank = $this->Badge->getAwardedRank($u_id,$b_id);
        if(!$rank){
            $rank = 0;
        }
        return $this->badges[$b_id]->descriptions[$rank];
    }
    
    private function getDescriptionNextRank($u_id, $b_id){
        $rank = $this->Badge->getAwardedRank($u_id,$b_id);
        if(!$rank){
            $rank = 0;
        }
        if($rank==3){
            return 'There is no higher rank for this badge.';
        }
        return $this->badges[$b_id]->descriptions[$rank+1];
    }
    
    
}

class BadgeStruct{
    public $descriptions;
    public $images;
    public $id;
    public $name;

    function __construct($i, $n, $im, $d) {
        $this->id=$i;
        $this->name=$n;
        $this->descriptions=$d;
        $this->images=$im;
    }
    
}
