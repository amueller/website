$(function activitychart() {
    var values = [];
    var startday = "";
    var endday = "";
    $.ajax({
        method:'GET',
        url:'<?php echo BASE_URL; ?>api_new/v1/json/gamification/activity/u/<?php echo $this->user_id ?>/lastmonth_perday'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('score').length>0){
            var nrdays = resultdata.getElementsByTagName('score').length;
            startday = resultdata.getElementsByTagName('score')[0].getElementsByTagName('from')[0].textContent;
            endday = resultdata.getElementsByTagName('score')[nrdays-1].getElementsByTagName('from')[0].textContent;
            console.log(nrdays);
            var istartday = 0;
            if(startday.split(" ")[0]=="Monday"){
                istartday = 6;
            }else if(startday.split(" ")[0]=="Tuesday"){
                istartday = 5;
            }else if(startday.split(" ")[0]=="Wednesday"){
                istartday = 4;
            }else if(startday.split(" ")[0]=="Thursday"){
                istartday = 3;
            }else if(startday.split(" ")[0]=="Friday"){
                istartday = 2;
            }else if(startday.split(" ")[0]=="Saturday"){
                istartday = 1;
            }
            for(var j=0; j<=istartday; j++){
                values.push({
                    x:0,
                    y:(istartday-j),
                    value:parseInt(resultdata.getElementsByTagName('score')[j].getElementsByTagName('value')[0].textContent),
                    name:resultdata.getElementsByTagName('score')[j].getElementsByTagName('from')[0].textContent.split(" ")[1].substring(5)
                });
            }
            for(var i=1; i<5; i++){
                for(var j=0; j<7; j++){
                    if((i*7)+j-(6-istartday)<nrdays){
                        values.push({
                            x:i,
                            y:6-j,
                            value:parseInt(resultdata.getElementsByTagName('score')[(i*7)+j-(6-istartday)].getElementsByTagName('value')[0].textContent),
                            name:resultdata.getElementsByTagName('score')[(i*7)+j-(6-istartday)].getElementsByTagName('from')[0].textContent.split(" ")[1].substring(5)
                        });
                    }
                }
            }
        }else{
            console.log("Invalid gamification API result");
        }
    }).fail(function(resultdata){            
            console.log("Gamification API failed");
    }).always(function(){
        $('#activityplot').highcharts({
            chart: {
                type: 'heatmap',
                backgroundColor:null,
                width: $('#activity-panel').width(),
                height: 200
            },
            exporting:false,
            credits:false,
            title: {
                style:"font-size:100%",
                margin:5,
                text:"Activity from "+ startday+" to "+endday
            },
            legend:{enabled: false},
            tooltip:false,
            xAxis:{
                visible:false,
                title:null,
                labels:{
                    enabled:false
                },
                tickLength:0
            },
            yAxis: {
                categories: ['Sun','Sat','Fri','Thu','Wed','Tue','Mon'],
                gridLineWidth: 0,
                minorGridLineWidth: 0,
                labels:{
                    enabled:true
                },
                title: null,
                tickLength:0
            },

            colorAxis: {
                min: 0,
                minColor: '#FFFFFF',
                maxColor: '#62bb66'
            },

            tooltip: {
                formatter: function () {
                    return '<b> Activity </b> was <br><b>' +
                        this.point.value + '</b> on '+this.point.name+' <br>';
                }
            },

            series: [{
                name: 'Activity per day',
                borderWidth: 1,
                data: values,
                dataLabels: {
                    enabled: false,
                    formatter: function(){
                        return this.point.name+'<br>'+this.point.value;
                    }
                }
            }]

        });
    });
    
});

$(function reachchart() {
    var values = [];
    var days = [];
    var startday = "";
    var endday = "";
    var totalreach = 0;
    $.ajax({
        method:'GET',
        url:'<?php echo BASE_URL; ?>api_new/v1/json/gamification/reach/u/<?php echo $this->user_id ?>/lastmonth_perday'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('score').length>0){
            var nrdays = resultdata.getElementsByTagName('score').length;
            console.log(nrdays);
            startday = resultdata.getElementsByTagName('score')[0].getElementsByTagName('from')[0].textContent;
            endday = resultdata.getElementsByTagName('score')[nrdays-1].getElementsByTagName('from')[0].textContent;
            for(var j=0; j<nrdays; j++){
                totalreach += parseInt(resultdata.getElementsByTagName('score')[j].getElementsByTagName('value')[0].textContent);
                values.push(totalreach);
                days.push(resultdata.getElementsByTagName('score')[j].getElementsByTagName('from')[0].textContent.split(" ")[1].substring(5));
            }
        }else{
            console.log("Invalid gamification API result");
        }
    }).fail(function(resultdata){
            console.log("Gamification API failed");
    }).always(function(){
        $('#reachplot').highcharts({
            chart: {
                backgroundColor:null,
                width: $('#reach-panel').width(),
                height: 200
            },
            exporting:false,
            credits:false,
            title: {
                style:"font-size:100%",
                margin:5,
                text:"Reach from "+ startday+" to "+endday
            },
            xAxis: {
                categories: days
            },
            yAxis: {
                title: {
                    text: 'Reach'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },            
            legend:{enabled: false},
            series: [{
                color: '#d9534f',
                name: 'Reach',
                data: values
            }]

        });
    });
    
});


$(function impactchart() {
    var values = [];
    var days = [];
    var startday = "";
    var endday = "";
    var totalreach = 0;
    $.ajax({
        method:'GET',
        url:'<?php echo BASE_URL; ?>api_new/v1/json/gamification/impact/u/<?php echo $this->user_id ?>/lastmonth_perday'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('score').length>0){
            var nrdays = resultdata.getElementsByTagName('score').length;
            console.log(nrdays);
            startday = resultdata.getElementsByTagName('score')[0].getElementsByTagName('from')[0].textContent;
            endday = resultdata.getElementsByTagName('score')[nrdays-1].getElementsByTagName('from')[0].textContent;
            for(var j=0; j<nrdays; j++){
                totalreach += parseInt(resultdata.getElementsByTagName('score')[j].getElementsByTagName('value')[0].textContent);
                values.push(totalreach);
                days.push(resultdata.getElementsByTagName('score')[j].getElementsByTagName('from')[0].textContent.split(" ")[1].substring(5));
            }
        }else{
            console.log("Invalid gamification API result");
        }
    }).fail(function(resultdata){
            console.log("Gamification API failed");
    }).always(function(){
        $('#impactplot').highcharts({
            chart: {
                backgroundColor:null,
                width: $('#impact-panel').width(),
                height: 200
            },
            exporting:false,
            credits:false,
            title: {
                style:"font-size:100%",
                margin:5,
                text:"Impact from "+ startday+" to "+endday
            },
            xAxis: {
                categories: days
            },
            yAxis: {
                title: {
                    text: 'Reach'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },            
            legend:{enabled: false},
            series: [{
                color: '#5d9bd1',
                name: 'Impact',
                data: values
            }]

        });
    });
    
});