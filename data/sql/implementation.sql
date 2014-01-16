INSERT INTO `implementation`(`fullName`, `name`, `version`, `creator`, `contributor`, `uploadDate`, `licence`, `language`, `description`, `fullDescription`, `installationNotes`, `dependencies`, `implements`) VALUES 
('openml.evaluation.EuclideanDistance(1.0)','openml.evaluation.EuclideanDistance','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "EuclideanDistance"','','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','EuclideanDistance'),
('openml.evaluation.PolynomialKernel(1.0)','openml.evaluation.PolynomialKernel','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "PolynomialKernel"','','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','PolynomialKernel'),
('openml.evaluation.RBFKernel(1.0)','openml.evaluation.RBFKernel','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "RBFKernel"','','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','RBFKernel'),
('openml.evaluation.area_under_roc_curve(1.0)','openml.evaluation.area_under_roc_curve','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "area_under_roc_curve"','The area under the ROC curve (AUROC), calculated using the Mann-Whitney U-test.

The curve is constructed by shifting the threshold for a positive prediction from 0 to 1, yielding a series of true positive rates (TPR) and false positive rates (FPR), from which a step-wise ROC curve can be constructed.

See http://en.wikipedia.org/wiki/Receiver_operating_characteristic

Note that this is different from the Area Under the ROC Convex Hull (ROC AUCH).

AUROC is defined only for a specific class value, and should thus be labeled with the class value for which is was computed. Use the mean_weighted_area_under_roc_curve for the weighted average over all class values.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','area_under_roc_curve'),
('openml.evaluation.average_cost(1.0)','openml.evaluation.average_cost','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "average_cost"','','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','average_cost'),
('openml.evaluation.build_cpu_time(1.0)','openml.evaluation.build_cpu_time','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "build_cpu_time"','The time in seconds to build a single model on all data.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','build_cpu_time'),
('openml.evaluation.build_memory(1.0)','openml.evaluation.build_memory','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "build_memory"','The memory, in bytes, needed to build a single model on all data.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','build_memory'),
('openml.evaluation.class_complexity(1.0)','openml.evaluation.class_complexity','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "class_complexity"','Entropy, in bits, of the class distribution generated by the model\'s predictions. Calculated by taking the sum of -log2(predictedProb) over all instances, where predictedProb is the probability (according to the model) of the actual class for that instance. If instances are weighted, the weighted sum is taken.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','class_complexity'),
('openml.evaluation.class_complexity_gain(1.0)','openml.evaluation.class_complexity_gain','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "class_complexity_gain"','Entropy reduction, in bits, between the class distribution generated by the model\'s predictions, and the prior class distribution. Calculated by taking the difference of the prior_class_complexity and the class_complexity.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','class_complexity_gain'),
('openml.evaluation.confusion_matrix(1.0)','openml.evaluation.confusion_matrix','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "confusion_matrix"','None','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','confusion_matrix'),
('openml.evaluation.correlation_coefficient(1.0)','openml.evaluation.correlation_coefficient','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "correlation_coefficient"','None','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','correlation_coefficient'),
('openml.evaluation.f_measure(1.0)','openml.evaluation.f_measure','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "f_measure"','The F-Measure is the harmonic mean of precision and recall, also known as the the traditional F-measure, balanced F-score, or F1-score:

Formula:
2*Precision*Recall/(Precision+Recall)

See:
http://en.wikipedia.org/wiki/Precision_and_recall

F-measure is defined only for a specific class value, and should thus be labeled with the class value for which is was computed. Use the mean_weighted_f_measure for the weighted average over all class values.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','f_measure'),
('openml.evaluation.kappa(1.0)','openml.evaluation.kappa','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "kappa"','None','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','kappa'),
('openml.evaluation.kb_relative_information_score(1.0)','openml.evaluation.kb_relative_information_score','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "kb_relative_information_score"','The Kononenko and Bratko Information score, divided by the prior entropy of the class distribution.

See:
Kononenko, I., Bratko, I.: Information-based evaluation criterion for classier\'s performance. Machine
Learning 6 (1991) 67-80','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','kb_relative_information_score'),
('openml.evaluation.kohavi_wolpert_bias_squared(1.0)','openml.evaluation.kohavi_wolpert_bias_squared','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "kohavi_wolpert_bias_squared"','Bias component (squared) of the bias-variance decomposition as defined by Kohavi and Wolpert in:

R. Kohavi &amp; D. Wolpert (1996), Bias plus variance decomposition for zero-one loss functions, in Proc. of the Thirteenth International Machine Learning Conference (ICML96)

This quantity measures how closely
the learning algorithms average guess over all possible training sets of the given training set size matches the target.

Estimated using the classifier using the sub-sampled cross-validation procedure as specified in:

Geoffrey I. Webb &amp; Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','kohavi_wolpert_bias_squared'),
('openml.evaluation.kohavi_wolpert_error(1.0)','openml.evaluation.kohavi_wolpert_error','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "kohavi_wolpert_error"','Error rate measured in the bias-variance decomposition as defined by Kohavi and Wolpert in:

R. Kohavi &amp; D. Wolpert (1996), Bias plus variance decomposition for zero-one loss functions, in Proc. of the Thirteenth International Machine Learning Conference (ICML96)

Estimated using the classifier using the sub-sampled cross-validation procedure as specified in:

Geoffrey I. Webb &amp; Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','kohavi_wolpert_error'),
('openml.evaluation.kohavi_wolpert_sigma_squared(1.0)','openml.evaluation.kohavi_wolpert_sigma_squared','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "kohavi_wolpert_sigma_squared"','Intrinsic error component (squared) of the bias-variance decomposition as defined by Kohavi and Wolpert in:

R. Kohavi and D. Wolpert (1996), Bias plus variance decomposition for zero-one loss functions, in Proc. of the Thirteenth International Machine Learning Conference (ICML96)

This quantity is a lower bound on the expected cost of any learning algorithm. It is the expected cost of the Bayes optimal classifier.

Estimated using the classifier using the sub-sampled cross-validation procedure as specified in:

Geoffrey I. Webb &amp; Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','kohavi_wolpert_sigma_squared'),
('openml.evaluation.kohavi_wolpert_variance(1.0)','openml.evaluation.kohavi_wolpert_variance','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "kohavi_wolpert_variance"','Variance component of the bias-variance decomposition as defined by Kohavi and Wolpert in:

R. Kohavi and D. Wolpert (1996), Bias plus variance decomposition for zero-one loss functions, in Proc. of the Thirteenth International Machine Learning Conference (ICML96)

This quantity measures how much the
learning algorithms guess &quot;bounces around&quot; for the different training sets of the given size.

Estimated using the classifier using the sub-sampled cross-validation procedure as specified in:

Geoffrey I. Webb &amp; Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','kohavi_wolpert_variance'),
('openml.evaluation.kononenko_bratko_information_score(1.0)','openml.evaluation.kononenko_bratko_information_score','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "kononenko_bratko_information_score"','Kononenko and Bratko Information score. This measures predictive accuracy but eliminates the influence of prior probabilities.

See:
Kononenko, I., Bratko, I.: Information-based evaluation criterion for classier\'s performance. Machine
Learning 6 (1991) 67-80','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','kononenko_bratko_information_score'),
('openml.evaluation.matthews_correlation_coefficient(1.0)','openml.evaluation.matthews_correlation_coefficient','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "matthews_correlation_coefficient"','None','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','matthews_correlation_coefficient'),
('openml.evaluation.mean_absolute_error(1.0)','openml.evaluation.mean_absolute_error','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_absolute_error"','The mean absolute error (MAE) measures how close the model\'s predictions are to the actual target values. It is the sum of the absolute value of the difference of each instance prediction and the actual value. For classification, the 0/1-error is used.

&lt;math&gt;\mathrm{MAE} = \frac{1}{n}\sum_{i=1}^n \left| f_i-y_i\right| =\frac{1}{n}\sum_{i=1}^n \left| e_i \right|.&lt;/math&gt;

See:
http://en.wikipedia.org/wiki/Mean_absolute_error','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_absolute_error'),
('openml.evaluation.mean_class_complexity(1.0)','openml.evaluation.mean_class_complexity','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_class_complexity"','The entropy of the class distribution generated by the model (see class_complexity), divided by the number of instances in the input data.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_class_complexity'),
('openml.evaluation.mean_class_complexity_gain(1.0)','openml.evaluation.mean_class_complexity_gain','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_class_complexity_gain"','The entropy gain of the class distribution  by the model over the prior distribution (see class_complexity_gain), divided by the number of instances in the input data.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_class_complexity_gain'),
('openml.evaluation.mean_f_measure(1.0)','openml.evaluation.mean_f_measure','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_f_measure"','None','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_f_measure'),
('openml.evaluation.mean_kononenko_bratko_information_score(1.0)','openml.evaluation.mean_kononenko_bratko_information_score','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_kononenko_bratko_information_score"','Kononenko and Bratko Information score, see kononenko_bratko_information_score, divided by the number of instances in the input data.

See:
Kononenko, I., Bratko, I.: Information-based evaluation criterion for classier\'s performance. Machine
Learning 6 (1991) 67-80','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_kononenko_bratko_information_score'),
('openml.evaluation.mean_precision(1.0)','openml.evaluation.mean_precision','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_precision"','None','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_precision'),
('openml.evaluation.mean_prior_absolute_error(1.0)','openml.evaluation.mean_prior_absolute_error','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_prior_absolute_error"','The mean prior absolute error (MPAE) is the mean absolute error (see mean_absolute_error) of the prior (e.g., default class prediction).

See:
http://en.wikipedia.org/wiki/Mean_absolute_error','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_prior_absolute_error'),
('openml.evaluation.mean_prior_class_complexity(1.0)','openml.evaluation.mean_prior_class_complexity','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_prior_class_complexity"','The entropy of the class distribution of the prior (see prior_class_complexity), divided by the number of instances in the input data.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_prior_class_complexity'),
('openml.evaluation.mean_recall(1.0)','openml.evaluation.mean_recall','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_recall"','None','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_recall'),
('openml.evaluation.mean_weighted_area_under_roc_curve(1.0)','openml.evaluation.mean_weighted_area_under_roc_curve','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_weighted_area_under_roc_curve"','None','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_weighted_area_under_roc_curve'),
('openml.evaluation.mean_weighted_f_measure(1.0)','openml.evaluation.mean_weighted_f_measure','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_weighted_f_measure"','None','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_weighted_f_measure'),
('openml.evaluation.mean_weighted_precision(1.0)','openml.evaluation.mean_weighted_precision','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_weighted_precision"','None','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_weighted_precision'),
('openml.evaluation.mean_weighted_recall(1.0)','openml.evaluation.mean_weighted_recall','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "mean_weighted_recall"','None','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','mean_weighted_recall'),
('openml.evaluation.precision(1.0)','openml.evaluation.precision','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "precision"','Precision is defined as the number of true positive (TP) predictions, divided by the sum of the number of true positives and false positives (TP+FP):

&lt;math&gt;\text{Precision}=\frac{tp}{tp+fp} \, &lt;/math&gt;

It is also referred to as the Positive predictive value (PPV).

See:
http://en.wikipedia.org/wiki/Precision_and_recall

Precision is defined only for a specific class value, and should thus be labeled with the class value for which is was computed. Use the mean_weighted_precision for the weighted average over all class values.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','precision'),
('openml.evaluation.predictive_accuracy(1.0)','openml.evaluation.predictive_accuracy','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "predictive_accuracy"','The Predictive Accuracy is the percentage of instances that are classified correctly. Is it 1 - ErrorRate.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','predictive_accuracy'),
('openml.evaluation.prior_class_complexity(1.0)','openml.evaluation.prior_class_complexity','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "prior_class_complexity"','Entropy, in bits, of the prior class distribution. Calculated by taking the sum of -log2(priorProb) over all instances, where priorProb is the prior probability of the actual class for that instance. If instances are weighted, the weighted sum is taken.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','prior_class_complexity'),
('openml.evaluation.prior_entropy(1.0)','openml.evaluation.prior_entropy','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "prior_entropy"','Entropy, in bits, of the prior class distribution. Calculated by taking the sum of -log2(priorProb) over all instances, where priorProb is the prior probability of the actual class for that instance. If instances are weighted, the weighted sum is taken.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','prior_entropy'),
('openml.evaluation.recall(1.0)','openml.evaluation.recall','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "recall"','Recall is defined as the number of true positive (TP) predictions, divided by the sum of the number of true positives and false negatives (TP+FN):

&lt;math&gt;\text{Recall}=\frac{tp}{tp+fn} \, &lt;/math&gt;

It is also referred to as the True Positive Rate (TPR) or Sensitivity.

See:
http://en.wikipedia.org/wiki/Precision_and_recall

Recall is defined only for a specific class value, and should thus be labeled with the class value for which is was computed. Use the mean_weighted_recall for the weighted average over all class values.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','recall'),
('openml.evaluation.relative_absolute_error(1.0)','openml.evaluation.relative_absolute_error','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "relative_absolute_error"','The Relative Absolute Error (RAE) is the mean absolute error (MAE) divided by the mean prior absolute error (MPAE).','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','relative_absolute_error'),
('openml.evaluation.root_mean_prior_squared_error(1.0)','openml.evaluation.root_mean_prior_squared_error','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "root_mean_prior_squared_error"','The Root Mean Prior Squared Error (RMPSE) is the Root Mean Squared Error (RMSE) of the prior (e.g., the default class prediction).','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','root_mean_prior_squared_error'),
('openml.evaluation.root_mean_squared_error(1.0)','openml.evaluation.root_mean_squared_error','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "root_mean_squared_error"','The Root Mean Squared Error (RMSE) measures how close the model\'s predictions are to the actual target values. It is the square root of the Mean Squared Error (MSE), the sum of the squared differences between the predicted value and the actual value. For classification, the 0/1-error is used.

:&lt;math&gt;\operatorname{MSE}(\overline{X})=\operatorname{E}((\overline{X}-\mu)^2)=\left(\frac{\sigma}{\sqrt{n}}\right)^2= \frac{\sigma^2}{n}&lt;/math&gt;

See:
http://en.wikipedia.org/wiki/Mean_squared_error','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','root_mean_squared_error'),
('openml.evaluation.root_relative_squared_error(1.0)','openml.evaluation.root_relative_squared_error','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "root_relative_squared_error"','The Root Relative Squared Error (RRSE) is the Root Mean Squared Error (RMSE) divided by the Root Mean Prior Squared Error (RMPSE). See root_mean_squared_error and root_mean_prior_squared_error.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','root_relative_squared_error'),
('openml.evaluation.run_cpu_time(1.0)','openml.evaluation.run_cpu_time','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "run_cpu_time"','Runtime in seconds of the entire run. In the case of cross-validation runs, this will include all iterations.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','run_cpu_time'),
('openml.evaluation.run_memory(1.0)','openml.evaluation.run_memory','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "run_memory"','Amount of memory, in bytes, used during  the entire run.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','run_memory'),
('openml.evaluation.run_virtual_memory(1.0)','openml.evaluation.run_virtual_memory','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "run_virtual_memory"','Amount of virtual memory, in bytes, used during  the entire run.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','run_virtual_memory'),
('openml.evaluation.single_point_area_under_roc_curve(1.0)','openml.evaluation.single_point_area_under_roc_curve','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "single_point_area_under_roc_curve"','','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','single_point_area_under_roc_curve'),
('openml.evaluation.total_cost(1.0)','openml.evaluation.total_cost','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "total_cost"','','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','total_cost'),
('openml.evaluation.unclassified_instance_count(1.0)','openml.evaluation.unclassified_instance_count','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "unclassified_instance_count"','Number of instances that were not classified by the model.','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','unclassified_instance_count'),
('openml.evaluation.webb_bias(1.0)','openml.evaluation.webb_bias','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "webb_bias"','Bias component (squared) of the bias-variance decomposition as defined by Webb in:

Geoffrey I. Webb (2000), MultiBoosting: A Technique for Combining Boosting and Wagging, Machine Learning, 40(2), pages 159-196.

This quantity measures how closely
the learning algorithms average guess over all possible training sets of the given training set size matches the target.

Estimated using the classifier using the sub-sampled cross-validation procedure as specified in:

Geoffrey I. Webb &amp; Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','webb_bias'),
('openml.evaluation.webb_error(1.0)','openml.evaluation.webb_error','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "webb_error"','Intrinsic error component (squared) of the bias-variance decomposition as defined by Webb in:

Geoffrey I. Webb (2000), MultiBoosting: A Technique for Combining Boosting and Wagging, Machine Learning, 40(2), pages 159-196.

This quantity is a lower bound on the expected cost of any learning algorithm. It is the expected cost of the Bayes optimal classifier.

Estimated using the classifier using the sub-sampled cross-validation procedure as specified in:

Geoffrey I. Webb &amp; Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','webb_error'),
('openml.evaluation.webb_variance(1.0)','openml.evaluation.webb_variance','1.0','Jan N. van Rijn','"Bernd Bischl","Luis Torgo","Bo Gao","Venkatesh Umaashankar","Simon Fischer","Patrick Winter","Bernd Wiswedel","Michael R. Berthold","Joaquin Vanschoren"','2014-01-16 14:12:56','public domain','english','An implementation of the evaluation measure "webb_variance"','Variance component of the bias-variance decomposition as defined by Webb in:

Geoffrey I. Webb (2000), MultiBoosting: A Technique for Combining Boosting and Wagging, Machine Learning, 40(2), pages 159-196.

This quantity measures how much the
learning algorithms guess &quot;bounces around&quot; for the different training sets of the given size.

Estimated using the classifier using the sub-sampled cross-validation procedure as specified in:

Geoffrey I. Webb &amp; Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia','Runs on OpenML servers','Build on top of Weka API (Jar version 3.?.?)','webb_variance');
