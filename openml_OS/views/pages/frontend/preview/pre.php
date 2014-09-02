<?php

$postdata = http_build_query($_POST);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

$result = file_get_contents('http://localhost:4567/preview', false, $context);

$preamble = '<span class="label label-danger" style="font-weight:200">This is a preview. Changes are not yet saved.</span><br><br>';

preg_match('/<body>(.*)<\/body>/s',$result,$content_arr);
$this->wikiwrapper = $preamble . str_replace('body>','div>',$content_arr[0]);

?>
