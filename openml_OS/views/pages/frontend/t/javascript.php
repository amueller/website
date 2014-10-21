/// DETAIL
<?php  
if(false !== strpos($_SERVER['REQUEST_URI'],'/t/')) {
?>

var oTableRunsShowAll = false;
var evaluation_measure = "<?php echo $this->current_measure; ?>";
var current_task = "<?php echo $this->task_id; ?>";

var oTableRuns = false;

$(document).ready(function() { 
	$('.pop').popover();
	$('.selectpicker').selectpicker();
});



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
		pinchType: 'x',
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

function redrawCurves( renderto, type ){
	var options = [];
	var colors = ['#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE', '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92'];
	
	//check which dimensions are numeric
	numeric = [];
	categories=[];
	
	$('tbody tr:first td', table).each( function(i) {
		  if(isNaN(this.innerHTML) && this.innerHTML != 'null') // TODO: better numeric check, as null value will fail this test. 
			numeric[i]=false;
		  else
			numeric[i]=true;
		  categories[i]=[];
	    });
	
	//store index of selected X-axis
	$('thead th', table).each( function(i) {
		  if(this.innerHTML==localStorage.xAxis)
			localStorage.xIndex=i;
	    });
		
	//build categories for non-numeric dimensions
	$('tr', table).each( function(i) {
		var tr = this;
		$('td', tr).each( function(j) {
		   if(!numeric[j] && $.inArray(this.innerHTML,categories[j])==-1)
			categories[j].push(this.innerHTML);
		});
	});
	   
        //build options
	options.chart = {};
	options.chart.renderTo='learning_curve_visualize';
	options.chart.type='line';
	options.chart.height = localStorage.chartHeight;
	options.chart.width = $('#resulstab_content').width();
	options.credits = {enabled: false};
	if(localStorage.inverted=="true")
	   options.chart.inverted = true;
	options.title = {text: ' '};
	options.xAxis = {};
	options.xAxis.title = {text:localStorage.xAxis};
	options.xAxis.type = localStorage.xAxisType;
	if(localStorage.xGridBands=="true")
	  options.xAxis.alternateGridColor= '#f5f5f5';
	if(!numeric[localStorage.xIndex]){
		options.xAxis.categories = JSON.parse("[\""+categories[localStorage.xIndex].join("\",\"")+"\"]");
		if(localStorage.inverted=="false")
			options.xAxis.labels = {rotation:-45,align:'right'};
	}
	options.yAxis = [];
	var c=0;
	$('thead th', table).each( function(i){
	  if(i!=localStorage.xIndex){
	    var y = {};
	    y.title = {text:this.innerHTML};
	    y.title.style = {color:colors[c]};
	    y.labels = {style:{color:colors[c]}};
	    y.type = localStorage.yAxisType;
	    if(localStorage.yGridBands=="true")
	      options.yAxis.alternateGridColor= '#f5f5f5';
	    if(localStorage.endOnTick=="false"){
	      y.endOnTick = false;
	      y.startOnTick = false;}
	    options.yAxis.push(y);
	    c++;
	  }
	});
	
	// disables HUGE description along yAxis
	if( options.yAxis.length > 10 ) {
		var y = {};
		y.title = {text:"value"};
		y.title.style = {color:colors[c]};
		y.labels = {style:{color:colors[c]}};
		y.type = localStorage.yAxisType;
		if(localStorage.yGridBands=="true")
		  options.yAxis.alternateGridColor= '#f5f5f5';
		if(localStorage.endOnTick=="false"){
		  y.endOnTick = false;
		  y.startOnTick = false;}
		
		options.yAxis = y;
	}
	
	options.tooltip = {formatter: function() {return '<b>'+ this.series.name +'</b><br/>'+	this.x +' '+ this.y;}};
	
	return options;
}














var linechart;
$(document).ready(function() {
        redrawchart();

	Highcharts.visualizeLine = function(table, options) {
		linechart = new Highcharts.Chart(options);
	}
	learningCurveQuery();
   	fullRedrawLine();
}

// launches a query
function runQuery(theQuery) {
	localStorage.query=theQuery;
	if (theQuery.length == 0){
		$('.sqlmessage').css({"display":"inline-block"});
		$('#sqlquery-btn').button('reset');
		$('#query-btn').button('reset');
		$('.sqlmessage').html('Query is empty or could not be parsed.'); 
	} 
	var query =  encodeURI(expdburl+"api_query/?q="+encodeURIComponent(theQuery)+"&id=", "UTF-8");
	qi_waiting = true;
	window.idle = false;
	$.getJSON(query,processResult).error( jsonFailed );
}
function jsonFailed(data, textStatus) {
	qi_waiting = false;
	window.idle = true;
	$('.sqlmessage').css({"display":"inline-block"});
	$('#query-btn').button('reset');
	$('#sqlquery-btn').button('reset');
	$('#wizardquery-btn').button('reset');
	if(textStatus=="error")
		$('.sqlmessage').html('Error. Data could not be returned. Possibly, the result list is too long, try adding a LIMIT constraint (e.g., limit 0,1000) to your query. If that does not help, please contact the system administrator.'); 
	else
		$('.sqlmessage').html('Please contact the system administrator: ' + textStatus); 
}
	   $('.sqlmessage').css({"display":"inline-block"});
	   $('.sqlmessage').html(data.status);
	   $('#sqlquery-btn').button('reset');
	   $('#wizardquery-btn').button('reset');
	   return;
	}
	//var btn = document.getElementById('query-btn');
	$('#query-btn').button('reset');
	$('#sqlquery-btn').button('reset');
	$('#wizardquery-btn').button('reset');
	
        $('#x'+localStorage.runningExample).button('reset')
	//localStorage.results=JSON.stringify(data);
	$('#qtabs a[href="#resultstab"]').tab('show');
	$('#vtabs a[href="#tabletab"]').tab('show');
	
	data_orig = data;
	
	if( data.columns.length == 3 ) {
		data_cross = crossTabulate( jQuery.extend(true, {}, data), 0, 1, 2 ); // hardcopy of data
		$('#crosstabulateBtn').css( 'display', 'block' );
	} else {
		$('#crosstabulateBtn').css( 'display', 'none' );
	}
	
	if( data.columns.length == 3 && autocrosstabulate ) {
		readRows( data_cross );
		show_original_data = false;
		autocrosstabulate = false;
		//$('#crosstabulateBtn').click(function() {toggleResultTables(false); });
	} else {
		show_original_data = true;
		readRows( data_orig );
		//$('#crosstabulateBtn').click(function() {toggleResultTables(true); });
	}
}
function readRows(data) {
		
	$('#tablemain').html(buildTable(data));
	
	var oDatatable = $('#datatable').dataTable( {
        "bPaginate": true,
		"aLengthMenu": [[10, 50, 100, 250, -1], [10, 50, 100, 250, "All"]],
		"iDisplayLength" : 50,
        "bLengthChange": true,
        "bFilter": false,
        "bSort": true,
		"aaSorting": [],
        "bInfo": true,
        "bAutoWidth": false,
		"fnDrawCallback": function () {
			redrawScatterRequest = true;
			redrawLineRequest = true;
		}
    } );
	
	// only show first 5 columns:
	for( var i = resultTableMaxCols + 1; i < data.columns.length; i++) {
		oDatatable.fnSetColumnVis( i, false );
	}
	
	generatePlots();
}
function generatePlots( ){
    table = document.getElementById( 'datatable' );
	
	columns = [];
	$('thead th', table).each(function(i){columns[i]= this.innerHTML;});
	
	localStorage.inverted="false";
	localStorage.endOnTick="false";
	localStorage.xGridBands="false";
	localStorage.yGridBands="false";
    localStorage.xIndex=0;
    localStorage.xAxis=columns[0];
	localStorage.xAxisType="linear";
	localStorage.yAxisType="linear";
    localStorage.chartHeight=500;//$('#qwindow').height();
	
	buildGUI( columns, 'scatter', 'topmenuScatter' );
	buildGUI( columns, 'line', 'topmenuLine' );
	
	redrawScatterRequest = true;
	redrawLineRequest = true;
}
function onclickLinePlot() {
	if(redrawLineRequest == true) {
		fullRedraw('line'); 
		redrawLineRequest = false;
	}
}
function buildGUI( columns, type, renderTo ){
 	gui = new dat.GUI({ autoPlace: false });
	var bool = ["false","true"];
	var axisTypes = ["linear","logarithmic","datetime"];
	var f1 = gui.addFolder('Data');
  	f1.add(localStorage, 'xAxis', columns).onFinishChange(function(value){localStorage.xAxis=value;fullRedraw(type);});
	f1.add(localStorage, 'inverted', bool).onFinishChange(function(value){localStorage.inverted=value.toString();quickRedraw(type);});
  	f1.add(localStorage, 'xAxisType', axisTypes).onFinishChange(function(value){localStorage.xAxisType=value;quickRedraw(type);});
  	f1.add(localStorage, 'yAxisType', axisTypes).onFinishChange(function(value){localStorage.yAxisType=value;quickRedraw(type);});

	var f2 = gui.addFolder('Appearance');
	f2.add(localStorage, 'chartHeight').onFinishChange(function(value){localStorage.chartHeight=value;quickRedraw(type);});
	f2.add(localStorage, 'endOnTick', bool).onFinishChange(function(value){localStorage.endOnTick=value.toString();quickRedraw(type);});
  	f2.add(localStorage, 'xGridBands', bool).onFinishChange(function(value){localStorage.xGridBands=value.toString();quickRedraw(type);});
  	f2.add(localStorage, 'yGridBands', bool).onFinishChange(function(value){localStorage.yGridBands=value.toString();quickRedraw(type);});

 	gui.close();
	
  	var customContainer = document.getElementById( renderTo );
	customContainer.innerHTML = ""; // reset previous GUI
  	customContainer.appendChild( gui.domElement );
	gui.domElement.style.position="relative";
}
function buildSeries(){
	var series;
    var xi = localStorage.xIndex;
	
    // build the data series
    series = [];
    var s = 0;
    $('thead th', table).each(function(i) {
		if(i!=xi){
			series[s] = {
				name: this.innerHTML,
				height: localStorage.chartHeight,
				visible: true,
				data: []
			};
			s++;
		}
    });

    //first, build X-array
    var xarray=[];
    $('tbody tr', table).each( function(i) {
	var tr = this;
	$('td', tr).each( function(j) {
	    if(j==xi){
			if(!numeric[j])
				xarray.push($.inArray(this.innerHTML,categories[j]));
			else
				xarray.push(parseFloat(this.innerHTML));
	    }
	});
    });
	
    //then, build series in combination with each other numeric dimension
    $('tbody tr', table).each( function(i) {
	var tr = this;
	$('td', tr).each( function(j) {
	   if(j!=xi){
		var point=[];
		var addToSeries = true;
		
		point[0]=xarray[i];
		if(!numeric[j]) {
			point[1]= $.inArray(this.innerHTML,categories[j]);
		} else {
			if(isNaN(parseFloat(this.innerHTML)))
				addToSeries = false; // no non-numeric values to numeric column. 
			else 
				point[1] = parseFloat(this.innerHTML);
		}
		
		if(j<xi) {
			if (addToSeries) series[j].data.push(point);
		} else {
			if (addToSeries) series[j-1].data.push(point);
		}
	   }	
	});
    });
	
	for( var i = 0; i < s; i++ ) {
		series[i].data.sort( // sorting on x property. 
			function(a, b){
				if(a[0] > b[0]) return 1;
				else if(a[0] < b[0]) return -1;
				else return 0;});
	}
	
	console.log( series );
	return series;
}

