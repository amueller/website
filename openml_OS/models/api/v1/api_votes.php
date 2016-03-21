<?php

class Api_votes extends Api_model {

    protected $version = 'v1';

    function __construct() {
        parent::__construct();

        // load models
        $this->load->model('Like');
        $this->load->model('Downvote');
        $this->load->model('KnowledgePiece');
    }

    function bootstrap($format, $segments, $request_type, $user_id) {
        $getpost = array('get', 'post');
        $method = '';
        if ((count($segments) == 2 && $segments[1] == 'list') || (count($segments) == 4 && $segments[1] == 'any' && $segments[2] == 'any' && $segments[3] == 'any')) {
            $method = $segments[0].'_list';
            $this->$method();
            return;
        }

        if ((count($segments) == 2 && is_numeric($segments[1]))) {
            $method = $segments[0].'_of_user';
            $this->$method($segments[1]);
            return;
        }

        if (count($segments) == 4 && in_array($request_type, $getpost)) {
            $method = $segments[0].'_get';
            $this->$method($segments[1], $segments[2], $segments[3]);
            return;
        }

        if (count($segments) == 3 && is_numeric($segments[2]) && $request_type == 'delete') {
            $method = $segments[0].'_delete';
            $this->$method($segments[1], $segments[2]);
            return;
        }

        if (count($segments) == 3 && is_numeric($segments[2]) && $request_type == 'post') {
            $method = $segments[0].'_do';
            $this->$method($segments[1], $segments[2]);
            return;
        }

        $this->returnError(100, $this->version, 450, implode($segments));
    }

    private function up_list() {
        $likes_res = $this->Like->get();
        if (is_array($likes_res) == false) {
            $this->returnError(701, $this->version);
            return;
        }

        $this->xmlContents('likes', $this->version, array('likes' => $likes_res));
    }
    
    private function down_list() {
        $dvotes_res = $this->Downvote->get();
        if (is_array($dvotes_res) == false) {
            $this->returnError(701, $this->version);
            return;
        }

        $this->xmlContents('downvotes', $this->version, array('downvotes' => $dvotes_res));
    }

    private function up_of_user($user_id) {
        $likes_res = $this->Like->getLikesByUser($user_id);
        if (is_array($likes_res) == false) {
            $this->returnError(702, $this->version);
            return;
        }
        $this->xmlContents('likes', $this->version, array('likes' => $likes_res));
    }

    private function down_of_user($user_id) {
        $dvotes_res = $this->Downvote->getDownvotesByUser($user_id);
        if (is_array($dvotes_res) == false) {
            $this->returnError(702, $this->version);
            return;
        }
        $this->xmlContents('downvotes', $this->version, array('downvotes' => $dvotes_res));
    }

    private function up_get($user_id, $knowledge_type, $knowledge_id) {
        $b = new stdClass();
        $b->key = "Exists";
        if ($user_id == 'any' && $knowledge_id == 'any') {
            $likes_res = $this->Like->getLikesByType($knowledge_type);
        } else if ($user_id == 'any') {
            $likes_res = $this->Like->getLikesByKnowledgePiece($knowledge_type, $knowledge_id);
        } else if ($knowledge_id == 'any') {
            $likes_res = $this->Like->getLikesByUserAndType($user_id, $knowledge_type);
        } else {
            $likes_res = $this->Like->getByIds($user_id, $knowledge_type, $knowledge_id);
        }
        if (is_array($likes_res) == false || count($likes_res) == 0) {
            $b->value = false;
        }else{
            $b->value = true;
        }
        $this->xmlContents('boolean',$this->version,$b);
    }
    
    

    private function down_get($user_id, $knowledge_type, $knowledge_id) {
        $b = new stdClass();
        $b->key = "Exists";
        if ($user_id == 'any' && $knowledge_id == 'any') {
            $dvotes_res = $this->Downvote->getDownvotesByType($knowledge_type);
        } else if ($user_id == 'any') {
            $dvotes_res = $this->Downvote->getDownvotesByKnowledgePiece($knowledge_type, $knowledge_id);
        } else if ($knowledge_id == 'any') {
            $dvotes_res = $this->Downvote->getDownvotesByUserAndType($user_id, $knowledge_type);
        } else {
            $dvotes_res = $this->Downvote->getByIds($user_id, $knowledge_type, $knowledge_id);
        }
        if (is_array($dvotes_res) == false || count($dvotes_res) == 0) {
            $b->value = false;
        }else{
            $b->value = true;
        }
        $this->xmlContents('boolean',$this->version,$b);
    }

    private function up_delete($knowledge_type, $knowledge_id) {
        $knowledge_name = $knowledge_type === 'd' ? "data" : ($knowledge_type === 'f' ? "flow" : ($knowledge_type === 't' ? "task" : ($knowledge_type === 'r' ? "run" : "")));
        if ($knowledge_name === "") {
            $this->returnError(711, $this->version);
            return;
        }else{
            $like = $this->Like->getByIds($this->user_id, $knowledge_type, $knowledge_id)[0];
            
            if ($like == false) {
                $this->returnError(703, $this->version);
                return;
            }

            $like_id = $like->lid;

            if ($like->user_id != $this->user_id) {
                $this->returnError(721, $this->version);
                return;
            }

            $result = $this->Like->delete($like_id);

            if ($result == false) {
                $this->returnError(704, $this->version);
                return;
            }

            $this->elasticsearch->delete('like', $like_id);

            // update counters
            $this->elasticsearch->index($knowledge_name, $knowledge_id);
            $this->elasticsearch->index('user', $this->user_id);

            $this->xmlContents('like', $this->version, $like);
        }
    }

    private function up_do($knowledge_type, $knowledge_id) {
        $knowledge_name = $knowledge_type === 'd' ? "data" : ($knowledge_type === 'f' ? "flow" : ($knowledge_type === 't' ? "task" : ($knowledge_type === 'r' ? "run" : "")));
        if($this->KnowledgePiece->getUploader($knowledge_type, $knowledge_id) == $this->user_id){
            $this->returnError(722, $this->version);
        }
        if ($knowledge_name === "") {
            $this->returnError(711, $this->version);
            return;
        } else {
            $lid = $this->Like->insertByIds($this->user_id, $knowledge_type, $knowledge_id);

            if (!$lid) {
                $this->returnError(705, $this->version);
                return;
            }

            // update elastic search index.
            $this->elasticsearch->index('like', $lid);


            // update counters
            $this->elasticsearch->index($knowledge_name, $knowledge_id);
            $this->elasticsearch->index('user', $this->user_id);

            $like = $this->Like->getById($lid);

            // create
            $this->xmlContents('like', $this->version, $like);
        }
    }

}

?>
