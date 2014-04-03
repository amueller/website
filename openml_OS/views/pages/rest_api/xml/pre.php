<?php
// for function: openml.global 
$this->apiErrors[100][0] = 'Function not valid';
$this->apiErrors[100][1] = 'Function not valid';

// for function: openml.global 
$this->apiErrors[101][0] = 'Function not yet ported or implemented';
$this->apiErrors[101][1] = 'Function not yet ported or implemented';

// for function: openml.data.description 
$this->apiErrors[110][0] = 'Please provide data_id';
$this->apiErrors[110][1] = 'Please provide data_id';

// for function: openml.data.description 
$this->apiErrors[111][0] = 'Unknown dataset';
$this->apiErrors[111][1] = 'Data set description with data_id was not found in the database';

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
$this->apiErrors[136][0] = 'Error slot open';
$this->apiErrors[136][1] = 'Error slot open, will be filled by not yet defined error';

// for function: openml.data.upload 
$this->apiErrors[137][0] = 'Please provide session_hash';
$this->apiErrors[137][1] = 'In order to share content, please authenticate (openml.authenticate) and provide session_hash';

// for function: openml.data.upload 
$this->apiErrors[138][0] = 'Authentication failed';
$this->apiErrors[138][1] = 'The session_hash was not valid. Please try to login again, or contact api administrators';

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

// for function: openml.tasks.search 
$this->apiErrors[150][0] = 'Please provide task_id';
$this->apiErrors[150][1] = 'Please provide task_id';

// for function: openml.tasks.search 
$this->apiErrors[151][0] = 'Unknown task';
$this->apiErrors[151][1] = 'The task with this id was not found in the database';

// for function: openml.implementation.upload 
$this->apiErrors[160][0] = 'Error in file uploading';
$this->apiErrors[160][1] = 'There was a problem with the file upload';

// for function: openml.implementation.upload 
$this->apiErrors[161][0] = 'Please provide description xml';
$this->apiErrors[161][1] = 'Please provide description xml';

// for function: openml.implementation.upload 
$this->apiErrors[162][0] = 'Please provide source or binary file';
$this->apiErrors[162][1] = 'Please provide source or binary file. It is also allowed to upload both';

// for function: openml.implementation.upload 
$this->apiErrors[163][0] = 'Problem validating uploaded description file';
$this->apiErrors[163][1] = 'The XML description format does not meet the standards';

// for function: openml.implementation.upload 
$this->apiErrors[164][0] = 'Implementation already stored in database';
$this->apiErrors[164][1] = 'Please change name or version number';

// for function: openml.implementation.upload 
$this->apiErrors[165][0] = 'Failed to insert implementation';
$this->apiErrors[165][1] = 'There can be many causes for this error. If you included the implements field, it should be an existing entry in the algorithm or math_function table. Otherwise it could be an internal server error. Please contact API support team. ';

// for function: openml.implementation.upload 
$this->apiErrors[166][0] = 'Failed to add implementation to database';
$this->apiErrors[166][1] = 'Internal server error, please contact api administrators';

// for function: openml.implementation.upload 
$this->apiErrors[167][0] = 'Illegal files uploaded';
$this->apiErrors[167][1] = 'An non required file was uploaded.';

// for function: openml.implementation.upload 
$this->apiErrors[168][0] = 'The provided md5 hash equals not the server generated md5 hash of the file';
$this->apiErrors[168][1] = 'The provided md5 hash equals not the server generated md5 hash of the file';

// for function: openml.implementation.upload 
$this->apiErrors[169][0] = 'Please provide session_hash';
$this->apiErrors[169][1] = 'In order to share content, please authenticate (openml.authenticate) and provide session_hash';

// for function: openml.implementation.upload 
$this->apiErrors[170][0] = 'Authentication failed';
$this->apiErrors[170][1] = 'The session_hash was not valid. Please try to login again, or contact api administrators';

// for function: openml.implementation.upload 
$this->apiErrors[171][0] = 'Implementation already exists';
$this->apiErrors[171][1] = 'This implementation is already in the database';

// for function: openml.implementation.get 
$this->apiErrors[180][0] = 'Please provide implementation_id';
$this->apiErrors[180][1] = 'Please provide implementation_id';

// for function: openml.implementation.get 
$this->apiErrors[181][0] = 'Unknown implementation';
$this->apiErrors[181][1] = 'The implementation with this ID was not found in the database';

// for function: openml.run.upload 
$this->apiErrors[200][0] = 'Please provide session_hash';
$this->apiErrors[200][1] = 'In order to share content, please authenticate (openml.authenticate) and provide session_hash';

