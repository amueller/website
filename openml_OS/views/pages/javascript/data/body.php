function expdbDatasets() {
	return [ <?php echo '"' . implode ( '","', $this->datasets ) . '"'; ?> ];
}

function expdbDatasetVersion() {
	return [ <?php echo '"' . implode ( '","', $this->datasetVesion ) . '"'; ?> ];
}

function expdbDatasetVersionOriginal() {
	return [ <?php echo '"' . implode ( '","', $this->datasetVesionOriginal ) . '"'; ?> ];
}

function expdbDatasetIDs() {
	return [ <?php echo '"' . implode ( '","', $this->datasetIds ) . '"'; ?> ];
}

function expdbEvaluationMetrics() {
	return [ <?php echo '"' . implode ( '","', $this->evaluationMetrics ) . '"'; ?> ];
}

function expdbClassificationEvaluationMetrics() {
	return [ <?php echo '"' . implode ( '","', $this->classificationEvaluationMetrics ) . '"'; ?> ];
}

function expdbRegressionEvaluationMetrics() {
	return [ <?php echo '"' . implode ( '","', $this->regressionEvaluationMetrics ) . '"'; ?> ];
}

function expdbAlgorithms() {
	return [ <?php echo '"' . implode ( '","', $this->algorithms ) . '"'; ?> ];
}

function expdbImplementations() {
	return [ <?php echo '"' . implode ( '","', $this->implementations ) . '"'; ?> ];
}

function expdbTaskTypes() {
	return [ <?php echo '"' . implode ( '","', $this->taskTypes ) . '"'; ?> ];
}