function defineOptions( renderto, type ){
	var options = [];
	var colors = ['#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE', '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92'];
	
	//check which dimensions are numeric
	numeric = [];
	categories=[];
	
	$('tbody tr:first td', table).each( function(i) {
		  if(isNaN(this.innerHTML) && this.innerHTML != 'null') // TODO: better numeric check, as null value will fail this test. 
			numeric[i]=false;
		  else
			numeric[i]=true;
		  categories[i]=[];
	    });
	
	//store index of selected X-axis
	$('thead th', table).each( function(i) {
		  if(this.innerHTML==localStorage.xAxis)
			localStorage.xIndex=i;
	    });
		
	//build categories for non-numeric dimensions
	$('tr', table).each( function(i) {
		var tr = this;
		$('td', tr).each( function(j) {
		   if(!numeric[j] && $.inArray(this.innerHTML,categories[j])==-1)
			categories[j].push(this.innerHTML);
		});
	});
	   
        //build options
	options.chart = {};
	options.chart.renderTo=renderto;
	options.chart.type=type;
	options.chart.height = localStorage.chartHeight;
	options.chart.width = $('#resulstab_content').width();
	options.credits = {enabled: false};
	if(localStorage.inverted=="true")
	   options.chart.inverted = true;
	options.title = {text: ' '};
	options.xAxis = {};
	options.xAxis.title = {text:localStorage.xAxis};
	options.xAxis.type = localStorage.xAxisType;
	if(localStorage.xGridBands=="true")
	  options.xAxis.alternateGridColor= '#f5f5f5';
	if(!numeric[localStorage.xIndex]){
		options.xAxis.categories = JSON.parse("[\""+categories[localStorage.xIndex].join("\",\"")+"\"]");
		if(localStorage.inverted=="false")
			options.xAxis.labels = {rotation:-45,align:'right'};
	}
	options.yAxis = [];
	var c=0;
	$('thead th', table).each( function(i){
	  if(i!=localStorage.xIndex){
	    var y = {};
	    y.title = {text:this.innerHTML};
	    y.title.style = {color:colors[c]};
	    y.labels = {style:{color:colors[c]}};
	    y.type = localStorage.yAxisType;
	    if(localStorage.yGridBands=="true")
	      options.yAxis.alternateGridColor= '#f5f5f5';
	    if(localStorage.endOnTick=="false"){
	      y.endOnTick = false;
	      y.startOnTick = false;}
	    options.yAxis.push(y);
	    c++;
	  }
	});
	
	// disables HUGE description along yAxis
	if( options.yAxis.length > 10 ) {
		var y = {};
		y.title = {text:"value"};
		y.title.style = {color:colors[c]};
		y.labels = {style:{color:colors[c]}};
		y.type = localStorage.yAxisType;
		if(localStorage.yGridBands=="true")
		  options.yAxis.alternateGridColor= '#f5f5f5';
		if(localStorage.endOnTick=="false"){
		  y.endOnTick = false;
		  y.startOnTick = false;}
		
		options.yAxis = y;
	}
	
	options.tooltip = {formatter: function() {return '<b>'+ this.series.name +'</b><br/>'+	this.x +' '+ this.y;}};
	
	return options;
}    

