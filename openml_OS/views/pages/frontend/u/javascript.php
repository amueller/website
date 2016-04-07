var activity = {
    startday:"",
    endday:"",
    nrdays:null,
    days:[],
    total:[],
    uploads:[],
    likes:[],
    downloads:[]
};

var reach = {
    startday:"",
    endday:"",
    nrdays:null,
    days:[],
    total:[],
    likes:[],
    downloads:[]
};

var impact = {
    startday:"",
    endday:"",
    nrdays:null,
    days:[],
    total:[],
    reach:[],
    impact:[]
};


function redrawImpactChart(type){
    $("#Impact-chart").collapse('show');
    $("#impacttoggle").show();
    $("#impacttoggle").removeClass("fa-chevron-down").addClass("fa-chevron-up");
    var values = [];
    if(type=="Impact"){
        values = impact.total;
    }else if(type=="Reach_re"){
        values = impact.reach;
        type ="Reach of reuse";
    }else if(type=="Impact_re"){
        values = impact.impact;
        type ="Impact of reuse";
    }
    if(values.length>0){
        $("#impactplot").empty();
        var chartOptions = {
            chart: {
                type: 'column',
                backgroundColor: null,
                height: 200
            },
            exporting: false,
            credits: false,
            title: {
                style: "font-size:100%",
                margin: 5,
                text: type+" gained from " + impact.startday + " to " + impact.endday
            },
            xAxis: {
                categories: impact.days
            },
            yAxis: {
                title: {
                    text: type
                },
                min: 0
            },
            legend: {enabled: false},
            series: [{
                    color: '#5d9bd1',
                    name: type,
                    data: values
                }]
        };
        $("#impactplot").highcharts(chartOptions);
    }
}

function redrawReachChart(type){
    $("#Reach-chart").collapse('show');
    $("#reachtoggle").show();
    $("#reachtoggle").removeClass("fa-chevron-down").addClass("fa-chevron-up");
    var values = [];
    if(type=="Reach"){
        values = reach.total;
    }else if(type=="Likes"){
        values = reach.likes;
    }else if(type=="Downloads"){
        values = reach.downloads;
    }
    if(values.length>0){
        $("#reachplot").empty();
        var chartOptions = {
            chart: {
                type: 'column',
                backgroundColor: null,
                height: 200
            },
            exporting: false,
            credits: false,
            title: {
                style: "font-size:100%",
                margin: 5,
                text: type+" gained from " + reach.startday + " to " + reach.endday
            },
            xAxis: {
                categories: reach.days
            },
            yAxis: {
                title: {
                    text: type
                },
                min: 0
            },
            legend: {enabled: false},
            series: [{
                    color: '#d9534f',
                    name: type,
                    data: values
                }]
        };
        $("#reachplot").highcharts(chartOptions);
    }
}

function redrawActivityChart(type) {
    $("#Activity-chart").collapse('show');
    $("#activitytoggle").show();
    $("#activitytoggle").removeClass("fa-chevron-down").addClass("fa-chevron-up");
    var values = [];
    if(type=="Activity"){
        values = activity.total;
    }else if(type=="Uploads"){
        values = activity.uploads;
    }else if(type=="Likes"){
        values = activity.likes;
    }else if(type=="Downloads"){
        values = activity.downloads;
    }
    if(values.length>0){
        $("#activityplot").empty();
        var chartOptions = {
            chart: {
                type: 'heatmap',
                backgroundColor: null,
                height:  $('#Activity-chart').width()/7
            },
            exporting: false,
            credits: false,
            title: {
                style: "font-size:100%",
                margin: 5,
                text: type+" from " + activity.startday + " to " + activity.endday
            },
            legend: {enabled: false},
            tooltip: false,
            xAxis: {
                visible: false,
                title: null,
                labels: {
                    enabled: false
                },
                tickLength: 0
            },
            yAxis: {
                categories: ['Sun', 'Sat', 'Fri', 'Thu', 'Wed', 'Tue', 'Mon'],
                gridLineWidth: 0,
                minorGridLineWidth: 0,
                labels: {
                    enabled: true
                },
                title: null,
                tickLength: 0
            },
            colorAxis: {
                min: 0,
                minColor: '#FFFFFF',
                maxColor: '#62bb66'
            },
            tooltip: {
                formatter: function () {
                    return 'Amount of <b> '+type+' </b> was <br><b>' +
                            this.point.value + '</b> on ' + this.point.name + ' <br>';
                }
            },
            series: [{
                    name: type+' per day',
                    borderWidth: 1,
                    data: values,
                    dataLabels: {
                        enabled: false,
                        formatter: function () {
                            return this.point.name + '<br>' + this.point.value;
                        }
                    }
            }]
        };
        $("#activityplot").highcharts(chartOptions);

    }
}

$('#activitytoggle').click(function(){
  $("#activitytoggle").toggleClass("fa-chevron-down fa-chevron-up");
});

