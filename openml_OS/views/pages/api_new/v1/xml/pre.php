<?php
// for function: openml.global
$this->apiErrors[100] = 'Function not valid';
$this->apiErrors[101] = 'Function not yet ported or implemented';
$this->apiErrors[102] = 'No authentication';
$this->apiErrors[103] = 'Authentication failed';
$this->apiErrors[104] = 'This is a read-only account, not the right permissions to execute a write operation. ';


// for function: openml.data.description
$this->apiErrors[110] = 'Please provide data_id';
$this->apiErrors[111] = 'Unknown dataset';
$this->apiErrors[112] = 'No access granted';

// for function: openml.data.upload
$this->apiErrors[130] = 'Problem with file uploading';
$this->apiErrors[131] = 'Problem validating uploaded description file';
$this->apiErrors[132] = 'Failed to move the files';
$this->apiErrors[133] = 'Failed to make checksum of datafile';
$this->apiErrors[134] = 'Failed to insert record in database';
$this->apiErrors[135] = 'Please provide description xml';
$this->apiErrors[136] = 'File failed format verification. The uploaded file is not valid according to the selected file format. Please check the file format specification and try again.';
$this->apiErrors[137] = 'Please provide API key';
$this->apiErrors[138] = 'Authentication failed';
$this->apiErrors[139] = 'Combination name / version already exists';
$this->apiErrors[140] = 'Both dataset file and dataset url provided. Please provide only one';
$this->apiErrors[141] = 'Neither dataset file or dataset url are provided';
$this->apiErrors[142] = 'Error in processing arff file. Can be a syntax error, or the specified target feature does not exists';
$this->apiErrors[143] = 'Suggested target feature not legal ';
$this->apiErrors[144] = 'Unable to update dataset ';
$this->apiErrors[145] = 'Error parsing dataset ARFF file';


// for function: openml.tasks.search
$this->apiErrors[150] = 'Please provide task_id';
$this->apiErrors[151] = 'Unknown task';

// for function: openml.flow.upload
$this->apiErrors[160] = 'Error in file uploading';
$this->apiErrors[161] = 'Please provide description xml';
$this->apiErrors[162] = 'Please provide source or binary file';
$this->apiErrors[163] = 'Problem validating uploaded description file';
$this->apiErrors[164] = 'flow already stored in database';
$this->apiErrors[165] = 'Failed to insert flow';
$this->apiErrors[166] = 'Failed to add flow to database';
$this->apiErrors[167] = 'Illegal files uploaded';
$this->apiErrors[168] = 'The provided md5 hash equals not the server generated md5 hash of the file';
$this->apiErrors[169] = 'Please provide API key';
$this->apiErrors[170] = 'Authentication failed';
$this->apiErrors[171] = 'flow already exists';
$this->apiErrors[172] = 'Xsd not found';

// for function: openml.flow.get
$this->apiErrors[180] = 'Please provide flow_id';
$this->apiErrors[181] = 'Unknown flow';


// for function: openml.run.upload
$this->apiErrors[202] = 'Please provide run xml';
$this->apiErrors[203] = 'Could not validate run xml by xsd';
$this->apiErrors[204] = 'Unknown task';
$this->apiErrors[205] = 'Unknown flow';
$this->apiErrors[206] = 'Invalid file type uploaded';
$this->apiErrors[207] = 'File upload failed';
$this->apiErrors[208] = 'Error inserting setup record';
$this->apiErrors[209] = 'Error parsing uploaded file. ';
$this->apiErrors[210] = 'Unable to store run';
$this->apiErrors[211] = 'Dataset not in databse';
$this->apiErrors[212] = 'Unable to store file';
$this->apiErrors[213] = 'Parameter in run xml unknown';
$this->apiErrors[214] = 'Unable to store input setting';
$this->apiErrors[215] = 'Unable to evaluate predictions';
$this->apiErrors[216] = 'Error thrown by Java Application';
$this->apiErrors[217] = 'Error processing output data: unknown or inconsistent evaluation measure';
$this->apiErrors[218] = 'Wrong flow associated with run: this implements a math_function';
$this->apiErrors[219] = 'Error reading the XML document';

