/// Wiki

$("#gollum-editor-message-field").val("Write a small message explaining the change.");
$("#gollum-editor-submit").addClass("btn btn-success pull-left");
$("#gollum-editor-preview").removeClass("minibutton");
$("#gollum-editor-preview").addClass("btn btn-default padded-button");
$("#function-help").addClass("wiki-help-button");
$("#function-help").html("Need help?");
$("#gollum-editor-preview").attr("href","preview");
$("#version-form").attr('action', "d/<?php echo $this->id; ?>/compare/<?php echo $this->wikipage; ?>");
$("a[title*='View commit']").each(function() {
   var _href = $(this).attr("href");
   $(this).attr('href', 'd/<?php echo $this->id; ?>/view' + _href);
});

$( "#gollum-editor-preview" ).click(function() {
	var $form = $($('#gollum-editor form').get(0));
        $form.attr('action', '');
});

$("a[title*='View commit']").each(function() {
   var _href = $(this).attr("href");
   $(this).attr('href', 'd/<?php echo $this->id; ?>/view' + _href);
});

/// Feature graphs
<?php

$fgraphs = '';
$fgraphs_all = '';

if (!empty($this->data['features'])){
	$featCount = 0;
	foreach( $this->features as $r ) {
		$newGraph = '';
			if($r->{'data_type'} == "numeric"){
			$newGraph = '$(\'#feat'.$r->{'index'}.'\').highcharts({chart:{type:\'boxplot\',inverted:true,backgroundColor:null},exporting:false,credits:false,title: null,legend:{enabled: false},tooltip:false,xAxis:{title:null,labels:{enabled:false},tickLength:0},yAxis:{title:null,labels:{style:{fontSize:\'8px\'}}},series: [{data: [['.$r->{'MinimumValue'}.','.($r->{'MeanValue'}-$r->{'StandardDeviation'}).','.$r->{'MeanValue'}.','.($r->{'MeanValue'}+$r->{'StandardDeviation'}).','.$r->{'MaximumValue'}.']]}]});';
		} else if (strlen($r->{'ClassDistribution'})>0) {
			$distro = json_decode($r->{'ClassDistribution'});
      if(count($distro)>0){
			   $newGraph = '$(\'#feat'.$r->{'index'}.'\').highcharts({chart:{type:\'column\',backgroundColor:null},exporting:false,credits:false,title:false,xAxis:{title:false,labels:{'.(count($distro[0])>10 ? 'enabled:false' : 'style:{fontSize:\'9px\'}').'},tickLength:0,categories:[\''.implode("','", str_replace("'", "", $distro[0])).'\']},yAxis:{min:0,title:false,gridLineWidth:0,minorGridLineWidth:0,labels:{enabled:false},stackLabels:{enabled:true,useHTML:true,style:{fontSize:\'9px\'}}},legend:{enabled: false},tooltip:{useHTML:true,shared:true},plotOptions:{column:{stacking:\'normal\'}},series:[';

		for($i=0; $i<count($this->classvalues); $i++){
			$newGraph .= '{name:\''.$this->classvalues[$i].'\',data:['.implode(",",array_column($distro[1], $i)).']}';
			if($i!=count($this->classvalues)-1)
				$newGraph .= ',';
		}
		if(count($this->classvalues)==0){
			$newGraph .= '{name:\'count\',data:['.implode(",",array_column($distro[1], 0)).']}';
		}
		$newGraph .= ']});';
    }
		}
		if($featCount<3 or $this->showallfeatures){
			$fgraphs = $newGraph . PHP_EOL . $fgraphs;
			$featCount = $featCount + 1;
		}
		else
			$fgraphs_all = $newGraph . PHP_EOL . $fgraphs_all;
		}
	}


  if(isset($fgraphs)){
	echo $fgraphs;
	echo 'function visualize_all(){'.$fgraphs_all.'}';
	}

?>

//Update form
$(function() {
		$('#licence').change(function(){
				$('.licences').hide();
				$('#' + $(this).val()).show();
		});
});

$(document)
	.on('change', '.btn-file :file', function() {
		var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
	$('.btn-file :file').on('fileselect', function(event, numFiles, label) {

		var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;

		if( input.length ) {
			input.val(log);
		} else {
			if( log ) alert(log);
		}

	});
});

$('#comment').bind('input', function() {
		var cname = $(this).val();
		if(cname.length > 0){
			 $(this).parent().removeClass('has-error');
			 $(this).parent().addClass('has-success');
		} else {
			 $(this).parent().removeClass('has-success');
			 $(this).parent().addClass('has-error');
		}
});
