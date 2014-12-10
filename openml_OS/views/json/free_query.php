<?php 
echo '{"status": ' . json_encode($this->myStatus);
if(isset($this->id)) echo ',"id": '.json_encode($this->id);
if ($this->error){ 
	echo '}';
	return;
} else{
	echo ',"time": '.json_encode($this->msc).',';
}
echo '"columns": '.json_encode($this->columns).',';
echo '"query": '.json_encode($this->query).',';
echo '"data": '.json_encode($this->rows).'}';
?>
