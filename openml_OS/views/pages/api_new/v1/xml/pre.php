<?php
// for function: openml.global
$this->apiErrors[100][0] = 'Function not valid';
$this->apiErrors[100][1] = 'Function not valid';

// for function: openml.global
$this->apiErrors[101][0] = 'Function not yet ported or implemented';
$this->apiErrors[101][1] = 'Function not yet ported or implemented';

// for function: openml.global
$this->apiErrors[102][0] = 'No authentication';
$this->apiErrors[102][1] = 'Please log in of provide your API key';

// for function: openml.global
$this->apiErrors[103][0] = 'Authentication failed';
$this->apiErrors[103][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.global
$this->apiErrors[104][0] = 'This is a read-only account, not the right permissions to execute a write operation. ';
$this->apiErrors[104][1] = 'The api key was valid, but the user has not the right (write) permissions.';


// for function: openml.data.description
$this->apiErrors[110][0] = 'Please provide data_id';
$this->apiErrors[110][1] = 'Please provide data_id';

// for function: openml.data.description
$this->apiErrors[111][0] = 'Unknown dataset';
$this->apiErrors[111][1] = 'Data set description with data_id was not found in the database';

// for function: openml.data.description
$this->apiErrors[112][0] = 'No access granted';
$this->apiErrors[112][1] = 'This dataset is not shared with you';

// for function: openml.data.upload
$this->apiErrors[130][0] = 'Problem with file uploading';
$this->apiErrors[130][1] = 'There was a problem with the file upload';

// for function: openml.data.upload
$this->apiErrors[131][0] = 'Problem validating uploaded description file';
$this->apiErrors[131][1] = 'The XML description format does not meet the standards';

// for function: openml.data.upload
$this->apiErrors[132][0] = 'Failed to move the files';
$this->apiErrors[132][1] = 'Internal server error, please contact api administrators';

// for function: openml.data.upload
$this->apiErrors[133][0] = 'Failed to make checksum of datafile';
$this->apiErrors[133][1] = 'Internal server error, please contact api administrators';

// for function: openml.data.upload
$this->apiErrors[134][0] = 'Failed to insert record in database';
$this->apiErrors[134][1] = 'Internal server error, please contact api administrators';

// for function: openml.data.upload
$this->apiErrors[135][0] = 'Please provide description xml';
$this->apiErrors[135][1] = 'Please provide description xml';

// for function: openml.data.upload
$this->apiErrors[136][0] = 'File failed format verification. The uploaded file is not valid according to the selected file format. Please check the file format specification and try again.';
$this->apiErrors[136][1] = 'The uploaded file and the specified file format do not match. Please check the file format specification and try again.';

// for function: openml.data.upload
$this->apiErrors[137][0] = 'Please provide API key';
$this->apiErrors[137][1] = 'In order to share content, please authenticate  and provide API key';

// for function: openml.data.upload
$this->apiErrors[138][0] = 'Authentication failed';
$this->apiErrors[138][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.data.upload
$this->apiErrors[139][0] = 'Combination name / version already exists';
$this->apiErrors[139][1] = 'The combination of name and version of this dataset already exists. Leave version out for auto increment';

// for function: openml.data.upload
$this->apiErrors[140][0] = 'Both dataset file and dataset url provided. Please provide only one';
$this->apiErrors[140][1] = 'The system is confused since both a dataset file (post) and a dataset url (xml) are provided. Please remove one';

// for function: openml.data.upload
$this->apiErrors[141][0] = 'Neither dataset file or dataset url are provided';
$this->apiErrors[141][1] = 'Please provide either a dataset file as POST variable, xor a dataset url in the description XML';

// for function: openml.data.upload
$this->apiErrors[142][0] = 'Error in processing arff file. Can be a syntax error, or the specified target feature does not exists';
$this->apiErrors[142][1] = 'For now, we only check on arff files. If a dataset is claimed to be in such a format, and it can not be parsed, this error is returned. ';

// for function: openml.data.upload
$this->apiErrors[143][0] = 'Suggested target feature not legal ';
$this->apiErrors[143][1] = 'It is possible to suggest a default target feature (for predictive tasks). However, it should be provided in the data. ';

// for function: openml.data.upload
$this->apiErrors[144][0] = 'Unable to update dataset ';
$this->apiErrors[144][1] = 'The dataset with this id could not be found in the database. If you upload a new dataset, unset the id. ';


// for function: openml.tasks.search
$this->apiErrors[150][0] = 'Please provide task_id';
$this->apiErrors[150][1] = 'Please provide task_id';

// for function: openml.tasks.search
$this->apiErrors[151][0] = 'Unknown task';
$this->apiErrors[151][1] = 'The task with this id was not found in the database';

// for function: openml.flow.upload
$this->apiErrors[160][0] = 'Error in file uploading';
$this->apiErrors[160][1] = 'There was a problem with the file upload';

// for function: openml.flow.upload
$this->apiErrors[161][0] = 'Please provide description xml';
$this->apiErrors[161][1] = 'Please provide description xml';

// for function: openml.flow.upload
$this->apiErrors[162][0] = 'Please provide source or binary file';
$this->apiErrors[162][1] = 'Please provide source or binary file. It is also allowed to upload both';

// for function: openml.flow.upload
$this->apiErrors[163][0] = 'Problem validating uploaded description file';
$this->apiErrors[163][1] = 'The XML description format does not meet the standards';

// for function: openml.flow.upload
$this->apiErrors[164][0] = 'flow already stored in database';
$this->apiErrors[164][1] = 'Please change name or version number';

// for function: openml.flow.upload
$this->apiErrors[165][0] = 'Failed to insert flow';
$this->apiErrors[165][1] = 'There can be many causes for this error. If you included the implements field, it should be an existing entry in the algorithm or math_function table. Otherwise it could be an internal server error. Please contact API support team. ';

// for function: openml.flow.upload
$this->apiErrors[166][0] = 'Failed to add flow to database';
$this->apiErrors[166][1] = 'Internal server error, please contact api administrators';

// for function: openml.flow.upload
$this->apiErrors[167][0] = 'Illegal files uploaded';
$this->apiErrors[167][1] = 'An non required file was uploaded.';

// for function: openml.flow.upload
$this->apiErrors[168][0] = 'The provided md5 hash equals not the server generated md5 hash of the file';
$this->apiErrors[168][1] = 'The provided md5 hash equals not the server generated md5 hash of the file';

// for function: openml.flow.upload
$this->apiErrors[169][0] = 'Please provide API key';
$this->apiErrors[169][1] = 'In order to share content, please authenticate and provide API key';

// for function: openml.flow.upload
$this->apiErrors[170][0] = 'Authentication failed';
$this->apiErrors[170][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.flow.upload
$this->apiErrors[171][0] = 'flow already exists';
$this->apiErrors[171][1] = 'This flow is already in the database';

// for function: openml.flow.upload
$this->apiErrors[172][0] = 'Xsd not found';
$this->apiErrors[172][1] = 'Please contact api support team';

// for function: openml.flow.get
$this->apiErrors[180][0] = 'Please provide flow_id';
$this->apiErrors[180][1] = 'Please provide flow_id';

// for function: openml.flow.get
$this->apiErrors[181][0] = 'Unknown flow';
$this->apiErrors[181][1] = 'The flow with this ID was not found in the database';

// for function: openml.run.upload
//$this->apiErrors[200][0] = 'Please provide API key';
//$this->apiErrors[200][1] = 'In order to share content, please authenticate  and provide API key';

// for function: openml.run.upload
//$this->apiErrors[201][0] = 'Authentication failed';
//$this->apiErrors[201][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.run.upload
$this->apiErrors[202][0] = 'Please provide run xml';
$this->apiErrors[202][1] = 'Please provide run xml';

// for function: openml.run.upload
$this->apiErrors[203][0] = 'Could not validate run xml by xsd';
$this->apiErrors[203][1] = 'Please double check that the xml is valid. ';

// for function: openml.run.upload
$this->apiErrors[204][0] = 'Unknown task';
$this->apiErrors[204][1] = 'The task with this id was not found in the database';

// for function: openml.run.upload
$this->apiErrors[205][0] = 'Unknown flow';
$this->apiErrors[205][1] = 'The flow with this id was not found in the database';

// for function: openml.run.upload
$this->apiErrors[206][0] = 'Invalid number of files';
$this->apiErrors[206][1] = 'The number of uploaded files did not match the number of files expected for this task type';

// for function: openml.run.upload
$this->apiErrors[207][0] = 'File upload failed';
$this->apiErrors[207][1] = 'One of the files uploaded has a problem';

// for function: openml.run.upload
$this->apiErrors[208][0] = 'Error inserting setup record';
$this->apiErrors[208][1] = 'Internal server error, please contact api administrators';

// for function: openml.run.upload
$this->apiErrors[210][0] = 'Unable to store run';
$this->apiErrors[210][1] = 'Internal server error, please contact api administrators';

// for function: openml.run.upload
$this->apiErrors[211][0] = 'Dataset not in databse';
$this->apiErrors[211][1] = 'One of the datasets of this task was not included in database, please contact api administrators';

// for function: openml.run.upload
$this->apiErrors[212][0] = 'Unable to store file';
$this->apiErrors[212][1] = 'Internal server error, please contact api administrators';

// for function: openml.run.upload
$this->apiErrors[213][0] = 'Parameter in run xml unknown';
$this->apiErrors[213][1] = 'One of the parameters provided in the run xml is not registered as parameter for the flow nor its components';

// for function: openml.run.upload
$this->apiErrors[214][0] = 'Unable to store input setting';
$this->apiErrors[214][1] = 'Internal server error, please contact API support team';

// for function: openml.run.upload
$this->apiErrors[215][0] = 'Unable to evaluate predictions';
$this->apiErrors[215][1] = 'Internal server error, please contact API support team';

// for function: openml.run.upload
$this->apiErrors[216][0] = 'Error thrown by Java Application';
$this->apiErrors[216][1] = 'The Java application has thrown an error. Additional information field is provided';

// for function: openml.run.upload
$this->apiErrors[217][0] = 'Error processing output data: unknown or inconsistent evaluation measure';
$this->apiErrors[217][1] = 'One of the provided evaluation measures could not be matched with a record in the math_function / flow table.';

// for function: openml.run.upload
$this->apiErrors[218][0] = 'Wrong flow associated with run: this implements a math_function';
$this->apiErrors[218][1] = 'The flow implements a math_function, which is unable to generate predictions. Please select another flow. ';

// for function: openml.run.upload
$this->apiErrors[219][0] = 'Error reading the XML document';
$this->apiErrors[219][1] = 'The xml description file could not be verified. ';


// for function: openml.run.get
$this->apiErrors[220][0] = 'Please provide run_id';
$this->apiErrors[220][1] = 'In order to view run details, please provide run_id';

// for function: openml.run.get
$this->apiErrors[221][0] = 'Run not found';
$this->apiErrors[221][1] = 'The run id was invalid, run not found';

// for function: openml.tasks.type.search
$this->apiErrors[240][0] = 'Please provide task_type_id';
$this->apiErrors[240][1] = 'Please provide task_type_id';

// for function: openml.tasks.type.search
$this->apiErrors[241][0] = 'Unknown task type';
$this->apiErrors[241][1] = 'The task type with this id was not found in the database';

// for function: openml.authenticate
$this->apiErrors[250][0] = 'Please provide username';
$this->apiErrors[250][1] = 'Please provide the username as a POST variable';

// for function: openml.authenticate
$this->apiErrors[251][0] = 'Please provide password';
$this->apiErrors[251][1] = 'Please provide the password (hashed as a MD5) as a POST variable';

// for function: openml.authenticate
$this->apiErrors[252][0] = 'Authentication failed';
$this->apiErrors[252][1] = 'The username and password did not match any record in the database. Please note that the password should be hashed using md5';

// for function: openml.data.features
$this->apiErrors[270][0] = 'Please provide data_id';
$this->apiErrors[270][1] = 'Please provide data_id';

// for function: openml.data.features
$this->apiErrors[271][0] = 'Unknown dataset';
$this->apiErrors[271][1] = 'Data set description with data_id was not found in the database';

// for function: openml.data.features
$this->apiErrors[272][0] = 'No features found';
$this->apiErrors[272][1] = 'The registered dataset did not contain any features';

// for function: openml.data.features
$this->apiErrors[273][0] = 'Dataset not processed yet';
$this->apiErrors[273][1] = 'The dataset was not processed yet, no features are available. Please wait for a few minutes. ';

// for function: openml.data.features
$this->apiErrors[274][0] = 'Dataset processed with error';
$this->apiErrors[274][1] = 'The feature extractor has run into an error while processing the dataset. Please check whether it is a valid supported file. ';

// for function: openml.setup.parameters
$this->apiErrors[280][0] = 'Please provide setup_id';
$this->apiErrors[280][1] = 'Please provide setup_id';

// for function: openml.setup.parameters
$this->apiErrors[281][0] = 'Unknown setup';
$this->apiErrors[281][1] = 'Setup with setup_id was not found in the database';

// for function: openml.authenticate.check
$this->apiErrors[290][0] = 'Username not provided';
$this->apiErrors[290][1] = 'Please provide username';

// for function: openml.authenticate.check
$this->apiErrors[291][0] = 'Hash not provided';
$this->apiErrors[291][1] = 'Please provide hash to be checked';

// for function: openml.authenticate.check
$this->apiErrors[292][0] = 'Hash does not exist';
$this->apiErrors[292][1] = 'Hash does not exist, or is not owned by this user';

// for function: openml.task.results
$this->apiErrors[300][0] = 'Please provide task_id';
$this->apiErrors[300][1] = 'Please provide task_id';

// for function: openml.task.results
$this->apiErrors[301][0] = 'Unknown task';
$this->apiErrors[301][1] = 'The task with this id was not found in the database';

// for function: openml.flow.owned
$this->apiErrors[310][0] = 'Please provide API key';
$this->apiErrors[310][1] = 'In order to view private content, please authenticate  and provide API key';

// for function: openml.flow.owned
$this->apiErrors[311][0] = 'Authentication failed';
$this->apiErrors[311][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.flow.owned
$this->apiErrors[312][0] = 'No flows owned by this used';
$this->apiErrors[312][1] = 'The user has no flows linked to his account';

// for function: openml.flow.delete
$this->apiErrors[320][0] = 'Please provide API key';
$this->apiErrors[320][1] = 'In order to remove your content, please authenticate  and provide API key';

// for function: openml.flow.delete
$this->apiErrors[321][0] = 'Authentication failed';
$this->apiErrors[321][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.flow.delete
$this->apiErrors[322][0] = 'flow does not exists';
$this->apiErrors[322][1] = 'The flow id could not be linked to an existing flow.';

// for function: openml.flow.delete
$this->apiErrors[323][0] = 'flow is not owned by you';
$this->apiErrors[323][1] = 'The flow was owned by another user. Hence you cannot delete it.';

// for function: openml.flow.delete
$this->apiErrors[324][0] = 'flow is in use by other content. Can not be deleted';
$this->apiErrors[324][1] = 'The flow is used in runs, evaluations or as component of another flow. Delete this other content before deleting this flow. ';

// for function: openml.flow.delete
$this->apiErrors[325][0] = 'Deleting flow failed.';
$this->apiErrors[325][1] = 'Deleting the flow failed. Please contact support team. ';

// for function: openml.flow.exists
$this->apiErrors[330][0] = 'Mandatory fields not present.';
$this->apiErrors[330][1] = 'Please provide one of the following mandatory field combination: name and external_version. ';

// for function: openml.run.getjob
$this->apiErrors[340][0] = 'Please provide workbench and task type.';
$this->apiErrors[340][1] = 'Please provide workbench and task type.';

// for function: openml.run.getjob
$this->apiErrors[341][0] = 'No jobs available.';
$this->apiErrors[341][1] = 'There are no jobs that need to be executed.';

// for function: openml.data.delete
$this->apiErrors[350][0] = 'Please provide API key';
$this->apiErrors[350][1] = 'In order to remove your content, please authenticate  and provide API key';

// for function: openml.data.delete
$this->apiErrors[351][0] = 'Authentication failed';
$this->apiErrors[351][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.data.delete
$this->apiErrors[352][0] = 'Dataset does not exists';
$this->apiErrors[352][1] = 'The data id could not be linked to an existing dataset.';

// for function: openml.data.delete
$this->apiErrors[353][0] = 'Dataset is not owned by you';
$this->apiErrors[353][1] = 'The dataset was owned by another user. Hence you cannot delete it.';

// for function: openml.data.delete
$this->apiErrors[354][0] = 'Dataset is in use by other content. Can not be deleted';
$this->apiErrors[354][1] = 'The data is used in runs. Delete this other content before deleting this dataset. ';

// for function: openml.data.delete
$this->apiErrors[355][0] = 'Deleting dataset failed.';
$this->apiErrors[355][1] = 'Deleting the dataset failed. Please contact support team. ';

// for function: openml.data.qualities
$this->apiErrors[360][0] = 'Please provide data_id';
$this->apiErrors[360][1] = 'Please provide data_id';

// for function: openml.data.qualities
$this->apiErrors[361][0] = 'Unknown dataset';
$this->apiErrors[361][1] = 'Data set description with data_id was not found in the database';

// for function: openml.data.qualities
$this->apiErrors[362][0] = 'No qualities found';
$this->apiErrors[362][1] = 'The registered dataset did not contain any calculated qualities';

// for function: openml.data.qualities
$this->apiErrors[363][0] = 'Dataset not processed yet';
$this->apiErrors[363][1] = 'The dataset was not processed yet, no qualities are available. Please wait for a few minutes. ';

// for function: openml.data.qualities
$this->apiErrors[364][0] = 'Dataset processed with error';
$this->apiErrors[364][1] = 'The quality calculator has run into an error while processing the dataset. Please check whether it is a valid supported file. ';

// for function: openml.data.qualities
$this->apiErrors[365][0] = 'Interval start or end illegal';
$this->apiErrors[365][1] = 'There was a problem with the interval start or end. ';

// for function: openml.data
$this->apiErrors[370][0] = 'No datasets available';
$this->apiErrors[370][1] = 'There are no valid datasets in the system. ';

// for function: openml.qualities.upload
$this->apiErrors[380][0] = 'Please provide API key';
$this->apiErrors[380][1] = 'In order to share content, please authenticate  and provide API key';

// for function: openml.qualities.upload
$this->apiErrors[381][0] = 'Authentication failed';
$this->apiErrors[381][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.qualities.upload
$this->apiErrors[382][0] = 'Please provide description xml';
$this->apiErrors[382][1] = 'Please provide description xml';

// for function: openml.qualities.upload
$this->apiErrors[383][0] = 'Problem validating uploaded description file';
$this->apiErrors[383][1] = 'The XML description format does not meet the standards';

// for function: openml.qualities.upload
$this->apiErrors[384][0] = 'Could not find dataset';
$this->apiErrors[384][1] = 'The dataset to which the qualities belong could not be found. ';

// for function: openml.qualities.upload
$this->apiErrors[385][0] = 'Quality calculated twice.';
$this->apiErrors[385][1] = 'The quality description file contains the same quality twice. ';

// for function: openml.qualities.upload
$this->apiErrors[386][0] = 'Quality inconsistent';
$this->apiErrors[386][1] = 'The calculated quality is inconsistent with previous calculated values. ';

// for function: openml.qualities.upload
$this->apiErrors[387][0] = 'Quality does not exists';
$this->apiErrors[387][1] = 'The calculated data quality does not exists in the quality table. ';

// for function: openml.qualities.upload
$this->apiErrors[388][0] = 'No new qualities';
$this->apiErrors[388][1] = 'All qualities were already stored, so no new qualities were added.';

// for function: openml.qualities.upload
$this->apiErrors[389][0] = 'Quality upload failed';
$this->apiErrors[389][1] = 'Unable to add new qualities to the database. Please contact API support';

// for function: openml.run.delete
$this->apiErrors[390][0] = 'Please provide API key';
$this->apiErrors[390][1] = 'In order to remove your content, please authenticate  and provide API key';

// for function: openml.run.delete
$this->apiErrors[391][0] = 'Authentication failed';
$this->apiErrors[391][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.run.delete
$this->apiErrors[392][0] = 'Run does not exists';
$this->apiErrors[392][1] = 'The run id could not be linked to an existing run.';

// for function: openml.run.delete
$this->apiErrors[393][0] = 'Run is not owned by you';
$this->apiErrors[393][1] = 'The run was owned by another user. Hence you cannot delete it.';

// for function: openml.run.delete
$this->apiErrors[394][0] = 'Deleting run failed.';
$this->apiErrors[394][1] = 'Deleting the run failed. Please contact support team. ';

// for function: openml.setup.delete
$this->apiErrors[400][0] = 'Please provide API key';
$this->apiErrors[400][1] = 'In order to remove your content, please authenticate  and provide API key';

// for function: openml.setup.delete
$this->apiErrors[401][0] = 'Authentication failed';
$this->apiErrors[401][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.setup.delete
$this->apiErrors[402][0] = 'Setup does not exists';
$this->apiErrors[402][1] = 'The setup id could not be linked to an existing setup.';

// for function: openml.setup.delete
$this->apiErrors[404][0] = 'Setup is in use by other content (runs, schedules, etc). Can not be deleted';
$this->apiErrors[404][1] = 'The setup is used in runs. Delete this other content before deleting this setup. ';

// for function: openml.setup.delete
$this->apiErrors[405][0] = 'Deleting setup failed.';
$this->apiErrors[405][1] = 'Deleting the setup failed. Please contact support team. ';

// for function: openml.run.reset
$this->apiErrors[410][0] = 'Please provide API key';
$this->apiErrors[410][1] = 'In order to remove your content, please authenticate  and provide API key';

// for function: openml.run.reset
$this->apiErrors[411][0] = 'Authentication failed';
$this->apiErrors[411][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.run.reset
$this->apiErrors[412][0] = 'Run does not exists';
$this->apiErrors[412][1] = 'The run id could not be linked to an existing run.';

// for function: openml.run.reset
$this->apiErrors[413][0] = 'Run is not owned by you';
$this->apiErrors[413][1] = 'The run was owned by another user. Hence you cannot reset it.';

// for function: openml.run.reset
$this->apiErrors[414][0] = 'Resetting run failed.';
$this->apiErrors[414][1] = 'Resetting the run failed. Please contact support team. ';

// for function: openml.run.evaluate
$this->apiErrors[420][0] = 'Please provide API key';
$this->apiErrors[420][1] = 'In order to remove your content, please authenticate  and provide API key';

// for function: openml.run.evaluate
$this->apiErrors[421][0] = 'Authentication failed';
$this->apiErrors[421][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.run.evaluate
$this->apiErrors[422][0] = 'Upload problem description XML';
$this->apiErrors[422][1] = 'Upload problem description XML';

// for function: openml.run.evaluate
$this->apiErrors[423][0] = 'Problem validating uploaded description file';
$this->apiErrors[423][1] = 'The XML description format does not meet the standards';

// for function: openml.run.evaluate
$this->apiErrors[424][0] = 'Problem opening description xml';
$this->apiErrors[424][1] = 'Problem opening description xml';

// for function: openml.run.evaluate
$this->apiErrors[425][0] = 'Run does not exists';
$this->apiErrors[425][1] = 'Run does not exists';

// for function: openml.run.evaluate
$this->apiErrors[426][0] = 'Run already processed';
$this->apiErrors[426][1] = 'Run already processed';

// for function: openml.data.features.upload
$this->apiErrors[430][0] = 'Please provide API key';
$this->apiErrors[430][1] = 'In order to share content, please authenticate  and provide API key';

// for function: openml.data.features.upload
$this->apiErrors[431][0] = 'Authentication failed';
$this->apiErrors[431][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.data.features.upload
$this->apiErrors[432][0] = 'Please provide description xml';
$this->apiErrors[432][1] = 'Please provide description xml';

// for function: openml.data.features.upload
$this->apiErrors[433][0] = 'Problem validating uploaded description file';
$this->apiErrors[433][1] = 'The XML description format does not meet the standards';

// for function: openml.data.features.upload
$this->apiErrors[434][0] = 'Could not find dataset';
$this->apiErrors[434][1] = 'The dataset to which the qualities belong could not be found. ';

// for function: openml.data.features.upload
$this->apiErrors[435][0] = 'Feature upload failed';
$this->apiErrors[435][1] = 'Unable to add new features to the database. Please contact API support';

// for function: openml.estimationprocedure.get
$this->apiErrors[440][0] = 'Please provide estimationprocedure_id';
$this->apiErrors[440][1] = 'Please provide estimationprocedure_id';

// for function: openml.estimationprocedure.get
$this->apiErrors[441][0] = 'estimationprocedure_id not valid';
$this->apiErrors[441][1] = 'Please provide a valid estimationprocedure_id';

// for function: openml.task.delete
$this->apiErrors[450][0] = 'Please provide API key';
$this->apiErrors[450][1] = 'In order to remove your content, please authenticate  and provide API key';

// for function: openml.task.delete
$this->apiErrors[451][0] = 'Authentication failed';
$this->apiErrors[451][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.task.delete
$this->apiErrors[452][0] = 'Task does not exists';
$this->apiErrors[452][1] = 'The task id could not be linked to an existing task.';

// for function: openml.task.delete
$this->apiErrors[454][0] = 'Task is executed in some runs. Delete these first';
$this->apiErrors[454][1] = 'The task is used in runs. Delete this other content before deleting this task. ';

// for function: openml.task.delete
$this->apiErrors[455][0] = 'Deleting task failed.';
$this->apiErrors[455][1] = 'Deleting the task failed. Please contact support team. ';

// for function: openml.task.delete
$this->apiErrors[460][0] = 'Please provide API key';
$this->apiErrors[460][1] = 'In order to remove your content, please authenticate  and provide API key';

// for function: openml.task.delete
$this->apiErrors[461][0] = 'Authentication failed';
$this->apiErrors[461][1] = 'The API key was not valid. Please try to login again, or contact api administrators';

// for function: openml.task.delete
$this->apiErrors[462][0] = 'Admin rights are required.';
$this->apiErrors[462][1] = 'You can not execute this operation because you are not an admin.';

// for function: openml.task.delete
$this->apiErrors[463][0] = 'User not found. ';
$this->apiErrors[463][1] = 'The user id could not be linked to an existing user.';

// for function: openml.task.delete
$this->apiErrors[464][0] = 'User has content';
$this->apiErrors[464][1] = 'Delete the content before deleting this user. ';

// for function: openml.task.delete
$this->apiErrors[465][0] = 'Deleting user failed.';
$this->apiErrors[465][1] = 'Deleting the user failed. Please contact support team. ';

// for function: openml.task.delete
$this->apiErrors[465][0] = 'Deleting user failed.';
$this->apiErrors[465][1] = 'Deleting the user failed. Please contact support team. ';

// for function: openml.data.tag
$this->apiErrors[470][0] = 'Please give entity_id {data_id, flow_id, run_id} and tag.';
$this->apiErrors[470][1] = 'In order to add a tag, please upload the entity id (either data_id, flow_id, run_id) and tag (the name of the tag).';

// for function: openml.data.tag
$this->apiErrors[471][0] = 'Entity not found.';
$this->apiErrors[471][1] = 'The provided entity_id {data_id, flow_id, run_id} does not correspond to an existing entity.';

// for function: openml.data.tag
$this->apiErrors[472][0] = 'Entity already tagged by this tag. ';
$this->apiErrors[472][1] = 'The entity {dataset, flow, run} already had this tag. Probably tagged by another user. ';

// for function: openml.data.tag
$this->apiErrors[473][0] = 'Database problem inserting tag. ';
$this->apiErrors[473][1] = 'Something went wrong inserting the tag. Please contact OpenML Team. ';

// for function: openml.data.tag
$this->apiErrors[474][0] = 'Internal error tagging the entity. ';
$this->apiErrors[474][1] = 'Something technical went wrong inserting the tag. Please contact OpenML Team. ';

// for function: openml.data.untag
$this->apiErrors[475][0] = 'Please give entity_id {data_id, flow_id, run_id} and tag.';
$this->apiErrors[475][1] = 'In order to remove a tag, please upload the entity id (either data_id, flow_id, run_id) and tag (the name of the tag).';

// for function: openml.data.untag
$this->apiErrors[476][0] = 'Entity {dataset, flow, run} not found.';
$this->apiErrors[476][1] = 'The provided entity_id {data_id, flow_id, run_id} does not correspond to an existing entity.';

// for function: openml.data.untag
$this->apiErrors[477][0] = 'Tag not found.';
$this->apiErrors[477][1] = 'The provided tag is not associated with the entity {dataset, flow, run}.';

// for function: openml.data.untag
$this->apiErrors[478][0] = 'Tag is not owned by you';
$this->apiErrors[478][1] = 'The entity {dataset, flow, run} was tagged by another user. Hence you cannot delete it.';

// for function: openml.data.tag
$this->apiErrors[479][0] = 'Internal error removing the tag. ';
$this->apiErrors[479][1] = 'Something technical went wrong removing the tag. Please contact OpenML Team. ';

// openml.tasks
$this->apiErrors[480][0] = 'Please provide task_type_id';
$this->apiErrors[480][1] = 'In order to view task overview, please provide task_type_id. ';

// openml.tasks
$this->apiErrors[481][0] = 'No results';
$this->apiErrors[481][1] = 'There where no matches for this task type id. Check whether some tasks exists. ';

// openml.file.upload
$this->apiErrors[490][0] = 'Authentication failed';
$this->apiErrors[490][1] = 'Admin rights required for this function. ';

// openml.file.upload
$this->apiErrors[491][0] = 'File upload error';
$this->apiErrors[491][1] = 'Something went wrong uploading the file. Might be filesize problem. ';

// openml.file.upload
$this->apiErrors[492][0] = 'File register error';
$this->apiErrors[492][1] = 'Something went wrong registering the file. Please contact OpenML team. ';


// openml.flows
$this->apiErrors[500][0] = 'No results';
$this->apiErrors[500][1] = 'There where no results. Check whether there are flows. ';

// openml.runs.list
$this->apiErrors[510][0] = 'Please provide at least task, flow or setup, uploader or run, to filter results. ';
$this->apiErrors[510][1] = 'The number of runs is huge. Please limit the result space. ';

// openml.runs.list
$this->apiErrors[511][0] = 'Input not safe';
$this->apiErrors[511][1] = 'The input parameters (task_id, setup_id, flow_id, run_id, uploader_id) did not meet the contrains (comma separated list of integers). ';

// openml.runs.list
$this->apiErrors[512][0] = 'No results';
$this->apiErrors[512][1] = 'There where no results. Check whether there are runs under this constraint. ';

// openml.runs.list
$this->apiErrors[513][0] = 'Too many results';
$this->apiErrors[513][1] = 'Given the constraints, there were still too many results. Please add constraints, to keep server load low. ';

// openml.estimationprocedure.list
$this->apiErrors[520][0] = 'No results';
$this->apiErrors[520][1] = 'There where no results. Please contact API team. ';

// openml.task.upload
$this->apiErrors[530][0] = 'Description file not present';
$this->apiErrors[530][1] = 'Please upload task description. ';

// for function: openml.task.upload
$this->apiErrors[531][0] = 'Xsd not found';
$this->apiErrors[531][1] = 'Please contact api support team';

// for function: openml.flow.upload
$this->apiErrors[532][0] = 'Problem validating uploaded description file';
$this->apiErrors[532][1] = 'The XML description format does not meet the standards';

// for function: openml.flow.upload
$this->apiErrors[533][0] = 'Task already exists.';
$this->apiErrors[533][1] = '';

// for function: openml.flow.upload
$this->apiErrors[534][0] = 'Error creating the task.';
$this->apiErrors[534][1] = '';


// openml.evaluations.list
$this->apiErrors[540][0] = 'Please provide at least task, flow or setup, uploader or run, to filter results. ';
$this->apiErrors[540][1] = 'The number of evaluations is huge. Please limit the result space. ';

// openml.evaluations.list
$this->apiErrors[541][0] = 'Input not safe';
$this->apiErrors[541][1] = 'The input parameters (task_id, setup_id, flow_id, run_id, uploader_id) did not meet the contrains (comma separated list of integers). ';

// openml.evaluations.list
$this->apiErrors[542][0] = 'No results';
$this->apiErrors[542][1] = 'There where no results. Check whether there are runs under this constraint. ';

// openml.evaluations.list
$this->apiErrors[543][0] = 'Too many results';
$this->apiErrors[543][1] = 'Given the constraints, there were still too many results. Please add constraints, to keep server load low. ';

// openml.flow.forcedelete
$this->apiErrors[550][0] = 'Admin rights are required.';
$this->apiErrors[550][1] = 'You can not execute this operation because you are not an admin.';



// openml.flow.forcedelete
$this->apiErrors[551][0] = 'Delete query failed.';
$this->apiErrors[551][1] = 'One of the delete queries failed.';


// openml.votes.list
$this->apiErrors[701][0] = 'List failed';
$this->apiErrors[701][1] = 'Votes do not exists';

// openml.votes.votesofuser
$this->apiErrors[702][0] = 'List failed';
$this->apiErrors[702][1] = 'Given user has no votes';

// openml.votes.delete
$this->apiErrors[703][0] = 'Unknown vote';
$this->apiErrors[703][1] = 'Vote by given user on given knowledge piece, does not exists';

// openml.votes.delete
$this->apiErrors[704][0] = 'Deletion failed';
$this->apiErrors[704][1] = 'Internal server error, please contact api administrators';

// openml.votes.do
$this->apiErrors[705][0] = 'Insertion failed';
$this->apiErrors[705][1] = 'Internal server error, please contact api administrators';

// openml.votes.do / openml.votes.delete
$this->apiErrors[711][0] = 'Unknown knowledge type';
$this->apiErrors[711][1] = 'The given knowledge type can not be voted on';

// openml.votes.delete
$this->apiErrors[721][0] = 'Unauthorized deletion';
$this->apiErrors[721][1] = "Can not delete someone else's vote";

// openml.votes.do
$this->apiErrors[722][0] = 'Unauthorized vote';
$this->apiErrors[722][1] = "Can not vote on own uploads";

// openml.votes.list
$this->apiErrors[801][0] = 'List failed';
$this->apiErrors[801][1] = 'Downloads do not exists';

// openml.votes.votesofuser
$this->apiErrors[802][0] = 'List failed';
$this->apiErrors[802][1] = 'Given user has no downloads';

// openml.votes.delete
$this->apiErrors[803][0] = 'Unknown vote';
$this->apiErrors[803][1] = 'Download by given user on given knowledge piece, does not exists';

// openml.votes.delete
$this->apiErrors[804][0] = 'Deletion failed';
$this->apiErrors[804][1] = 'Internal server error, please contact api administrators';

// openml.votes.do
$this->apiErrors[805][0] = 'Insertion failed';
$this->apiErrors[805][1] = 'Internal server error, please contact api administrators';

// openml.votes.do / openml.votes.delete
$this->apiErrors[811][0] = 'Unknown knowledge type';
$this->apiErrors[811][1] = 'The given knowledge type can not be downloaded on';

// openml.votes.delete
$this->apiErrors[821][0] = 'Unauthorized deletion';
$this->apiErrors[821][1] = "Can not delete someone else's download";

// openml.votes.do
$this->apiErrors[822][0] = 'Unauthorized vote';
$this->apiErrors[822][1] = "Can not download own uploads";


?>
