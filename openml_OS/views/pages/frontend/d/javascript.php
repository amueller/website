/// SHARING

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
	var fields =  ['name','description','format','creator','contributor','collection_date','language','licence','default_target_attribute','row_id_attribute'];
	var implode = [false,false,false,true,true,false,false,false,false,false];

	var xml_header = '<oml:data_set_description xmlns:oml="http://openml.org/openml">'+"\n";
	var xml_footer = '</oml:data_set_description>'+"\n";
	var xml_content = prepareDescriptionXML('dataset',fields,implode);

	$('#generated_input_dataset_description').val(xml_header+xml_content+xml_footer);
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
<?php  
if(false !== strpos($_SERVER['REQUEST_URI'],'/d/')) {
?>

var oTableRunsShowAll = false;
var evaluation_measure = "<?php echo $this->current_measure; ?>";
var current_task = "<?php echo $this->current_task; ?>";

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
			aoData.push( { 'value': 'AND function = "'+evaluation_measure+'" AND r.task_id = '+current_task, 'name' : 'base_sql_additional' } );
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
    $('#datatable_main tbody td img').on('click', function () {
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

function updateTableHeader(){
	$("#value").html(evaluation_measure.charAt(0).toUpperCase()+evaluation_measure.slice(1).replace(/_/g,' '));
}

function redrawchart(){
categoryMap = {};
options = {
            chart: {
                renderTo: 'data_result_visualize',
                type: 'scatter',
		spacingTop: 40,
                events: {
                    load: function (event) {
                        $('.tip').tooltip();
                    }
                }
            },
	    title: {
	        text: 'Evaluations per flow (multiple parameter settings)'
	    },
	    subtitle: {
	        text: 'every point is a run, click for details'
	    },
	    yAxis: {
                title: {
                    enabled: false,
                    text: 'Flows'
                },
                categories: [],
		labels: {
                  formatter: function() {
		    var lab = this.value.length > 50 ? this.value.substring(0, 25) + '...' +  this.value.substring(this.value.length - 25) : this.value;
                    return '<a class="hccategory tip" href="f/'+ categoryMap[this.value] +'" title="' + this.value + '">'+ lab +'</a>';
                  },
        	  useHTML: true
		},
                alternateGridColor: '#eeeeff',
                gridLineColor: '#eeeeff',
		reversed: true
            },
            xAxis: {
                title: {
                    text: evaluation_measure.charAt(0).toUpperCase()+evaluation_measure.slice(1).replace(/_/g,' ')
                },
                gridLineWidth: 1
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
                    }                
		}
            },
            tooltip:{
                followTouchMove: false,
                formatter:function(){
                    return '<div>Flow:<b> '+this.series.yAxis.categories[this.y]+'</b><br>'+ this.series.xAxis.axisTitle.element.textContent + '<b>: ' + this.x+'</b><br>'+ ((typeof this.point.options.z !== 'undefined') ? 'Parameter '+selected_parameter+': <b>'+this.point.options.z+'</b>' : '<i>Click for more info</i>') + '</div>';
                }
            },
            series: [{
		turboThreshold: 0,		
		color: 'rgba(119, 152, 191, .5)',
                data: [],
		point: {
                    events: {
                        click: function(){$('#runModal').modal({remote: 'r/' + this.r + '/html'}); $('#runModal').modal('show');}
                    }
                }
            }]
        };

var theQuery = 'select distinct i.fullname, round(e.value,4) as value, r.rid, i.id from algorithm_setup l, evaluation e, run r, implementation i  where r.setup=l.sid AND l.implementation_id=i.id AND e.source=r.rid AND e.function="'+evaluation_measure+'" AND r.task_id = '+ current_task + ' order by value desc';
var query =  encodeURI("<?php echo BASE_URL; ?>"+"api_query/?q="+theQuery, "UTF-8");
$.getJSON(query,function(jsonData){
        var data = jsonData.data;
	var catcount = 0;
	var map = {};
	var d=[];
	var c=[];
	for(var i=0;i<data.length;i++){
		if (!(data[i][0] in map)){
			map[data[i][0]] = catcount++;
			categoryMap[data[i][0]]= data[i][3]; 
			c.push(data[i][0]);
		}
		d.push({x: parseFloat(data[i][1]), y: map[data[i][0]], r: data[i][2]});
	}

	options.yAxis.categories = c;
	options.series[0].data = d;
	options.chart.height = c.length*18+120;

	coderesultchart = new Highcharts.Chart(options);

}).fail(function(){ console.log('failure', arguments); });
}

$(document).ready(function() {
   redrawchart();
});

<?php  
}
?>

