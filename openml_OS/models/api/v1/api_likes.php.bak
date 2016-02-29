<?php

class Api_likes extends Api_model {

    protected $version = 'v1';

    function __construct() {
        parent::__construct();

        // load models
        $this->load->model('Like');
    }

    function bootstrap($format, $segments, $request_type, $user_id) {
        $getpost = array('get', 'post');

        if ((count($segments) == 1 && $segments[0] == 'list') || (count($segments) == 3 && $segments[0] == 'any' && $segments[1] == 'any' && $segments[2] == 'any')) {
            $this->likes_list();
            return;
        }

        if ((count($segments) == 1 && is_numeric($segments[0]))) {
            $this->likes_of_user($segments[0]);
            return;
        }

        if (count($segments) == 3 && in_array($request_type, $getpost)) {
            $this->likes_get($segments[0], $segments[1], $segments[2]);
            return;
        }

        if (count($segments) == 2 && is_numeric($segments[1]) && $request_type == 'delete') {
            $this->like_delete($segments[0], $segments[1]);
            return;
        }

        if (count($segments) == 2 && is_numeric($segments[1]) && $request_type == 'post') {
            $this->like_do($segments[0], $segments[1]);
            return;
        }

        $this->returnError(100, $this->version, 450, implode($segments));
    }

    private function likes_list() {
        $likes_res = $this->Like->get();
        if (is_array($likes_res) == false || count($likes_res) == 0) {
            $this->returnError(370, $this->version);
            return;
        }

        $this->xmlContents('likes', $this->version, array('likes' => $likes_res));
    }

    private function likes_of_user($user_id) {
        $likes_res = $this->Like->getLikesByUser($user_id);
        if (is_array($likes_res) == false || count($likes_res) == 0) {
            $this->returnError(370, $this->version);
            return;
        }
        $this->xmlContents('likes', $this->version, array('likes' => $likes_res));
    }

    private function likes_get($user_id, $knowledge_type, $knowledge_id) {
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
            $this->returnError(370, $this->version);
            return;
        }
        $this->xmlContents('likes', $this->version, array('likes' => $likes_res));
    }

    private function like_delete($knowledge_type, $knowledge_id) {
        $knowledge_name = $knowledge_type === 'd' ? "data" : ($knowledge_type === 'f' ? "flow" : ($knowledge_type === 't' ? "task" : ($knowledge_type === 'r' ? "run" : "")));
        if ($knowledge_name === "") {
            $this->returnError(355, $this->version);
            return;
        }else{
            $like = $this->Like->getByIds($this->user_id, $knowledge_type, $knowledge_id)[0];

            $like_id = $like->lid;
            if ($like == false) {
                $this->returnError(352, $this->version);
                return;
            }

            if ($like->user_id != $this->user_id) {
                $this->returnError(353, $this->version, 450, implode(" ", $like));
                return;
            }

            $result = $this->Like->delete($like_id);

            if ($result == false) {
                $this->returnError(355, $this->version);
                return;
            }

            $this->elasticsearch->delete('like', $like_id);

            // update counters
            $this->elasticsearch->index($knowledge_name, $knowledge_id);
            $this->elasticsearch->index('user', $this->user_id);

            $this->xmlContents('like', $this->version, $like);
        }
    }

    private function like_do($knowledge_type, $knowledge_id) {
        $knowledge_name = $knowledge_type === 'd' ? "data" : ($knowledge_type === 'f' ? "flow" : ($knowledge_type === 't' ? "task" : ($knowledge_type === 'r' ? "run" : "")));
        if ($knowledge_name === "") {
            $this->returnError(134, $this->version);
            return;
        } else {
            $lid = $this->Like->insertByIds($this->user_id, $knowledge_type, $knowledge_id);

            if (!$lid) {
                $this->returnError(134, $this->version, 450, $lid);
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
