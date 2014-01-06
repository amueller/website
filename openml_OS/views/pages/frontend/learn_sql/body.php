  <div class="container">


<div class="marketing" style="margin-top:10px;margin-left:auto;margin-right:auto;">
	<h1>Tutorial</h1>
	<p class="marketing-byline">we're just getting started</p>
</div>
<hr class="softennarrow">
          <div class="page-header">
            <h2>SQL Querying</h2>
          </div>
<div id="expdbschema2" style="overflow: scroll;"></div>

	  <div id="allmodals"></div>
 <?php o("modals.php");?>
<script>
function printModals() {
    $('#runModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#inputDataModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});
    $('#outputDataModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#dataModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#datasetModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#evaluationModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#modelModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#predictionModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#qualityModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#dataQualityModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#algorithmQualityModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#cvrunModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#bvrunModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#pprunModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#setupModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#algorithmSetupModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#functionSetupModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#workflowSetupModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#inputSettingModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#componentModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#implementationModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#inputModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#outputModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#algorithmModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#functionModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#workflowModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#experimentModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

    $('#experimentalVariableModal').children().each(function () {
	$('#allmodals').append($(this));
	$(this).css("max-height", "none");
	});

}

$(function(){
   printModals();
});
</script>
<style>
.modal-footer{
	display:none;
}</style>
</div> <!-- end container -->