// for function: openml.run.get
$this->apiErrors[220] = 'Please provide run_id';
$this->apiErrors[221] = 'Run not found';

// range from 225 - 239: api run

// for function: openml.tasks.type.search
$this->apiErrors[240] = 'Please provide task_type_id';
$this->apiErrors[241] = 'Unknown task type';

// for function: openml.authenticate
$this->apiErrors[250] = 'Please provide username';
$this->apiErrors[251] = 'Please provide password';
$this->apiErrors[252] = 'Authentication failed';

// for function: openml.data.features
$this->apiErrors[270] = 'Please provide data_id';
$this->apiErrors[271] = 'Unknown dataset';
$this->apiErrors[272] = 'No features found';
$this->apiErrors[273] = 'Dataset not processed yet';
$this->apiErrors[274] = 'Dataset processed with error';

// for function: openml.setup.parameters
$this->apiErrors[280] = 'Please provide setup_id';
$this->apiErrors[281] = 'Unknown setup';

// for function: openml.authenticate.check
$this->apiErrors[290] = 'Username not provided';
$this->apiErrors[291] = 'Hash not provided';
$this->apiErrors[292] = 'Hash does not exist';

// for function: openml.task.results
$this->apiErrors[300] = 'Please provide task_id';
$this->apiErrors[301] = 'Unknown task';

// for function: openml.flow.owned
$this->apiErrors[310] = 'Please provide API key';
$this->apiErrors[311] = 'Authentication failed';
$this->apiErrors[312] = 'No flows owned by this used';

// for function: openml.flow.delete
$this->apiErrors[320] = 'Please provide API key';
$this->apiErrors[321] = 'Authentication failed';
$this->apiErrors[322] = 'flow does not exists';
$this->apiErrors[323] = 'flow is not owned by you';
$this->apiErrors[324] = 'flow is in use by other content. Can not be deleted';
$this->apiErrors[325] = 'Deleting flow failed.';

// for function: openml.flow.exists
$this->apiErrors[330] = 'Mandatory fields not present.';

// for function: openml.run.getjob
$this->apiErrors[340] = 'Please provide workbench and task type.';
$this->apiErrors[341] = 'No jobs available.';

// for function: openml.data.delete
$this->apiErrors[350] = 'Please provide API key';
$this->apiErrors[351] = 'Authentication failed';
$this->apiErrors[352] = 'Dataset does not exists';
$this->apiErrors[353] = 'Dataset is not owned by you';
$this->apiErrors[354] = 'Dataset is in use by other content. Can not be deleted';
$this->apiErrors[355] = 'Deleting dataset failed.';

// for function: openml.data.qualities
$this->apiErrors[360] = 'Please provide data_id';
$this->apiErrors[361] = 'Unknown dataset';
$this->apiErrors[362] = 'No qualities found';
$this->apiErrors[363] = 'Dataset not processed yet';
$this->apiErrors[364] = 'Dataset processed with error';
$this->apiErrors[365] = 'Interval start or end illegal';

// for function: openml.data
$this->apiErrors[370] = 'Illegal filter specified';
$this->apiErrors[371] = 'Input not safe';
$this->apiErrors[372] = 'No results';

// for function: openml.qualities.upload
$this->apiErrors[380] = 'Please provide API key';
$this->apiErrors[381] = 'Authentication failed';
$this->apiErrors[382] = 'Please provide description xml';
$this->apiErrors[383] = 'Problem validating uploaded description file';
$this->apiErrors[384] = 'Could not find dataset';
$this->apiErrors[385] = 'Quality calculated twice.';
$this->apiErrors[386] = 'Quality inconsistent';
$this->apiErrors[387] = 'Quality does not exists';
$this->apiErrors[388] = 'No new qualities';
$this->apiErrors[389] = 'Quality upload failed';