$('#reachtoggle').click(function(){
  $("#reachtoggle").toggleClass("fa-chevron-down fa-chevron-up");
});

$('#impacttoggle').click(function(){
  $("#impacttoggle").toggleClass("fa-chevron-down fa-chevron-up");
});

<?php
if ($this->ion_auth->logged_in()) {?>
$(function getActivity() {
    $.ajax({
        method:'GET',
        url:'<?php echo BASE_URL; ?>api_new/v1/json/gamification/activity/u/<?php echo $this->user_id; ?>/lastyear_perday',
        dataType:'json'
    }).done(function(resultdata){
        console.log(resultdata['activity-progress']);
        if(resultdata.getElementsByTagName('progresspart').length>0){
            activity.nrdays = resultdata.getElementsByTagName('progresspart').length;
            activity.startday = resultdata.getElementsByTagName('progresspart')[0].getElementsByTagName('date')[0].textContent;
            activity.endday = resultdata.getElementsByTagName('progresspart')[activity.nrdays-1].getElementsByTagName('date')[0].textContent;
            var istartday = 0;
            if(activity.startday.split(" ")[0]=="Monday"){
                istartday = 6;
            }else if(activity.startday.split(" ")[0]=="Tuesday"){
                istartday = 5;
            }else if(activity.startday.split(" ")[0]=="Wednesday"){
                istartday = 4;
            }else if(activity.startday.split(" ")[0]=="Thursday"){
                istartday = 3;
            }else if(activity.startday.split(" ")[0]=="Friday"){
                istartday = 2;
            }else if(activity.startday.split(" ")[0]=="Saturday"){
                istartday = 1;
            }
            for(var j=0; j<=istartday; j++){
                var name = resultdata.getElementsByTagName('progresspart')[j].getElementsByTagName('date')[0].textContent.split(" ")[1].substring(5);
                activity.total.push({
                    x:0,
                    y:(istartday-j),
                    value:parseInt(resultdata.getElementsByTagName('progresspart')[j].getElementsByTagName('activity')[0].textContent),
                    name:name
                });
                activity.uploads.push({
                    x:0,
                    y:(istartday-j),
                    value:parseInt(resultdata.getElementsByTagName('progresspart')[j].getElementsByTagName('uploads')[0].textContent),
                    name:name
                });
                activity.downloads.push({
                    x:0,
                    y:(istartday-j),
                    value:parseInt(resultdata.getElementsByTagName('progresspart')[j].getElementsByTagName('downloads')[0].textContent),
                    name:name
                });
                activity.likes.push({
                    x:0,
                    y:(istartday-j),
                    value:parseInt(resultdata.getElementsByTagName('progresspart')[j].getElementsByTagName('likes')[0].textContent),
                    name:name
                });
            }
            for(var i=1; i<52; i++){
                for(var j=0; j<7; j++){
                    if((i*7)+j-(6-istartday)<activity.nrdays){
                        var name = resultdata.getElementsByTagName('progresspart')[(i*7)+j-(6-istartday)].getElementsByTagName('date')[0].textContent.split(" ")[1].substring(5);
                        activity.total.push({
                            x:i,
                            y:6-j,
                            value:parseInt(resultdata.getElementsByTagName('progresspart')[(i*7)+j-(6-istartday)].getElementsByTagName('activity')[0].textContent),
                            name:name
                        });
                        activity.uploads.push({
                            x:i,
                            y:6-j,
                            value:parseInt(resultdata.getElementsByTagName('progresspart')[(i*7)+j-(6-istartday)].getElementsByTagName('uploads')[0].textContent),
                            name:name
                        });
                        activity.downloads.push({
                            x:i,
                            y:6-j,
                            value:parseInt(resultdata.getElementsByTagName('progresspart')[(i*7)+j-(6-istartday)].getElementsByTagName('downloads')[0].textContent),
                            name:name
                        });
                        activity.likes.push({
                            x:i,
                            y:6-j,
                            value:parseInt(resultdata.getElementsByTagName('progresspart')[(i*7)+j-(6-istartday)].getElementsByTagName('likes')[0].textContent),
                            name:name
                        });
                    }
                }
            }
            redrawActivityChart('Activity');
        }else{
            console.log("Invalid gamification API result");
        }
    }).fail(function(resultdata, textStatus, errorThrown){
        console.log("Gamification API failed: "+textStatus+" ("+errorThrown+")");
    });

});

$(function getReach() {
    $.ajax({
        method:'GET',
        url:'<?php echo BASE_URL ?>api_new/v1/json/gamification/reach/u/<?php echo $this->user_id ?>/lastmonth_perday',
        dataType:'json'
    }).done(function(resultdata){
        //console.log("Reach: "+resultdata['reach-progress']['progresspart']);
        reach.startday = resultdata['reach-progress']['progresspart'][0]['date'];
        $.each(resultdata['reach-progress']['progresspart'], function(i, item) {
            //console.log(item);
            reach.total.push(item['reach']);
            reach.likes.push(item['likes']);
            reach.downloads.push(item['downloads']);
            reach.days.push(item['date'].split(" ")[1]);
        });
        reach.nrdays = reach.total.length;
        reach.endday = resultdata['reach-progress']['progresspart'][reach.nrdays-1]['date'];
        redrawReachChart('Reach');
        //console.log(reach);
        /*if(resultdata.getElementsByTagName('progresspart').length>0){
            reach.nrdays = resultdata.getElementsByTagName('progresspart').length;
            reach.startday = resultdata.getElementsByTagName('progresspart')[0].getElementsByTagName('date')[0].textContent;
            reach.endday = resultdata.getElementsByTagName('progresspart')[reach.nrdays-1].getElementsByTagName('date')[0].textContent;
            for(var j=0; j<reach.nrdays; j++){
                reach.total.push(parseInt(resultdata.getElementsByTagName('progresspart')[j].getElementsByTagName('reach')[0].textContent));
                reach.likes.push(parseInt(resultdata.getElementsByTagName('progresspart')[j].getElementsByTagName('likes')[0].textContent));
                reach.downloads.push(parseInt(resultdata.getElementsByTagName('progresspart')[j].getElementsByTagName('downloads')[0].textContent));
                reach.days.push(resultdata.getElementsByTagName('progresspart')[j].getElementsByTagName('date')[0].textContent.split(" ")[1].substring(5));
            }
            redrawReachChart('Reach');
        }else{
            console.log("Invalid gamification API result");
        }*/
    }).fail(function(resultdata, textStatus, errorThrown){
        //console.log("Gamification API failed: "+textStatus+" ("+errorThrown+")");
    });
});


$(function getImpact() {
    $.ajax({
        method:'GET',
        url:'<?php echo BASE_URL ?>api_new/v1/json/gamification/impact/u/<?php echo $this->user_id ?>/lastmonth_perday',
        dataType:'json'
    }).done(function(resultdata){
        //console.log("Impact: "+resultdata['impact-progress']['progresspart']);
        impact.startday = resultdata['impact-progress']['progresspart'][0]['date'];
        $.each(resultdata['impact-progress']['progresspart'], function(i, item) {
            //console.log(item);
            impact.total.push(item['impact']);
            impact.days.push(item['date'].split(" ")[1]);
        });
        impact.nrdays = impact.total.length;
        impact.endday = resultdata['impact-progress']['progresspart'][impact.nrdays-1]['date'];
        redrawImpactChart('Impact');
        //console.log(impact);
        /*if(resultdata.getElementsByTagName('progresspart').length>0){
            impact.nrdays = resultdata.getElementsByTagName('progresspart').length;
            impact.startday = resultdata.getElementsByTagName('progresspart')[0].getElementsByTagName('date')[0].textContent;
            impact.endday = resultdata.getElementsByTagName('progresspart')[impact.nrdays-1].getElementsByTagName('date')[0].textContent;
            for(var j=0; j<impact.nrdays; j++){
                impact.total.push(parseInt(resultdata.getElementsByTagName('progresspart')[j].getElementsByTagName('impact')[0].textContent));
                impact.days.push(resultdata.getElementsByTagName('progresspart')[j].getElementsByTagName('date')[0].textContent.split(" ")[1].substring(5));
            }
            redrawImpactChart('Impact');
        }else{
            console.log("Invalid gamification API result");
        }*/
    }).fail(function(resultdata, textStatus, errorThrown){
        //console.log("Gamification API failed: "+textStatus+" ("+errorThrown+")");
    });
});

/*$(function getBadges() {
    $.ajax({
        method:'GET',
        url:'".BASE_URL."api_new/v1/xml/gamification/badges/u/".$this->user_id."'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('badge-info').length>0){
            var info = resultdata.getElementsByTagName('badge-info');
            for(var i=0; i<info.length; i++){
                var rank = parseInt(info[i].getElementsByTagName('acquiredrank')[0].textContent);
                if(rank>=0){
                    $('#badges').append('<img src="img/'+(info[i].getElementsByTagName('badge-image')[rank].textContent).replace(/ /g,'')+'" style="width:64px;height:64px;"> ');
                }
            }
        }else{
            console.log("Invalid gamification API result");
        }
    }).fail(function(resultdata){
        console.log("Gamification API failed");
    });
});*/


$('#keyupgrade').submit(function() {
    var c = confirm("API key will be regenerated. ");
    return c; //you can just return c because it will be true or false
});



$('#keydegrade').submit(function() {
    var c = confirm("By doing this, API key can be used for read-operations only. Is this OK? ");
    return c; //you can just return c because it will be true or false
});

<?php } ?>
