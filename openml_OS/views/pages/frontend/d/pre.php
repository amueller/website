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
    $this->info = explode('/', $_SERVER['REQUEST_URI']);
    $this->id = explode('?',$this->info[array_search('d',$this->info)+1])[0];
    if(!$this->id) { su('d'); }

    //wiki
    $this->wikipage = 'data-'.$this->id;
  }

  function cleanName($string){
    return $safe = preg_replace('/^-+|-+$/', '', strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $string)));
  }

  ?>
