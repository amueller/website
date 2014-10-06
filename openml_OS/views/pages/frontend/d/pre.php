<?php

/// SEARCH
$this->filtertype = 'data';
$this->sort = 'runs';
if($this->input->get('sort'))
  $this->sort = safe($this->input->get('sort'));

/// UPDATE
$this->responsetype = '';
$this->response = '';

/// DETAIL
$this->type = 'dataset';
$this->record = false;

$this->showallfeatures = false;
if(($this->input->get('show') and $this->input->get('show') == 'all') or false !== strpos($_SERVER['REQUEST_URI'],'/update'))
	$this->showallfeatures = true;

$this->displayName = false;
$this->allmeasures = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');
$this->current_measure = 'predictive_accuracy';

// Making sure we know who is editing
$this->editor = 'Anonymous';
$this->is_owner = false;
if(false !== strpos($_SERVER['REQUEST_URI'],'/edit')){
  if (!$this->ion_auth->logged_in()) {
  header('Location: ' . BASE_URL . 'login');
  }
  else{
  $user = $this->Author->getById($this->ion_auth->user()->row()->id);
  $this->editor = $user->first_name . ' ' . $user->last_name;
  }
}

if(false !== strpos($_SERVER['REQUEST_URI'],'/d/')) {
  $info = explode('/', $_SERVER['REQUEST_URI']);
  $this->id = explode('?',$info[array_search('d',$info)+1])[0];

  if(!$this->id) { su('d'); }
  $prev = $this->Dataset->getColumnFunctionWhere('max(did)', 'did < '.$this->id.' AND visibility="public"');
  $this->prev_id = $prev[0];
  $next = $this->Dataset->getColumnFunctionWhere('min(did)', 'did > '.$this->id.' AND visibility="public"');
  $this->next_id = $next[0];
  
  $this->record = $this->Dataset->getWhere('did = "' . $this->id . '"');
  $this->record = $this->record[0];
  if(!$this->record->{'did'}) { su('d/'.$this->next_id); }
  
  // block unauthorized access
  $this->blocked = false; 
  if($this->record->visibility == 'private' and (!$this->ion_auth->logged_in() or $this->ion_auth->user()->row()->id != $this->record->uploader)){
    $this->blocked = true; 
  } else {

  if(($this->ion_auth->logged_in() and $this->ion_auth->user()->row()->id == $this->record->uploader) || $this->ion_auth->is_admin())
    $this->is_owner = true;

  $author = $this->Author->getById($this->record->uploader);
  $this->record->{'uploader'} =  $author->first_name . ' ' . $author->last_name;
  $this->uploader_id = $author->id;
  $this->displayName = $this->record->name;
  $this->tasks_all = array();
  $this->current_task = false;

  $this->versions = $this->Dataset->getAssociativeArray('did', 'version', 'name = "'.$this->record->name.'"');
  ksort($this->versions);

  // tasks
  $this->tasks = $this->Dataset->query('SELECT t.task_id, tt.name FROM task_type_inout ttio, task_inputs ti, task t, task_type tt WHERE ttio.type=\'Dataset\' and ttio.name = ti.input and ti.value=' . $this->id . ' and ti.task_id=t.task_id and t.ttid = tt.ttid and ttio.ttid=tt.ttid');
    if( $this->tasks != false ) {
    foreach( $this->tasks as $t ) {
      $result = array(
        'id' => $t->task_id,
        'name' => $t->name
      );
      $this->tasks_all[] = $result;
      if($this->current_task == false){
      $this->current_task = $t->task_id;
      }
      }
  }

  // properties
  $this->properties = $this->Implementation->query("SELECT aq.quality, q.description, aq.value, q.showonline from data_quality aq, quality q where aq.quality=q.name and data=" . $this->record->{'did'} . " order by quality asc");
  $nrfeats = $this->Implementation->query("SELECT value from data_quality where quality='NumberOfFeatures' and data=" . $this->record->{'did'});
  if($nrfeats){
  	$this->nrfeatures = $nrfeats[0]->{'value'};
  } else {
	$this->nrfeatures = 0;
  }
  
  // features
  $this->targetfeatures = $this->Dataset->query("SELECT name, `index`, data_type, is_target, is_row_identifier, is_ignore, NumberOfDistinctValues, NumberOfMissingValues, MinimumValue, MaximumValue, MeanValue, StandardDeviation, ClassDistribution FROM `data_feature` WHERE is_target='true' and did=" . $this->record->{'did'});
  $this->features = $this->Dataset->query("SELECT name, `index`, data_type, is_target, is_row_identifier, is_ignore, NumberOfDistinctValues, NumberOfMissingValues, MinimumValue, MaximumValue, MeanValue, StandardDeviation, ClassDistribution FROM `data_feature` WHERE is_target='false' and did=" . $this->record->{'did'} . ($this->showallfeatures ? "" : " limit 0,100"));
  if($this->targetfeatures)
	$this->features = array_merge($this->targetfeatures,$this->features);
  if($this->nrfeatures > count($this->features))
	$this->highFeatureCount = true;
  $this->classvalues = array();
  if($this->targetfeatures){
    foreach( $this->targetfeatures as $r ) {
      if($r->{'data_type'} == "nominal") {
        $classvalues = json_decode($r->{'ClassDistribution'});      
        $this->classvalues = $classvalues[0];
      }
    }
  } else { // find out what's wrong
     $this->feature_error = $this->Dataset->query("SELECT error_message FROM dataset WHERE did=" . $this->record->{'did'})[0]->{'error_message'};
  }


  // licences
  $this->licences = array();
  $this->licences['Public'] = array( "name" => 'Publicly available', "url" => 'https://creativecommons.org/choose/mark/' );
  $this->licences['CC_BY'] = array( "name" => 'Attribution (CC BY)', "url" => 'http://creativecommons.org/licenses/by/4.0/' );
  $this->licences['CC_BY-SA'] = array( "name" => 'Attribution-ShareAlike (CC BY-SA)', "url" => 'http://creativecommons.org/licenses/by-sa/4.0/' );
  $this->licences['CC_BY-ND'] = array( "name" => 'Attribution-NoDerivs (CC BY-ND)', "url" => 'http://creativecommons.org/licenses/by-nd/4.0/' );
  $this->licences['CC_BY-NC'] = array( "name" => 'Attribution-NonCommercial (CC BY-NC)', "url" => 'http://creativecommons.org/licenses/by-nc/4.0/' );
  $this->licences['CC_BY-NC-SA'] = array( "name" => 'Attribution-NonCommercial-ShareAlike (CC BY-NC-SA)', "url" => 'http://creativecommons.org/licenses/by-nc-sa/4.0/' );
  $this->licences['CC-BY-NC-ND'] = array( "name" => 'Attribution-NonCommercial-NoDerivs (CC BY-NC-ND)', "url" => 'http://creativecommons.org/licenses/by-nc-nd/4.0/' );
  $this->licences['CC0'] = array( "name" => 'Public Domain (CC0)', "url" => 'http://creativecommons.org/about/cc0' );


  // datatables
  $this->dt_main         = array();
  $this->dt_main['columns']     = array('r.rid','rid','sid','fullName','value');
  $this->dt_main['column_widths']    = array(1,1,0,30,30);
  $this->dt_main['column_content']  = array('<a data-toggle="modal" href="r/[CONTENT]/html" data-target="#runModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="f/[CONTENT1]">[CONTENT2]</a>',null,null);
  $this->dt_main['column_source']    = array('wrapper','db','db','doublewrapper','db','db');
  $this->dt_main['group_by']     = 'l.implementation_id';
  
  $this->dt_main['base_sql']     =   'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, concat(`i`.`id`, "~", `i`.`fullName`) as fullName, round(max(`e`.`value`),4) AS `value` ' .
                    'FROM algorithm_setup `l`, evaluation `e`, run `r`, implementation `i` ' .
                    'WHERE `r`.`setup`=`l`.`sid` ' .
                    'AND `l`.`implementation_id` = `i`.`id` ' . 
                    'AND `e`.`source`=`r`.`rid` ';
                    
  $this->dt_main_all = array();
  $this->dt_main_all['columns']     = array('r.rid','rid','sid','fullName','value');
  $this->dt_main_all['column_content']= array('<a data-toggle="modal" href="r/[CONTENT]/html" data-target="#runModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="f/[CONTENT1]">[CONTENT2]</a>',null,null);
  $this->dt_main_all['column_source']  = array('wrapper','db','db','doublewrapper','db','db');
  //$this->dt_main_all['group_by']   = 'l.implementation'; NONE
  
  $this->dt_main_all['base_sql']   =   'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, concat(`i`.`id`, "~", `i`.`fullName`) as fullName, round(`e`.`value`,4) AS `value` ' .
                    'FROM algorithm_setup `l`, evaluation `e`, run `r`, implementation `i` ' .
                    'WHERE `r`.`setup`=`l`.`sid` ' .
                    'AND `l`.`implementation_id` = `i`.`id` ' . 
                    'AND `e`.`source`=`r`.`rid` ';
  
  $this->dt_features = array();
  $this->dt_features['columns']     = array('index','name','data_type','NumberOfDistinctValues','NumberOfUniqueValues','NumberOfMissingValues','MaximumValue','MinimumValue','MeanValue','StandardDeviation');
  $this->dt_features['base_sql']    = 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_features['columns']) . '` FROM `data_feature` WHERE `did`="'.$this->record->did.'"';
  $this->dt_features['column_widths']  = array(0,15,15,10,10,10,10,10,10,10);
  
  $this->dt_qualities = array();
  $this->dt_qualities['columns']     = array('name','description','value');
  $this->dt_qualities['base_sql']    = 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_qualities['columns']) . '` FROM `data_quality`,`quality` WHERE `data_quality`.`quality` = `quality`.`name` AND `data_quality`.`data`="'.$this->record->did.'"';
  $this->dt_qualities['column_widths']  = array(25,50,25);  

  //wiki import
  $this->wikipage = str_replace('_','-',$this->displayName.'-'.$this->record->version);
  $this->wikipage = str_replace('.','-dot-',$this->wikipage);
  $this->wikipage = str_replace('(','-',$this->wikipage);
  $this->wikipage = str_replace(')','-',$this->wikipage);
  $this->wikipage = str_replace(',','-',$this->wikipage);
  $this->wikipage = str_replace('--','-',$this->wikipage);

  $url = $this->wikipage;
  $this->show_history = true;

  $preamble = '';
  if(end($info) == 'edit')
    $url = 'edit/'.$this->wikipage;
  elseif(end($info) == 'history')
    $url = 'history/'.$this->wikipage;
  elseif(in_array('compare',$info)){
    $p = $this->input->post('versions');
    $url = 'compare/'.$this->wikipage.'/'.$p[0].'...'.$p[1];}
  elseif(in_array('view',$info)){
    $url = $this->wikipage.'/'.end($info);
    $preamble = '<span class="label label-danger" style="font-weight:200">You are viewing version: '.end($info).'</span><br><br>';}
  elseif(end($info) == 'preview')
    $url = 'preview';
  else
    $this->show_history = false;

  $this->wiki_ok = true;
  $html = @file_get_contents('http://localhost:4567/'.$url);
  
  if($html){ //check if Gollum working and not trying to create new page
    preg_match('/<body>(.*)<\/body>/s',$html,$content_arr);
    $this->wikiwrapper = $preamble . str_replace('body>','div>',$content_arr[0]);
    $this->wikiwrapper = str_replace('action="/edit/'.$this->wikipage.'"','',$this->wikiwrapper);
  } else { //failsafe
    $this->wikiwrapper = '<div class="rawtext">'.$this->record->{'description'}.'</div>';
    $this->wiki_ok = false;
  }

  //crop long descriptions
  $this->hidedescription = false;
  if(strlen($this->wikiwrapper)>400 and $url==$this->wikipage and strlen($preamble)==0)
    $this->hidedescription = true;
  }
}


function cleanName($string){
  return $safe = preg_replace('/^-+|-+$/', '', strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $string)));
}

//temp fix -> included in php 5.5
if (!function_exists('array_column')) {

    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();

        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }

        if (!is_array($params[0])) {
            trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
            return null;
        }

        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;

        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }

        $resultArray = array();

        foreach ($paramsInput as $row) {

            $key = $value = null;
            $keySet = $valueSet = false;

            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }

            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }

            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }

        }

        return $resultArray;
    }

}


?>
