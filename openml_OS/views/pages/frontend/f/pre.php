<?php

/// SEARCH
$this->filtertype = 'flow';
$this->sort = 'runs';
if($this->input->get('sort'))
	$this->sort = safe($this->input->get('sort'));

/// DETAIL

$this->type = 'implementation';
$this->record = false;
$this->displayName = false;
$this->allmeasures = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');
$this->current_measure = 'predictive_accuracy';
$this->current_task = 1;


if(false !== strpos($_SERVER['REQUEST_URI'],'/f/')) {
	$this->id = end(explode('/', $_SERVER['REQUEST_URI']));
	$this->record = $this->Implementation->getByID($this->id);
	$this->displayName = $this->record->fullName;
	
	$this->dt_main['columns'] 		= array('r.rid','rid','sid','name','value');
	$this->dt_main['column_widths']		= array(1,1,0,60,30);
	$this->dt_main['column_content']	= array('<a data-toggle="modal" data-id="[CONTENT]" data-target="#runModal" class="openRunModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="d/[CONTENT1]">[CONTENT2]</a>',null);
	$this->dt_main['column_source'] 	= array('wrapper','db','db','doublewrapper','db');
	$this->dt_main['base_sql'] 		= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, concat(d.did, "~", d.name) as name, round(e.value,4) as value '.
										'FROM algorithm_setup l, evaluation e, run r, input_data rd, dataset d '.
										'WHERE r.setup=l.sid  '.
										'AND l.implementation_id="'.$this->record->id.'"  '.
										'AND l.isDefault="true"' . 
										'AND r.rid=rd.data  '.
                    'AND rd.data = d.did ' .
										'AND e.source=r.rid  ';

	$this->dt_main_all['columns'] 		= array('r.rid','rid','sid','name','value');
	$this->dt_main_all['column_widths']		= array(1,1,0,60,30);
	$this->dt_main_all['column_content']	= array('<a data-toggle="modal" data-id="[CONTENT]" data-target="#runModal" class="openRunModal"><i class="fa fa-info-circle"></i></a>',null,null,'<a href="d/[CONTENT1]">[CONTENT2]</a>',null);
	$this->dt_main_all['column_source'] 	= array('wrapper','db','db','doublewrapper','db');
	
	$this->dt_main_all['base_sql'] 		= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, concat(d.did, "~", d.name) as name, round(e.value,4) as value '.
										'FROM algorithm_setup l, evaluation e, run r, input_data rd, dataset d  '.
										'WHERE r.setup=l.sid  '.
										'AND l.implementation_id="'.$this->record->id.'"  '.
										'AND r.rid=rd.data  '.
                    'AND rd.data = d.did ' .
										'AND e.source=r.rid  ';

	$this->dt_params = array();
	$this->dt_params['columns'] 		= array('name', 'generalName', 'defaultValue', 'min', 'max');
	$this->dt_params['column_widths']	= array(10,20,30,10,10,10,10);
	$this->dt_params['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_params['columns']) . '` FROM input WHERE implementation_id ="'.$this->record->id.'" ';
	
	$this->dt_qualities = array();
	$this->dt_qualities['columns'] 		= array('name','description','value');
	$this->dt_qualities['column_widths']= array(25,50,25);
	$this->dt_qualities['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_qualities['columns']) . '` FROM `algorithm_quality`,`quality` WHERE `algorithm_quality`.`quality` = `quality`.`name` AND `algorithm_quality`.`implementation_id`="'.$this->record->id.'"';


	
}

function cleanName($string){
	return $safe = preg_replace('/^-+|-+$/', '', strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $string)));
}

?>