// for function: openml.run.upload 
$this->apiErrors[201][0] = 'Authentication failed';
$this->apiErrors[201][1] = 'The session_hash was not valid. Please try to login again, or contact api administrators';

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
$this->apiErrors[205][0] = 'Unknown implementation';
$this->apiErrors[205][1] = 'The implementation with this id was not found in the database';

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
$this->apiErrors[209][0] = 'Unable to store cvrun';
$this->apiErrors[209][1] = 'Internal server error, please contact api administrators';

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
$this->apiErrors[213][1] = 'One of the parameters provided in the run xml is not registered as parameter for the implementation nor its components';

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
$this->apiErrors[217][1] = 'One of the provided evaluation measures could not be matched with a record in the math_function / implementation table.';

// for function: openml.run.upload
$this->apiErrors[218][0] = 'Wrong implementation associated with run: this implements a math_function';
$this->apiErrors[218][1] = 'The implementation implements a math_function, which is unable to generate predictions. Please select another implementation. ';

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

// for function: openml.implementation.owned
$this->apiErrors[310][0] = 'Please provide session_hash';
$this->apiErrors[310][1] = 'In order to view private content, please authenticate (openml.authenticate) and provide session_hash';

// for function: openml.implementation.owned
$this->apiErrors[311][0] = 'Authentication failed';
$this->apiErrors[311][1] = 'The session_hash was not valid. Please try to login again, or contact api administrators';

// for function: openml.implementation.owned
$this->apiErrors[312][0] = 'No implementations owned by this used';
$this->apiErrors[312][1] = 'The user has no implementations linked to his account';

// for function: openml.implementation.delete
$this->apiErrors[320][0] = 'Please provide session_hash';
$this->apiErrors[320][1] = 'In order to remove your content, please authenticate (openml.authenticate) and provide session_hash';

// for function: openml.implementation.delete
$this->apiErrors[321][0] = 'Authentication failed';
$this->apiErrors[321][1] = 'The session_hash was not valid. Please try to login again, or contact api administrators';

// for function: openml.implementation.delete
$this->apiErrors[322][0] = 'Implementation does not exists';
$this->apiErrors[322][1] = 'The implementation id could not be linked to an existing implementation.';

// for function: openml.implementation.delete
$this->apiErrors[323][0] = 'Implementation is not owned by you';
$this->apiErrors[323][1] = 'The implementation was owned by another user. Hence you cannot delete it.';

// for function: openml.implementation.delete
$this->apiErrors[324][0] = 'Implementation is in use by other content. Can not be deleted';
$this->apiErrors[324][1] = 'The implementation is used in runs, evaluations or as component of another implementation. Delete this other content before deleting this implementation. ';

// for function: openml.implementation.delete
$this->apiErrors[325][0] = 'Deleting implementation failed.';
$this->apiErrors[325][1] = 'Deleting the implementation failed. Please contact support team. ';

// for function: openml.implementation.exists
$this->apiErrors[330][0] = 'Mandatory fields not present.';
$this->apiErrors[330][1] = 'Please provide one of the following mandatory field combination: name and external_version. ';

// for function: openml.run.getjob
$this->apiErrors[340][0] = 'Please provide workbench and task type.';
$this->apiErrors[340][1] = 'Please provide workbench and task type.';

// for function: openml.run.getjob
$this->apiErrors[341][0] = 'No jobs available.';
$this->apiErrors[341][1] = 'There are no jobs that need to be executed.';

// for function: openml.data.delete
$this->apiErrors[350][0] = 'Please provide session_hash';
$this->apiErrors[350][1] = 'In order to remove your content, please authenticate (openml.authenticate) and provide session_hash';

// for function: openml.data.delete
$this->apiErrors[351][0] = 'Authentication failed';
$this->apiErrors[351][1] = 'The session_hash was not valid. Please try to login again, or contact api administrators';

// for function: openml.data.delete
$this->apiErrors[352][0] = 'Dataset does not exists';
$this->apiErrors[352][1] = 'The data id could not be linked to an existing dataset.';

// for function: openml.data.delete
$this->apiErrors[353][0] = 'Dataset is not owned by you';
$this->apiErrors[353][1] = 'The dataset was owned by another user. Hence you cannot delete it.';

// for function: openml.data.delete
$this->apiErrors[354][0] = 'Dataset is in use by other content. Can not be deleted';
$this->apiErrors[354][1] = 'The data is used in runs. Delete this other content before deleting this implementation. ';

// for function: openml.data.delete
$this->apiErrors[355][0] = 'Deleting dataset failed.';
$this->apiErrors[355][1] = 'Deleting the dataset failed. Please contact support team. ';
?>