// for function: openml.run.delete
$this->apiErrors[390] = 'Please provide API key';
$this->apiErrors[391] = 'Authentication failed';
$this->apiErrors[392] = 'Run does not exists';
$this->apiErrors[393] = 'Run is not owned by you';
$this->apiErrors[394] = 'Deleting run failed.';
$this->apiErrors[400] = 'Please provide API key';

// for function: openml.setup.delete
$this->apiErrors[401] = 'Authentication failed';
$this->apiErrors[402] = 'Setup does not exists';
$this->apiErrors[404] = 'Setup is in use by other content (runs, schedules, etc). Can not be deleted';
$this->apiErrors[405] = 'Deleting setup failed.';

// for function: openml.run.reset
$this->apiErrors[410] = 'Please provide API key';
$this->apiErrors[411] = 'Authentication failed';
$this->apiErrors[412] = 'Run does not exists';
$this->apiErrors[413] = 'Run is not owned by you';
$this->apiErrors[414] = 'Resetting run failed.';

// for function: openml.run.evaluate
$this->apiErrors[420] = 'Please provide API key';
$this->apiErrors[421] = 'Authentication failed';
$this->apiErrors[422] = 'Upload problem description XML';
$this->apiErrors[423] = 'Problem validating uploaded description file';
$this->apiErrors[424] = 'Problem opening description xml';
$this->apiErrors[425] = 'Run does not exists';
$this->apiErrors[426] = 'Run already processed';

// for function: openml.data.features.upload
$this->apiErrors[430] = 'Please provide API key';
$this->apiErrors[431] = 'Authentication failed';
$this->apiErrors[432] = 'Please provide description xml';
$this->apiErrors[433] = 'Problem validating uploaded description file';
$this->apiErrors[434] = 'Could not find dataset';
$this->apiErrors[435] = 'Feature upload failed';

// for function: openml.estimationprocedure.get
$this->apiErrors[440] = 'Please provide estimationprocedure_id';
$this->apiErrors[441] = 'estimationprocedure_id not valid';

// for function: openml.task.delete
$this->apiErrors[450] = 'Please provide API key';
$this->apiErrors[451] = 'Authentication failed';
$this->apiErrors[452] = 'Task does not exists';
$this->apiErrors[454] = 'Task is executed in some runs. Delete these first';
$this->apiErrors[455] = 'Deleting task failed.';

// for function: openml.task.delete
$this->apiErrors[460] = 'Please provide API key';
$this->apiErrors[461] = 'Authentication failed';
$this->apiErrors[462] = 'Admin rights are required.';
$this->apiErrors[463] = 'User not found. ';
$this->apiErrors[464] = 'User has content';
$this->apiErrors[465] = 'Deleting user failed.';
$this->apiErrors[465] = 'Deleting user failed.';

// for function: openml.data.tag
$this->apiErrors[470] = 'Please give entity_id {data_id, flow_id, run_id} and tag.';
$this->apiErrors[471] = 'Entity not found.';
$this->apiErrors[472] = 'Entity already tagged by this tag. ';
$this->apiErrors[473] = 'Database problem inserting tag. ';
$this->apiErrors[474] = 'Internal error tagging the entity. ';

// for function: openml.data.untag
$this->apiErrors[475] = 'Please give entity_id {data_id, flow_id, run_id} and tag.';
$this->apiErrors[476] = 'Entity {dataset, flow, run} not found.';
$this->apiErrors[477] = 'Tag not found.';
$this->apiErrors[478] = 'Tag is not owned by you';

// for function: openml.data.tag (again)
$this->apiErrors[479] = 'Internal error removing the tag. ';

// openml.task.list
$this->apiErrors[480] = 'Illegal filter specified';
$this->apiErrors[481] = 'Input not safe';
$this->apiErrors[482] = 'No results';

