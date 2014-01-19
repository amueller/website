<?php
$this->type = html_entity_decode(gu('type'));
$this->name = html_entity_decode(gu('name'));
$this->record = false;
$this->displayName = false;
$this->active = 'search';

$this->measures = $this->Math_function->getColumnWhere('name','functionType = "EvaluationFunction"');
$this->current_measure = 'predictive_accuracy';

if($this->type == 'function'){
	$this->record = $this->Math_function->getById($this->name);
	$this->displayName = $this->record->name;
} else if($this->type == 'dataset') {
	$this->record = $this->Dataset->getWhere('name = "' . $this->name . '"');
	$this->record = $this->record[0];
	$this->displayName = $this->record->name;
	
	$this->dt_main 						= array();
	$this->dt_main['columns'] 			= array('img_open','rid','sid','i.fullName','algorithm','value');
	$this->dt_main['column_widths']		= array(10,0,0,30,30,30);
	$this->dt_main['column_content']	= array('<img src="img/datatables/details_open.png">',null,null,'<a href="detail/type/implementation/name/[CONTENT]">[CONTENT]</a>',null,null);
	$this->dt_main['column_source']		= array('content','db','db','wrapper','db','db');
	$this->dt_main['group_by'] 			= 'l.implementation_id';
	
	$this->dt_main['base_sql'] 		= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, `i`.`fullName`, `l`.`algorithm`, max(`e`.`value`) AS `value` ' .
										'FROM algorithm_setup `l`, evaluation `e`, cvrun `r`, dataset `d`, implementation `i` ' .
										'WHERE `r`.`learner`=`l`.`sid` ' .
										'AND `l`.`implementation_id` = `i`.`id` ' . 
										'AND `r`.`inputdata`=`d`.`did` ' .
										'AND `e`.`source`=`r`.`rid` ' .
										'AND `d`.`name`="'.$this->record->name.'"';
										
	$this->dt_main_all = array();
	$this->dt_main_all['columns'] 		= array('img_open','rid','sid','i.fullName','algorithm','value');
	$this->dt_main_all['column_content']= array('<img src="img/datatables/details_open.png">',null,null,'<a href="detail/type/implementation/name/[CONTENT]">[CONTENT]</a>',null,null);
	$this->dt_main_all['column_source']	= array('content','db','db','wrapper','db','db');
	//$this->dt_main_all['group_by'] 	= 'l.implementation'; NONE
	
	$this->dt_main_all['base_sql'] 	= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, `i`.`fullName`, `l`.`algorithm`, `e`.`value` AS `value` ' .
										'FROM algorithm_setup `l`, evaluation `e`, cvrun `r`, dataset `d`, implementation `i` ' .
										'WHERE `r`.`learner`=`l`.`sid` ' .
										'AND `r`.`inputdata`=`d`.`did` ' .
										'AND `l`.`implementation_id` = `i`.`id` ' . 
										'AND `e`.`source`=`r`.`rid` ' .
										'AND `d`.`name`="'.$this->record->name.'"';
	
	$this->dt_features = array();
	$this->dt_features['columns'] 		= array('index','name','data_type','NumberOfDistinctValues','NumberOfUniqueValues','NumberOfMissingValues','MaximumValue','MinimumValue','MeanValue','StandardDeviation');
	$this->dt_features['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_features['columns']) . '` FROM `data_feature` WHERE `did`="'.$this->record->did.'"';
	$this->dt_features['column_widths']	= array(0,15,15,10,10,10,10,10,10,10);
	
	$this->dt_qualities = array();
	$this->dt_qualities['columns'] 		= array('name','description','value');
	$this->dt_qualities['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_qualities['columns']) . '` FROM `data_quality`,`quality` WHERE `data_quality`.`quality` = `quality`.`name` AND `data_quality`.`data`="'.$this->record->did.'"';
	$this->dt_qualities['column_widths']	= array(25,50,25);
	
} else if($this->type == 'implementation') {
	$this->record = $this->Implementation->getByFullName($this->name);
	$this->displayName = $this->record->fullName;
	
	$this->dt_main['columns'] 			= array('img_open','rid','sid','name','value');
	$this->dt_main['column_widths']		= array(10,0,0,60,30);
	$this->dt_main['column_content']	= array('<img src="img/datatables/details_open.png">',null,null,'<a href="detail/type/dataset/name/[CONTENT]">[CONTENT]</a>',null);
	$this->dt_main['column_source'] 	= array('content','db','db','wrapper','db');
	
	$this->dt_main['base_sql'] 		= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`,d.name, e.value '.
										'FROM algorithm_setup l, evaluation e, cvrun r, dataset d  '.
										'WHERE r.learner=l.sid  '.
										'AND l.implementation_id="'.$this->record->id.'"  '.
										'AND l.isDefault="true"' . 
										'AND r.inputdata=d.did  '.
										'AND d.isOriginal="true"  '.
										'AND e.source=r.rid  ';
	
	$this->dt_params = array();
	$this->dt_params['columns'] 		= array('name', 'generalName', 'description', 'dataType', 'defaultValue', 'min', 'max');
	$this->dt_params['column_widths']	= array(10,20,30,10,10,10,10);
	$this->dt_params['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_params['columns']) . '` FROM input WHERE implementation_id ="'.$this->record->id.'" ';
	
	$this->dt_qualities = array();
	$this->dt_qualities['columns'] 		= array('name','description','value');
	$this->dt_qualities['column_widths']= array(25,50,25);
	$this->dt_qualities['base_sql']		= 'SELECT SQL_CALC_FOUND_ROWS `' . implode('`,`',$this->dt_qualities['columns']) . '` FROM `algorithm_quality`,`quality` WHERE `algorithm_quality`.`quality` = `quality`.`name` AND `algorithm_quality`.`implementation_id`="'.$this->record->id.'"';
	
} elseif($this->type == 'task') {
	$this->record = $this->Task->getByIdWithValues($this->name);
	$this->displayName = $this->record->name;
	
	$this->dt_main 						= array();
	$this->dt_main['columns'] 			= array('img_open','rid','sid','i.fullName','algorithm','value');
	$this->dt_main['column_widths']		= array(10,0,0,30,30,30);
	$this->dt_main['column_content']	= array('<img src="img/datatables/details_open.png">',null,null,'<a href="detail/type/implementation/name/[CONTENT]">[CONTENT]</a>',null,null);
	$this->dt_main['column_source']		= array('content','db','db','wrapper','db','db');
	$this->dt_main['group_by'] 			= 'l.implementation_id';
	
	$this->dt_main['base_sql'] 		= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, `i`.`fullName`, `l`.`algorithm`, max(`e`.`value`) AS `value` ' .
										'FROM algorithm_setup `l`, evaluation `e`, cvrun `r`, `implementation` `i` ' .
										'WHERE `r`.`learner`=`l`.`sid` ' .
										'AND `e`.`source`=`r`.`rid` ' .
                    'AND `l`.`implementation_id` = `i`.`id` ' .
										'AND `r`.`task_id`="'.$this->record->task_id.'"';
										
	$this->dt_main_all = array();
	$this->dt_main_all['columns'] 		= array('img_open','rid','sid','i.fullName','algorithm','value');
	$this->dt_main_all['column_content']= array('<img src="img/datatables/details_open.png">',null,null,'<a href="detail/type/implementation/name/[CONTENT]">[CONTENT]</a>',null,null);
	$this->dt_main_all['column_source']	= array('content','db','db','wrapper','db','db');
	//$this->dt_main_all['group_by'] 	= 'l.implementation'; NONE
	
	$this->dt_main_all['base_sql'] 	= 	'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`, `l`.`sid`, `i`.`fullName`, `l`.`algorithm`, `e`.`value` AS `value` ' .
										'FROM algorithm_setup `l`, evaluation `e`, cvrun `r`, `implementation` `i` ' .
										'WHERE `r`.`learner`=`l`.`sid` ' .
										'AND `e`.`source`=`r`.`rid` ' .
                    'AND `l`.`implementation_id` = `i`.`id` ' .
										'AND `r`.`task_id`="'.$this->record->task_id.'"';
} else {
	// fall into the "record == false" section
}


if($this->record == false ) {
	$this->displayName = 'Detail';
	$this->type = 'all';

	$datasets = $this->Dataset->getColumnsWhere('`name`, `name` AS `id`,"dataset" AS `type`','`isOriginal` = "true"', '`name` ASC'); 
	$implementations = $this->Implementation->getColumns('`fullName` AS `name`,`fullName` AS `id`,"implementation" AS `type`','`fullName` ASC'); 
	$functions = $this->Math_function->getColumnsWhere('`name`, `name` AS `id`,"function" AS `type`','`functionType` = "EvaluationFunction"', '`name` ASC');
	$tasks = $this->Task->getWithValues();
	
	$this->results = array_merge($datasets,$implementations,$functions,$tasks);
	
	usort( $this->results, 'sortByName' ) ;
}

?>
