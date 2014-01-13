INSERT INTO `estimation_procedure` (`id`, `ttid`, `name`, `type`, `repeats`, `folds`, `percentage`, `stratified_sampling`) VALUES
(1, 1, '10-fold Crossvalidation', 'crossvalidation', 1, 10, NULL, 'true'),
(2, 1, '5 times 2-fold Crossvalidation', 'crossvalidation', 5, 2, NULL, 'true'),
(3, 1, '10 times 10-fold Crossvalidation', 'crossvalidation', 10, 10, NULL, 'true'),
(4, 1, 'Leave one out', 'leaveoneout', 1, NULL, NULL, 'false'),
(5, 1, '10% Holdout set', 'holdout', 1, NULL, 33, 'true'),
(6, 1, '33% Holdout set', 'holdout', 1, NULL, 33, 'true'),
(7, 2, '10-fold Crossvalidation', 'crossvalidation', 1, 10, NULL, 'false'),
(8, 2, '5 times 2-fold Crossvalidation', 'crossvalidation', 5, 2, NULL, 'false'),
(9, 2, '10 times 10-fold Crossvalidation', 'crossvalidation', 10, 10, NULL, 'false'),
(10, 2, 'Leave one out', 'leaveoneout', 1, NULL, NULL, 'false'),
(11, 2, '10% Holdout set', 'holdout', 1, NULL, 33, 'false'),
(12, 2, '33% Holdout set', 'holdout', 1, NULL, 33, 'false');