// openml.file.upload
$this->apiErrors[490] = 'Authentication failed';
$this->apiErrors[491] = 'File upload error';
$this->apiErrors[492] = 'File register error';

// openml.flows
$this->apiErrors[500] = 'No results';

// openml.runs.list
$this->apiErrors[510] = 'Please provide at least task, flow or setup, uploader or run, to filter results. ';
$this->apiErrors[511] = 'Input not safe';
$this->apiErrors[512] = 'No results';
$this->apiErrors[513] = 'Too many results';
$this->apiErrors[514] = 'Illegal filter specified';

// openml.estimationprocedure.list
$this->apiErrors[520] = 'No results';

// openml.task.upload
$this->apiErrors[530] = 'Description file not present';
$this->apiErrors[531] = 'Xsd not found';
$this->apiErrors[532] = 'Problem validating uploaded description file';
$this->apiErrors[533] = 'Task already exists.';
$this->apiErrors[534] = 'Error creating the task.';

// openml.evaluations.list
$this->apiErrors[540] = 'Please provide at least task, flow or setup, uploader or run, to filter results. ';
$this->apiErrors[541] = 'Input not safe';
$this->apiErrors[542] = 'No results';
$this->apiErrors[543] = 'Too many results';

// openml.flow.forcedelete
$this->apiErrors[550] = 'Admin rights are required.';
$this->apiErrors[551] = 'Delete query failed.';

// openml.run.trace.upload
$this->apiErrors[561] = 'Problem with uploaded trace file.';
$this->apiErrors[562] = 'Problem validating xml trace file.';
$this->apiErrors[563] = 'Problem loading xml trace file.';


// openml.run.trace (get)
$this->apiErrors[570] = 'No successful trace associated with this run.';

// openml.setup.exists
$this->apiErrors[581] = 'Problem with uploading the description file. ';
$this->apiErrors[582] = 'Could not validate run xml by xsd. ';
$this->apiErrors[583] = 'Error reading the XML document. ';
$this->apiErrors[584] = 'Unknown flow. ';
$this->apiErrors[585] = 'Wrong flow associated with run: this implements a math_function. ';
$this->apiErrors[586] = 'Parameter in run xml unknown. ';

// openml.votes.list
$this->apiErrors[701] = 'List failed';

// openml.votes.votesofuser
$this->apiErrors[702] = 'List failed';

// openml.votes.delete
$this->apiErrors[703] = 'Unknown vote';

// openml.votes.delete
$this->apiErrors[704] = 'Deletion failed';

// openml.votes.do
$this->apiErrors[705] = 'Insertion failed';

// openml.votes.do / openml.votes.delete
$this->apiErrors[711] = 'Unknown knowledge type';

// openml.votes.delete
$this->apiErrors[721] = 'Unauthorized deletion';

// openml.votes.do
$this->apiErrors[722] = 'Unauthorized vote';

// openml.votes.list
$this->apiErrors[801] = 'List failed';

// openml.votes.votesofuser
$this->apiErrors[802] = 'List failed';

// openml.votes.delete
$this->apiErrors[803] = 'Unknown vote';

// openml.votes.delete
$this->apiErrors[804] = 'Deletion failed';

// openml.votes.do
$this->apiErrors[805] = 'Insertion failed';

// openml.votes.do / openml.votes.delete
$this->apiErrors[811] = 'Unknown knowledge type';

// openml.votes.delete
$this->apiErrors[821] = 'Unauthorized deletion';

// openml.votes.do
$this->apiErrors[822] = 'Unauthorized vote';

//openml.gamification
$this->apiErrors[901] = 'No such user';
$this->apiErrors[902] = 'Unauthorized gamification request';

//openml.gamification.activity
$this->apiErrors[903] = 'Invalid type';

//openml.badges
$this->apiErrors[950] = 'No such badge';

?>
