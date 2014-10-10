<?php

/// SEARCH
$this->filtertype = 'task';
$this->sort = 'runs';
if($this->input->get('sort'))
	$this->sort = safe($this->input->get('sort'));


$this->active_tab = gu('tab');
if($this->active_tab == false) $this->active_tab = 'searchtab';

// task types
$this->tasktypes =  array();
$types = $this->Implementation->query('SELECT tt.ttid, tt.name, tt.description, count(t.task_id) as tasks FROM task_type tt left join task t on t.ttid=tt.ttid group by tt.ttid order by tasks desc');
if( $types != false ) {
	  foreach( $types as $i ) {
		  $result = array(
			  'id' => $i->ttid,
			  'name' => $i->name,
			  'description' => $i->description,
			  'tasks' => $i->tasks
		  );
		  $this->tasktypes[] = $result;
	  }
}


/// TYPE DETAIL

$this->record = array();
$this->taskio = array();

if(false !== strpos($_SERVER['REQUEST_URI'],'/t/type') || false !== strpos($_SERVER['REQUEST_URI'],'/t/search/type')) {
	$this->id = explode("?",end(explode('/', $_SERVER['REQUEST_URI'])))[0];
	$type = $this->Implementation->query('SELECT * FROM task_type WHERE ttid=' . $this->id );
	if( $type != false ) {
		$this->record = array(
			  'id' => $type[0]->ttid,
			  'name' => $type[0]->name,
			  'description' => $type[0]->description,
			  'authors' => $type[0]->creator,
			  'contributors' => $type[0]->contributors
			);

	$io = $this->Implementation->query('SELECT i.name, i.description, i.type, i.io, i.requirement, t.description as typedescription  FROM task_type_inout i left join task_io_types t on i.type = t.name WHERE requirement <> "hidden" AND ttid=' . $this->id );
	if( $io != false ) {
	  foreach( $io as $i ) {
		$inout = array(
			  'name' => $i->name,
			  'description' => $i->description,
			  'typedescription' => $i->typedescription,
			  'type' => $i->type,
			  'category' => $i->io,
			  'requirement' => $i->requirement
			);
		$this->taskio[] = $inout;
	  }
	}
	}
}

if(false === strpos($_SERVER['REQUEST_URI'],'type') && false !== strpos($_SERVER['REQUEST_URI'],'/t/')) {

	$info = explode('/', $_SERVER['REQUEST_URI']);
	$this->task_id = $info[array_search('t',$info)+1];
}
// evaluations
$this->current_measure = 'predictive_accuracy';
$this->allmeasures = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');

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
?>
