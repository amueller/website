$(document).ready( function() {
  //check for change on the categories menu
  $('#form-task-type-tabs li a').eq($('#selectTaskType option:selected').attr('name')).tab('show');
  
  $('#selectTaskType').change(function() {
    $('#form-task-type-tabs li a').eq($('#selectTaskType option:selected').attr('name')).tab('show');
  });
  
  <?php 
    foreach( $this->task_types as $tt ): 
      foreach( $tt->in as $io ): 
        $template_search = json_decode( $io->template_search );
        $id = 'input_' . $tt->ttid . '-' . $io->name;
        if( $template_search && property_exists( $template_search, 'autocomplete' )  ): 
          if( $template_search->autocomplete == 'commaSeparated' ): 
            echo "makeCommaSeperatedAutoComplete( '#$id', $template_search->datasource );\n";
          else: // plain
            echo "makeAutoComplete( '#$id', $template_search->datasource );\n";
          endif;
        endif;
      endforeach; 
    endforeach; 
  ?>
});

/// SHARING DATA

$(document).ready(function() { 
    // bind form using ajaxForm 
    $('#datasetForm').ajaxForm( {
		beforeSerialize: prepareDatasetDescriptionXML,
		success: datasetFormSubmitted,
		datatype: 'xml'
	} );

	$('.pop').popover();
	$('.selectpicker').selectpicker();
});

function prepareDatasetDescriptionXML(form, options) {
	var fields =  ['name','description','format','creator','contributor','collection_date','licence','default_target_attribute','row_id_attribute','version_label','citation','visibility','original_data_url','paper_url'];
	var implode = [false,false,false,true,true,false,false,false,false,false,false,false,false,false,false];

	var xml_header = '<oml:data_set_description xmlns:oml="http://openml.org/openml">'+"\n";
	var xml_footer = '</oml:data_set_description>'+"\n";
	var xml_content = prepareDescriptionXML('dataset',fields,implode);

	$('#generated_input_dataset_description').val(xml_header+xml_content+xml_footer);
        console.log(xml_header+xml_content+xml_footer);
}


function prepareDescriptionXML(type,fields,implode) {
	var xml_content = '';
	for(i = 0; i < fields.length; i+=1) {
		field = fields[i];
		field_value = $('#input_'+type+'_'+field).val().trim();
		if(field_value != '') {
			if(implode[i] == false) {
				xml_content += "\t"+'<oml:'+field+'>'+field_value+'</oml:'+field+'>'+"\n";
			} else {
				xml_current = field_value.split(',');
				$.each(xml_current, function() {
					xml_content += "\t"+'<oml:'+field+'>'+this.trim()+'</oml:'+field+'>'+"\n";
				});
			}
		}
	}
	
	return xml_content;
}

function datasetFormSubmitted(responseText,statusText,xhr,formElement) {
	var errorCodes = new Array();
	errorCodes[131] = 'Please make sure that all mandatory fields are filled in, don\'t use spaces in name or version fields. ';
	errorCodes[135] = 'Please make sure that all mandatory fields are filled in, don\'t use spaces in name or version fields. ';
	errorCodes[137] = 'Please login first.';
	errorCodes[138] = 'Please login first.';
	formSubmitted(responseText,statusText,xhr,formElement,'Dataset',errorCodes);
}


function formSubmitted(responseText,statusText,xhr,formElement,type,errorCodes) {
  	var respstring = new XMLSerializer().serializeToString(responseText.documentElement);
        console.log("Response: "+respstring);
	var message = '';
	var status = '';
	if($('oml\\:id, id',responseText).text().length) {
		message = type + ' uploaded with ID ' + $('oml\\:id, id',responseText).text();
		status = 'alert-success';
	} else {
		var errorcode = $('oml\\:code, code',responseText).text();
		var errormessage = $('oml\\:message, message',responseText).text();
		status = 'alert-warning';
		if(errorcode in errorCodes) {
			message = errorCodes[errorcode];
		} else {
			message = 'Errorcode ' + errorcode + ': ' + errormessage;
		}
	}
	$('#response'+type+'Txt').removeClass();
	$('#response'+type+'Txt').addClass('alert');
	$('#response'+type+'Txt').addClass(status);
	$('#response'+type+'Txt').html(message);
}
