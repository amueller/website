  <?php

  //$this->load_javascript = array('js/libs/highcharts.js','js/libs/highcharts-more.js','js/libs/modules/exporting.js','js/libs/jquery.dataTables.min.js','js/libs/dataTables.tableTools.min.js','js/libs/dataTables.scroller.min.js','js/libs/dataTables.responsive.min.js','js/libs/dataTables.colVis.min.js');
  $this->load_javascript = array('js/libs/mousetrap.min.js','js/libs/gollum.js','js/libs/highcharts.js','js/libs/jquery.dataTables.min.js');
  $this->load_css = array('css/gollum.css');

  //Redirect to search if bad url
  $this->activetab = 'overview';
  if(false === strpos($_SERVER['REQUEST_URI'],'/d/')) {
    header('Location: search?type=data');
    exit();
  } elseif(false !== strpos($_SERVER['REQUEST_URI'],'/update')) {
    $this->activetab = 'update';
  }

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

  $this->showallfeatures = false;
  if(($this->input->get('show') and $this->input->get('show') == 'all') or false !== strpos($_SERVER['REQUEST_URI'],'/update'))
  	$this->showallfeatures = true;

  $this->displayName = false;
  $this->allmeasures = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');
  $this->current_measure = 'predictive_accuracy';

  // Making sure we know who is editing
  $this->editor = 'Anonymous';
  $this->is_owner = false;
  $this->editing = false;
  if(false !== strpos($_SERVER['REQUEST_URI'],'/edit')){
    if (!$this->ion_auth->logged_in()) {
    header('Location: ' . BASE_URL . 'login');
    exit();
    }
    else{
    $user = $this->Author->getById($this->ion_auth->user()->row()->id);
    $this->editor = $user->first_name . ' ' . $user->last_name;
    $this->editing = true;
    }
  }
  $this->user_id = -1;
  if ($this->ion_auth->logged_in()) {
    $this->user_id = $this->ion_auth->user()->row()->id;
  }

  if(false !== strpos($_SERVER['REQUEST_URI'],'/d/') and false === strpos($_SERVER['REQUEST_URI'],'/d/script')) {
    $info = explode('/', $_SERVER['REQUEST_URI']);
    $this->id = explode('?',$info[array_search('d',$info)+1])[0];
    if(!$this->id) { su('d'); }

    //get data from ES
    $this->p = array();
    $this->p['index'] = 'openml';
    $this->p['type'] = 'data';
    $this->p['id'] = $this->id;
    try{
      $this->data = $this->searchclient->get($this->p)['_source'];
    } catch (Exception $e) {}

    //get other versions -> do in javascript?
    $this->p2 = array();
    $this->p2['index'] = 'openml';
    $this->p2['type'] = 'data';
    $this->p2['body']['_source'] = array("data_id", "version", "version_label");
    $this->p2['body']['query']['term']['exact_name'] = $this->data['name'];
    $this->p2['body']['sort'] = 'version';
    try{
      $this->versions = array_column($this->searchclient->search($this->p2)['hits']['hits'],'_source');
    } catch (Exception $e) {}

    //get tasks
    $this->p3 = array();
    $this->p3['index'] = 'openml';
    $this->p3['type'] = 'task';
    $this->p3['body']['filter']['term']['source_data.data_id'] = $this->id;
    try{
      $this->tasks = array_column($this->searchclient->search($this->p3)['hits']['hits'],'_source');
    } catch (Exception $e) {}

    //get measures
    $this->p4 = array();
    $this->p4['index'] = 'openml';
    $this->p4['type'] = 'measure';
    $this->p4['body']['size'] = 1000;
    $this->p4['body']['query']['filtered']['query']['match_all'] = array();
    $this->p4['body']['query']['filtered']['filter']['term']['type'] = "data_quality";
    $this->p4['body']['sort'] = array('priority','name');
    try {
      $this->dataproperties = array_column($this->searchclient->search($this->p4)['hits']['hits'],'_source');
    } catch (Exception $e) {}


    // block unauthorized access
    $this->blocked = false;
    if($this->data['visibility'] == 'private' and (!$this->ion_auth->logged_in() or $this->ion_auth->user()->row()->id != $this->data['uploader_id'])){
      $this->blocked = true;
    } else {

    if(($this->ion_auth->logged_in() and $this->ion_auth->user()->row()->id == $this->data['uploader_id']) || $this->ion_auth->is_admin())
      $this->is_owner = true;

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

    // datatables -> can we do without?
    $this->dt_main = array();
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
    $this->dt_features['base_sql']    = 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_features['columns']) . '` FROM `data_feature` WHERE `did`="'.$this->id.'"';
    $this->dt_features['column_widths']  = array(0,15,15,10,10,10,10,10,10,10);

    $this->dt_qualities = array();
    $this->dt_qualities['columns']     = array('name','description','value');
    $this->dt_qualities['base_sql']    = 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_qualities['columns']) . '` FROM `data_quality`,`quality` WHERE `data_quality`.`quality` = `quality`.`name` AND `data_quality`.`data`="'.$this->id.'"';
    $this->dt_qualities['column_widths']  = array(25,50,25);

    //wiki import -> can we do this async?
    $this->wikipage = str_replace('_','-',$this->data['name'].'-'.$this->data['version']);
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
      $this->wikiwrapper = '<div class="rawtext">'.$this->data['description'].'</div>';
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

  ?>
