$(document).ready(function() { 
    // bind form using ajaxForm 
    $('#datasetForm').ajaxForm( {
    beforeSerialize: prepareDatasetDescriptionXML,
    success: datasetFormSubmitted,
    datatype: 'xml'
  } );
  $('#implementationForm').ajaxForm( {
    beforeSerialize: prepareImplementationDescriptionXML,
    success: implementationFormSubmitted,
    datatype: 'xml'
  } );
});

function prepareDatasetDescriptionXML(form, options) {
  var fields =  ['name','description','format','creator','contributor','collection_date','language','licence','default_target_attribute','row_id_attribute'];
  var implode = [false,false,false,true,true,false,false,false,false,false];
  
  var xml_header = '<oml:data_set_description xmlns:oml="http://openml.org/openml">'+"\n";
  var xml_footer = '</oml:data_set_description>'+"\n";
  var xml_content = prepareDescriptionXML('dataset',fields,implode);
  
  $('#generated_input_dataset_description').val(xml_header+xml_content+xml_footer);
}

function prepareImplementationDescriptionXML(form, options) {
  var fields =  ['name','description','creator','contributor','licence','language','installation_notes'];
  var implode = [false,false,true,true,false,false,false];
  
  var xml_header = '<oml:implementation xmlns:oml="http://openml.org/openml">'+"\n";
  var xml_footer = '</oml:implementation>'+"\n";
  var xml_content = prepareDescriptionXML('implementation',fields,implode);
  
  $('#generated_input_implementation_description').val(xml_header+xml_content+xml_footer);
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



function implementationFormSubmitted(responseText,statusText,xhr,formElement) {
  var errorCodes = new Array();
  errorCodes[161] = 'Please make sure that all mandatory fields are filled in. ';
  errorCodes[163] = 'Please make sure that all mandatory fields are filled in. ';
  errorCodes[169] = 'Please login first.';
  errorCodes[170] = 'Please login first.';
  formSubmitted(responseText,statusText,xhr,formElement,'Implementation',errorCodes);
}

function formSubmitted(responseText,statusText,xhr,formElement,type,errorCodes) {
  var message = '';
  var status = '';
  if($('oml\\:id',responseText).length) {
    message = type + ' uploaded with ID ' + $('oml\\:id',responseText).text();
    status = 'alert-success';
  } else {
    var errorcode = $('oml\\:code',responseText).text();
    var errormessage = $('oml\\:message',responseText).text();
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
