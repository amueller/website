/// SHARING

$(document).ready(function() { 
    // bind form using ajaxForm 
	$('#implementationForm').ajaxForm( {
		beforeSerialize: prepareImplementationDescriptionXML,
		success: implementationFormSubmitted,
		datatype: 'xml'
	} );

	$('.pop').popover();
	$('.selectpicker').selectpicker();
});

function prepareImplementationDescriptionXML(form, options) {
	var fields =  ['name','description','creator','contributor','licence','language','installation_notes'];
	var implode = [false,false,true,true,false,false,false];
	
	var xml_header = '<oml:implementation xmlns:oml="http://openml.org/openml">'+"\n";
	var xml_footer = '</oml:implementation>'+"\n";
	var xml_content = prepareDescriptionXML('implementation',fields,implode);
	colsole.log(xml_header+xml_content+xml_footer)
	//$('#generated_input_implementation_description').val(xml_header+xml_content+xml_footer);
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


/// DETAIL

function fetch_params_succes(xml, setup_id) {
    inner = '<table><thead><tr><th style="border: 0">Parameter Name</th><th style="border: 0">Description</th><th style="border: 0">Default Value</th><th style="border: 0">Chosen value</th></tr></thead><tbody>';
	var xmlDocument = $(xml);
	
	$(xmlDocument).find('oml\\:parameter').each(function(){
		inner += '<tr>';
		inner += '<td style="border: 0">' + $(this).find('oml\\:parameter_name').text() + '</td>';
		inner += '<td style="border: 0">' + $(this).find('oml\\:general_name').text() + '</td>';
		inner += '<td style="border: 0">' + $(this).find('oml\\:default_value').text() + '</td>';
		inner += '<td style="border: 0">' + $(this).find('oml\\:value').text() + '</td>';
		inner += '</tr>';
	});
	inner += '</tbody></table>';
	$('.setup-record-'+setup_id).html(inner);
}


// Formating function for row details 
function fnFetchParams ( oTable, row, column )
{
    var aData = oTable.fnGetData( row );
    
	$.ajax({ 
		url: '<?php echo BASE_URL; ?>api/?f=openml.setup.parameters&setup_id='+aData[column],
		context: document.body,
		dataType: 'text'
	}).done(function(xml){fetch_params_succes(xml,aData[column])});
	
    return '<div class="setup-record-'+aData[column]+'" style="margin: 0px 20px;">Loading...</div>';
}

var oTableRunsShowAll = false;
var evaluation_measure = "<?php echo $this->current_measure; ?>";
var oTableRuns = false;

$(document).ready(function() {
    <?php echo simple_datatable('oTableGeneral','#datatable_general'); ?>
    //Initialse DataTables, with no sorting on the 'details' column
    oTableRuns = $('#datatable_main').dataTable( {
		"bServerSide": true,
		"sAjaxSource": "api_query/table_feed",
		"sServerMethod": "POST",
		"fnServerParams": function ( aoData ) {
			if(oTableRunsShowAll) {
				<?php echo array_to_parsed_string($this->dt_main_all, "aoData.push( { 'value': '[VALUE]', 'name' : '[KEY]' } );\n" ); ?>
			} else {
				<?php echo array_to_parsed_string($this->dt_main, "aoData.push( { 'value': '[VALUE]', 'name' : '[KEY]' } );\n" ); ?>
			}
			aoData.push( { 'value': 'AND function = "'+evaluation_measure+'"', 'name' : 'base_sql_additional' } );
		},
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 0 ] },
            { "bSearchable": false, "bVisible":    false, "aTargets": [ 1, 2 ] }
        ],
		"sDom": "<'row'<'col-md-6'T><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
		"oTableTools": {
			"sSwfPath": "SWF/tableTools/copy_csv_xls_pdf.swf",
			"aButtons": [
				"copy","print","csv", "pdf",
                {
                    "sExtends":    "text",
                    "sButtonText": "Show all/best results",
					"fnClick": function toggleResults(nButton,oConfig,oFlash) {
						oTableRunsShowAll = !oTableRunsShowAll;
						oTableRuns.fnDraw(true);
					}
                }
            ]
		},
        "aaSorting": [[5, 'desc']],
		"aLengthMenu": [[10, 50, 100, 250], [10, 50, 100, 250]],
		"iDisplayLength" : 50,
		"bAutoWidth": false,
		<?php echo column_widths($this->dt_main['column_widths']); ?>
        "bPaginate": true
    });	
	var oTableQualities = $('#datatable_implementationqualities').dataTable( {
		"bServerSide": true,
		"sAjaxSource": "api_query/table_feed",
		"sServerMethod": "POST",
		"bPaginate": false,
		"fnServerParams": function ( aoData ) {
		  <?php echo array_to_parsed_string($this->dt_qualities, "aoData.push( { 'value': '[VALUE]', 'name' : '[KEY]' } );\n" ); ?>
		},
		"aaSorting": [[0, 'asc']],
		"iDisplayLength" : 50,
		"bAutoWidth": false,
		<?php echo column_widths($this->dt_qualities['column_widths']); ?>
    });
    /* Add event listener for opening and closing details
     * Note that the indicator for showing which row is open is not controlled by DataTables, rather it is done here
     */
    $('#datatable_main tbody td img').live('click', function () {
        var nTr = $(this).parents('tr')[0];
        if ( oTableRuns.fnIsOpen(nTr) )
        {
            // This row is already open - close it 
            this.src = "img/datatables/details_open.png";
            oTableRuns.fnClose( nTr );
        }
        else
        {
            // Open this row
            this.src = "img/datatables/details_close.png";
            oTableRuns.fnOpen( nTr, fnFetchParams(oTableRuns, nTr, 2), 'details' );
        }
    } );
} );



