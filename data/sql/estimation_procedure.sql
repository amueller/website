INSERT INTO `estimation_procedure` (`id`, `ttid`, `name`, `type`, `repeats`, `folds`, `percentage`, `stratified_sampling`, `custom_testset`, `date`) VALUES
(1, 1, '10-fold Crossvalidation', 'crossvalidation', 1, 10, NULL, 'true', 'false', '2014-12-31 23:00:00'),
(2, 1, '5 times 2-fold Crossvalidation', 'crossvalidation', 5, 2, NULL, 'true', 'false', '2014-12-31 23:00:00'),
(3, 1, '10 times 10-fold Crossvalidation', 'crossvalidation', 10, 10, NULL, 'true', 'false', '2014-12-31 23:00:00'),
(4, 1, 'Leave one out', 'leaveoneout', 1, NULL, NULL, 'false', 'false', '2014-12-31 23:00:00'),
(5, 1, '10% Holdout set', 'holdout', 1, NULL, 33, 'true', 'false', '2014-12-31 23:00:00'),
(6, 1, '33% Holdout set', 'holdout', 1, NULL, 33, 'true', 'false', '2014-12-31 23:00:00'),
(7, 2, '10-fold Crossvalidation', 'crossvalidation', 1, 10, NULL, 'false', 'false', '2014-12-31 23:00:00'),
(8, 2, '5 times 2-fold Crossvalidation', 'crossvalidation', 5, 2, NULL, 'false', 'false', '2014-12-31 23:00:00'),
(9, 2, '10 times 10-fold Crossvalidation', 'crossvalidation', 10, 10, NULL, 'false', 'false', '2014-12-31 23:00:00'),
(10, 2, 'Leave one out', 'leaveoneout', 1, NULL, NULL, 'false', 'false', '2014-12-31 23:00:00'),
(11, 2, '10% Holdout set', 'holdout', 1, NULL, 33, 'false', 'false', '2014-12-31 23:00:00'),
(12, 2, '33% Holdout set', 'holdout', 1, NULL, 33, 'false', 'false', '2014-12-31 23:00:00'),
(13, 3, '10-fold Learning Curve', 'learningcurve', 1, 10, NULL, 'true', 'false', '2014-12-31 23:00:00'),
(14, 3, '10 times 10-fold Learning Curve', 'learningcurve', 10, 10, NULL, 'true', 'false', '2014-12-31 23:00:00'),
(15, 4, 'Interleaved Test then Train', 'testthentrain', NULL, NULL, NULL, NULL, 'false', '2014-12-31 23:00:00'),
(16, 1, 'Custom Holdout', 'customholdout', 1, 1, NULL, 'false', 'true', '2014-12-31 23:00:00'),
(17, 5, '50 times Clustering', 'testontrainingdata', 50, NULL, NULL, NULL, 'false', '2014-12-31 23:00:00'),
(18, 6, 'Holdout unlabeled', 'holdoutunlabeled', 1, 1, NULL, 'false', 'false', '2014-12-31 23:00:00'),
(19, 7, '10-fold Crossvalidation', 'crossvalidation', 1, 10, NULL, 'true', 'false', '2014-12-31 23:00:00'),
(20, 7, '5 times 2-fold Crossvalidation', 'crossvalidation', 5, 2, NULL, 'true', 'false', '2014-12-31 23:00:00'),
(21, 7, '10 times 10-fold Crossvalidation', 'crossvalidation', 10, 10, NULL, 'true', 'false', '2014-12-31 23:00:00'),
(22, 7, 'Leave one out', 'leaveoneout', 1, NULL, NULL, 'false', 'false', '2014-12-31 23:00:00'),
(23, 1, '100 times 10-fold Crossvalidation', 'crossvalidation', 100, 10, NULL, 'true', 'false', '2015-09-02 14:18:37'),
(24, 2, 'Custom 10-fold Crossvalidation', 'customholdout', 1, 10, NULL, 'false', 'true', '2015-09-20 20:44:44'),
(25, 1, '4-fold Crossvalidation', 'crossvalidation', 1, 4, NULL, 'true', 'false', '2016-03-15 15:32:10'),
(26, 9, 'Interleaved Test then Train (Batch)', 'testthentrain', NULL, NULL, NULL, NULL, 'false', '2016-12-27 12:09:37');
