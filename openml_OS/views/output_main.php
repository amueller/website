<?php
  $info = explode('/', $_SERVER['REQUEST_URI']);
  $run_id = $info[array_search('r',$info)+1];
  $outputname = $info[array_search('output',$info)+1];
  echo $run_id;
  echo $outputname;

  $getParams = array();
  $getParams['index'] = 'openml';
  $getParams['type']  = 'run';
  $getParams['id']    = $run_id;
  $searchclient = $this->searchclient->get($getParams);
  $url = $searchclient['_source']['output_files'][$outputname];
  print_r($searchclient['_source']['output_files']);
  print_r($url);
  $urlparts = explode('/', $url);
  $outputid = $info[array_search('download',$urlparts)+1];
  $file = 'data/download/'.$outputid;

  if(file_exists($file))
	{
		header('Content-Type: text/plain');
		header('Content-Disposition: inline; filename='.basename($file));
		readfile($file);
		exit;
	}
  else{
	echo 'File available at '. $file;
	}
?>