function redrawchart(){

options = {
            chart: {
                renderTo: 'code_result_visualize',
                type: 'scatter',
                zoomType: 'xy',
		spacingTop: 40
            },
            yAxis: {
                title: {
                    enabled: false,
                    text: 'Datasets'
                },
                categories: [],
		labels: {
                  formatter: function() {
                    return '<a href="d/name/'+ this.value +'">'+ this.value +'</a>';
                  },
        	  useHTML: true
		},
                alternateGridColor: '#eeeeff',
                gridLineColor: '#eeeeff',
		reversed: true
            },
            xAxis: {
                title: {
                    text: evaluation_measure
                },
                gridLineWidth: 1
            },
            title: {
                text: null
            },    
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                scatter: {
                    marker: {
                        states: {
                            hover: {
                                enabled: true,
                                lineColor: 'rgb(100,100,100)'
                            }
                        },
			symbol: 'diamond'
                    },
                    states: {
                        hover: {
                            marker: {
                                enabled: false
                            }
                        }
                    },
		    tooltip: {
			formatter: function() {
				return  this.category.name +' '+this.x;
			}
		    }
                }
            },
            series: [{
		color: 'rgba(119, 152, 191, .5)',
                data: []
            }]
        };

var theQuery = 'select distinct d.name, round(e.value,4) as value from algorithm_setup l, evaluation e, cvrun r, dataset d  where r.learner=l.sid AND l.implementation_id=<?php echo $this->record->id; ?> AND r.inputdata=d.did AND d.isOriginal="true" AND e.source=r.rid AND e.function="'+evaluation_measure+'" order by value desc';
var query =  encodeURI("<?php echo BASE_URL; ?>"+"api_query/?q="+encodeURIComponent(theQuery), "UTF-8");
$.getJSON(query,function(jsonData){
        var data = jsonData.data;
	var catcount = 0;
	var map = {};
	var d=[];
	var c=[];
	for(var i=0;i<data.length;i++){
		if (!(data[i][0] in map)){
			map[data[i][0]] = catcount++;
			c.push(data[i][0]);
		}
		d.push([parseFloat(data[i][1]),map[data[i][0]]]);
	}

	//color
	var heatmap = new Rainbow(); 
	heatmap.setSpectrum('black', 'blue', 'aqua', 'lime', 'yellow', 'red');
	heatmap.setNumberRange(0, 3065);

	options.yAxis.categories = c;
	options.series[0].data = d;
	options.chart.height = c.length*15;

	coderesultchart = new Highcharts.Chart(options);

}).fail(function(){ console.log('failure', arguments); });


}

$(document).ready(function() {
setTimeout(function(){
   redrawchart();
    },1000);
});