function learningCurveQuery() {
  
  var datasetConstraint = '';
  var implementationConstraint = '';
	if ( datasets.length > 0 ) datasetConstraint = ' AND `d`.`name` IN ("' + datasets.join('","') + '") ';
	if ( implementations.length > 0 ) implementationConstraint = ' AND `i`.`fullName` IN ("' + implementations.join('","') + '") ';
  
  var sql = 
    'SELECT `e`.`sample_size`, CONCAT(`i`.`name`," on Task ",`r`.`task_id`, ": ", `d`.`name`) AS `name`, avg(`e`.`value`) as `score`' + 
    'FROM `run` `r`, `evaluation_sample` `e`, `algorithm_setup` `a`, `implementation` `i`, `task` `t`, `task_inputs` `v`, `dataset` `d` ' + 
    'WHERE `e`.`function` = "predictive_accuracy" ' + 
    'AND `t`.`ttid` = 3 ' + 
    datasetConstraint + 
    implementationConstraint + 
    'AND `r`.`rid` = `e`.`source` ' + 
    'AND `r`.`setup` = `a`.`sid` ' + 
    'AND `a`.`implementation_id` = `i`.`id` ' + 
    'AND `r`.`task_id` = `t`.`task_id` ' + 
    'AND `t`.`task_id` = `v`.`task_id` ' +
    'AND `v`.`input` = "source_data" ' +
    'AND `v`.`value` = `d`.`did` ' + 
    'GROUP BY `r`.`rid`,`e`.`sample` ' + 
    'ORDER BY `sample`, `name` ASC';
    
    runQuery( sql );
	  window.editor.setValue( sql );
}

function fullRedrawLine(){
	if(typeof linechart != 'undefined')
		linechart.showLoading(); 
	var options = defineOptions('linemain','line');
	series = buildSeries();
	options.series = series;
	console.log( options );
	Highcharts.visualizeLine(table, options);
	linechart.hideLoading();
}

<?php  
}
?>

