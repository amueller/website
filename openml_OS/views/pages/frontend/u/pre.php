<?php

$this->load_javascript = array('js/libs/jquery.dataTables.min.js');

if(false !== strpos($_SERVER['REQUEST_URI'],'/u/')) {
	$info = explode('/', $_SERVER['REQUEST_URI']);
	$this->id = $this->subpage;
	if(array_search('u',$info)+2 < count($info))
		$this->subpage = $info[array_search('u',$info)+2];
	$this->user_id = $this->id;
	$this->baseurl = $_SERVER['REQUEST_URI'];
	$this->author = $this->Author->getById($this->user_id);
	$this->activity_subpages = array('flows','data','runs');

	//get data from ES
	$this->p = array();
	$this->p['index'] = 'openml';
	$this->p['type'] = 'user';
	$this->p['id'] = $this->user_id;
	try{
		$this->userinfo = $this->searchclient->get($this->p)['_source'];
	} catch (Exception $e) {}

	$this->is_owner = false;
	if(($this->ion_auth->logged_in() and $this->ion_auth->user()->row()->id == $this->user_id) || $this->ion_auth->is_admin())
	   $this->is_owner = true;

	if(in_array($this->subpage,$this->activity_subpages)){
	 array_pop($info);
	 $this->baseurl = implode("/",$info);
	 if( $this->subpage == 'flows' ) {
	  $sql = 'SELECT SQL_CALC_FOUND_ROWS `i`.`id`, `i`.`name`, `i`.`version`, `i`.`external_version`, `r`.`runs`, '.
	         'IF(`r`.`runs` > 0,"",CONCAT("<i class=\\\\"fa fa-fw fa-times\\\\" onclick=\\\\"askConfirmation(",`i`.`id`,",\\\'",`i`.`name`,"\\\')\\\\"></i>")) AS `delete`, '.
	         'CONCAT("<a href=\\\\"f/", `i`.`id`, "\\\\">", `i`.`name`, "</a>") AS `name_link`' .
	         'FROM `implementation` `i` '.
	         'LEFT JOIN `algorithm_setup` `s` ON `i`.`id` = `s`.`implementation_id` '.
	         'LEFT JOIN (SELECT `setup`, count(*) AS `runs` FROM `run` GROUP BY `setup`) `r` ON `s`.`sid` = `r`.`setup` ' .
	         'WHERE `i`.`uploader` = "' . $this->user_id . '"';

	  $this->columns = array( 'delete', 'id', 'name_link', 'version', 'external_version', 'runs' );
	  $this->widths = array( 5, 5, 20, 5, 10, 5);
	  $this->sql = $sql;
	  $this->name = 'My flows';

	  $this->api_delete_function = array(
	    'function'        => 'openml.implementation.delete',
	    'key'             => 'implementation_id',
	    'filter'          => 'may_delete',
	    'id_field'        => 'id',
	    'identify_field'  => 'name' );

	 } elseif( $this->subpage == 'data' ) {

	  $sql = 'SELECT SQL_CALC_FOUND_ROWS `d`.`did`, `d`.`name`, `d`.`upload_date`, `d`.`format`, `t`.`tasks`, '.
	         'IF(`t`.`tasks` > 0,"",CONCAT("<i class=\\\\"fa fa-fw fa-times\\\\" onclick=\\\\"askConfirmation(",`d`.`did`,",\\\'",`d`.`name`,"\\\')\\\\"></i>")) AS `delete`, '.
	         'CONCAT("<a href=\\\\"d/", `d`.`did`, "\\\\">", `d`.`name`, "</a>") AS `name_link`' .
	         'FROM `dataset` `d` '.
	         'LEFT JOIN (SELECT `value` AS `did`, count(*) AS `tasks` FROM `task_inputs` WHERE `input` = "source_data" GROUP BY `value`) `t` ON d.did = t.did ' .
	         'WHERE `uploader` = "' . $this->user_id . '"';

	  $this->columns = array( 'delete', 'did', 'name_link', 'upload_date', 'format', 'tasks' );
	  $this->widths = array( 5, 5, 20, 10, 10, 5);
	  $this->sql = $sql;
	  $this->name = 'My data sets';

	  $this->api_delete_function = array(
	    'function'        => 'openml.data.delete',
	    'key'             => 'data_id',
	    'filter'          => 'may_delete',
	    'id_field'        => 'did',
	    'identify_field'  => 'name' );

	 } elseif( $this->subpage == 'runs' ) {

	  $sql = 'SELECT SQL_CALC_FOUND_ROWS `r`.`rid`,`r`.`start_time`,`r`.`task_id`,`r`.`status`, `r`.`error`, `d`.`name` AS `dataset`, `i`.`fullName` AS `flow`, '.
	         'CONCAT("<i class=\\\\"fa fa-fw fa-times\\\\" onclick=\\\\"askConfirmation(",`r`.`rid`,",\\\'run ",`r`.`rid`,"\\\')\\\\"></i>") AS `delete`, '.
	         'CONCAT("<a href=\\\\"r/", `r`.`rid`, "\\\\">", `r`.`rid`, "</a>") AS `name_link`, ' .
	         'CONCAT("Run ", `r`.`rid`) AS `name` ' .
	         'FROM `algorithm_setup` `s`, `implementation` `i`, `run` `r` ' .
	         'LEFT JOIN `task_inputs` `t` ON `r`.`task_id` = `t`.`task_id` AND `t`.`input` = "source_data" ' .
	         'LEFT JOIN `dataset` `d` ON `t`.`value` = `d`.`did` ' .
	         'WHERE `r`.`uploader` = ' . $this->user_id . ' ' .
	         'AND `r`.`setup` = `s`.`sid` AND `s`.`implementation_id` = `i`.`id` ';

	  $this->columns = array( 'delete', 'name_link', 'start_time', 'task_id', 'dataset', 'flow', 'status', 'error' );
	  $this->widths = array( 5, 5, 10, 10, 10, 10, 10, 10 );
	  $this->sql = $sql;
	  $this->name = 'My runs';


	  $this->api_delete_function = array(
	    'function'        => 'openml.run.delete',
	    'key'             => 'run_id',
	    'filter'          => 'may_delete',
	    'id_field'        => 'rid',
	    'identify_field'  => 'name' );
	}

	$this->sort = '[[1, \'desc\']]';
	$this->datatable = $this->dataoverview->generate_table(
    $this->name,
    $this->columns,
    $this->widths,
    $this->sql,
    $this->api_delete_function );
}

// PROFILE EDIT FORM
$this->message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
if (!$this->ion_auth->logged_in())
{
	sm('Please login first. ');
	redirect('frontend/page/login');
}
$this->user = $this->ion_auth->user()->row();
$this->load->library('elasticSearch');

if( $this->user->external_source != false ) {
	sm('Profile editing forbidden for social media users. ');
	redirect('frontend/page/home');
}


$this->emailField = array(
	'placeholder' => 'Change Email',
	'data-hint' => 'You will occasionally receive account related emails. We promise not to share your email with anyone.',
	'name' => 'email',
	'id' => 'email',
	'type' => 'email',
	'value' => $this->user->email,
);

$this->password_new = array(
	'placeholder' => 'New Password',
	'data-hint' => 'Your password needs at least 8 characters',
	'name' => 'password',
	'id' => 'password',
	'type' => 'password',
);

$this->password_confirm = array(
	'placeholder' => 'Confirm Password',
	'data-hint' => 'Enter your password again to avoid mistakes',
	'name' => 'password_confirm',
	'id' => 'password_confirm',
	'type' => 'password',
);

$this->password_old = array(
	'placeholder' => 'Current Password (if you want to change it)',
	'data-hint' => 'If you wish to change your password, please enter it first',
	'name' => 'password_old',
	'id' => 'password_old',
	'type' => 'password',
);


$this->first_name = array(
	'placeholder' => 'First name',
	'data-hint' => 'Using your real name helps you connect to your social network (and your publications).',
	'name' => 'first_name',
	'id' => 'first_name',
	'type' => 'text',
	'value' => $this->user->first_name,
);

$this->last_name = array(
	'placeholder' => 'Last name',
	'name' => 'last_name',
	'id' => 'last_name',
	'type' => 'text',
	'value' => $this->user->last_name,
);

$this->country = array(
	'placeholder' => 'Country',
	'name' => 'country',
	'id' => 'country',
	'type' => 'text',
	'value' => $this->user->country,
);

$this->bio = array(
  'placeholder' => 'Bio',
	'data-hint' => 'A short bio or catchphrase to let others know a little bit about you.',
	'name' => 'bio',
	'id' => 'bio',
	'type' => 'text',
	'value' => $this->user->bio,
);

$this->affiliation = array(
	'placeholder' => 'Affiliation',
	'data-hint' => 'The organization where you work. This may help you connect to interesting people.',
	'name' => 'affiliation',
	'id' => 'affiliation',
	'type' => 'text',
	'value' => $this->user->affiliation,
);

$this->image = array(
	'placeholder' => 'Upload picture...',
	'data-hint' => 'Upload a nice image or avatar.',
	'name' => 'image',
	'id' => 'image',
	'type' => 'file',
);

}


?>
