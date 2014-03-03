INSERT INTO `task_type_io` (`ttid`, `name`, `io`, `description`, `template`) VALUES
(1, 'estimation_procedure', 'input', 'The estimation procedure used to validate the generated models', '<oml:estimation_procedure>\r\n<oml:type>[INPUT:3]</oml:type>\r\n<oml:data_splits_url>[INPUT:4]</oml:data_splits_url>\r\n<oml:parameter name="number_repeats">[INPUT:5]</oml:parameter>\r\n<oml:parameter name="number_folds">[INPUT:6]</oml:parameter>\r\n<oml:parameter name="percentage">[INPUT:7]</oml:parameter>\r\n<oml:parameter name="stratified_sampling">[INPUT:8]</oml:parameter>\r\n</oml:estimation_procedure>'),
(1, 'evaluation_measures', 'input', 'The evaluation measures to optimize for, e.g., cpu time, accurancy', '<oml:evaluation_measures>\r\n<oml:evaluation_measure>[INPUT:9]</oml:evaluation_measure>\r\n</oml:evaluation_measures>'),
(1, 'predictions', 'output', 'The desired output format', '<oml:predictions>\r\n<oml:format>ARFF</oml:format>\r\n<oml:feature name="repeat" type="integer"/>\r\n<oml:feature name="fold" type="integer"/>\r\n<oml:feature name="row_id" type="integer"/>\r\n<oml:feature name="confidence.classname" type="numeric"/>\r\n<oml:feature name="prediction" type="string"/>\r\n</oml:predictions>'),
(1, 'source_data', 'input', 'The dataset and target feature of a task', '<oml:data_set>\r\n<oml:data_set_id>[INPUT:1]</oml:data_set_id>\r\n<oml:target_feature>[INPUT:2]</oml:target_feature>\r\n</oml:data_set>'),
(2, 'estimation_procedure', 'input', 'The estimation procedure used to validate the generated models', '<oml:estimation_procedure>\r\n<oml:type>[INPUT:3]</oml:type>\r\n<oml:data_splits_url>[INPUT:4]</oml:data_splits_url>\r\n<oml:parameter name="number_repeats">[INPUT:5]</oml:parameter>\r\n<oml:parameter name="number_folds">[INPUT:6]</oml:parameter>\r\n<oml:parameter name="percentage">[INPUT:7]</oml:parameter>\r\n<oml:parameter name="stratified_sampling">[INPUT:8]</oml:parameter>\r\n</oml:estimation_procedure>'),
(2, 'evaluation_measures', 'input', 'The evaluation measures to optimize for, e.g., cpu time, accurancy', '<oml:evaluation_measures>\r\n<oml:evaluation_measure>[INPUT:9]</oml:evaluation_measure>\r\n</oml:evaluation_measures>'),
(2, 'predictions', 'output', 'The desired output format', '<oml:predictions>\r\n<oml:format>ARFF</oml:format>\r\n<oml:feature name="repeat" type="integer"/>\r\n<oml:feature name="fold" type="integer"/>\r\n<oml:feature name="row_id" type="integer"/>\r\n<oml:feature name="prediction" type="string"/>\r\n</oml:predictions>'),
(2, 'source_data', 'input', 'The dataset and target feature of a task', '<oml:data_set>\r\n<oml:data_set_id>[INPUT:1]</oml:data_set_id>\r\n<oml:target_feature>[INPUT:2]</oml:target_feature>\r\n</oml:data_set>'),
(3, 'estimation_procedure', 'input', 'The estimation procedure used to validate the generated models', '<oml:estimation_procedure>\r\n<oml:type>[INPUT:3]</oml:type>\r\n<oml:data_splits_url>[INPUT:4]</oml:data_splits_url>\r\n<oml:parameter name="number_repeats">[INPUT:5]</oml:parameter>\r\n<oml:parameter name="number_folds">[INPUT:6]</oml:parameter>\r\n<oml:parameter name="number_samples">[INPUT:10]</oml:parameter>\r\n</oml:estimation_procedure>'),
(3, 'evaluation_measures', 'input', 'The evaluation measures to optimize for, e.g., cpu time, accurancy', '<oml:evaluation_measures>\r\n<oml:evaluation_measure>[INPUT:6]</oml:evaluation_measure>\r\n</oml:evaluation_measures>'),
(3, 'predictions', 'output', 'The desired output format', '<oml:predictions>\r\n<oml:format>ARFF</oml:format>\r\n<oml:feature name="repeat" type="integer"/>\r\n<oml:feature name="fold" type="integer"/>\r\n<oml:feature name="sample" type="integer"/>\r\n<oml:feature name="row_id" type="integer"/>\r\n<oml:feature name="confidence.classname" type="numeric"/>\r\n<oml:feature name="prediction" type="string"/>\r\n</oml:predictions>'),
(3, 'source_data', 'input', 'The dataset and target feature of a task', '<oml:data_set>\r\n<oml:data_set_id>[INPUT:1]</oml:data_set_id>\r\n<oml:target_feature>[INPUT:2]</oml:target_feature>\r\n</oml:data_set>'),
(4, 'estimation_procedure', 'input', 'The estimation procedure used to validate the generated models', '<oml:estimation_procedure>\r\n<oml:type>[INPUT:3]</oml:type></oml:estimation_procedure>'),
(4, 'evaluation_measures', 'input', 'The evaluation measures to optimize for, e.g., cpu time, accurancy', '<oml:evaluation_measures>\r\n<oml:evaluation_measure>[INPUT:4]</oml:evaluation_measure>\r\n</oml:evaluation_measures>'),
(4, 'predictions', 'output', 'The desired output format', '<oml:predictions>\r\n<oml:format>ARFF</oml:format>\r\n<oml:feature name="repeat" type="integer"/>\r\n<oml:feature name="fold" type="integer"/>\r\n<oml:feature name="row_id" type="integer"/>\r\n<oml:feature name="confidence.classname" type="numeric"/>\r\n<oml:feature name="prediction" type="string"/>\r\n</oml:predictions>'),
(4, 'source_data', 'input', 'The dataset and target feature of a task', '<oml:data_set>\r\n<oml:data_set_id>[INPUT:1]</oml:data_set_id>\r\n<oml:target_feature>[INPUT:2]</oml:target_feature>\r\n</oml:data_set>');
