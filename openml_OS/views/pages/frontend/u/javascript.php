<<<<<<< HEAD
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
$(function getLikesGiven(){
    $.ajax({
        method:'GET',
        url:'".BASE_URL."api_new/v1/json/gamification/likes_given/u/".$this->user_id."/lastyear_perday'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('score').length>0){
            activity.nrdays = resultdata.getElementsByTagName('score').length;
            activity.startday = resultdata.getElementsByTagName('score')[0].getElementsByTagName('from')[0].textContent;
            activity.endday = resultdata.getElementsByTagName('score')[activity.nrdays-1].getElementsByTagName('from')[0].textContent;
            var istartday = 0;
            if(activity.startday.split(\" \")[0]==\"Monday\"){
                istartday = 6;
            }else if(activity.startday.split(\" \")[0]==\"Tuesday\"){
                istartday = 5;
            }else if(activity.startday.split(\" \")[0]==\"Wednesday\"){
                istartday = 4;
            }else if(activity.startday.split(\" \")[0]==\"Thursday\"){
                istartday = 3;
            }else if(activity.startday.split(\" \")[0]==\"Friday\"){
                istartday = 2;
            }else if(activity.startday.split(\" \")[0]==\"Saturday\"){
                istartday = 1;
            }
            for(var j=0; j<=istartday; j++){
                activity.likes.push({
                    x:0,
                    y:(istartday-j),
                    value:parseInt(resultdata.getElementsByTagName('score')[j].getElementsByTagName('value')[0].textContent),
                    name:resultdata.getElementsByTagName('score')[j].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5)
                });
            }
            for(var i=1; i<52; i++){
                for(var j=0; j<7; j++){
                    if((i*7)+j-(6-istartday)<activity.nrdays){
                        activity.likes.push({
                            x:i,
                            y:6-j,
                            value:parseInt(resultdata.getElementsByTagName('score')[(i*7)+j-(6-istartday)].getElementsByTagName('value')[0].textContent),
                            name:resultdata.getElementsByTagName('score')[(i*7)+j-(6-istartday)].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5)
                        });
                    }
                }
            }
        }else{
            console.log(\"Invalid gamification API result\");
        }
    }).fail(function(resultdata){
            console.log(\"Gamification API failed\");
    });
});

$(function getUploadsDone(){
    $.ajax({
        method:'GET',
        url:'".BASE_URL."api_new/v1/json/gamification/uploads_done/u/".$this->user_id."/lastyear_perday'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('score').length>0){
            activity.nrdays = resultdata.getElementsByTagName('score').length;
            activity.startday = resultdata.getElementsByTagName('score')[0].getElementsByTagName('from')[0].textContent;
            activity.endday = resultdata.getElementsByTagName('score')[activity.nrdays-1].getElementsByTagName('from')[0].textContent;
            var istartday = 0;
            if(activity.startday.split(\" \")[0]==\"Monday\"){
                istartday = 6;
            }else if(activity.startday.split(\" \")[0]==\"Tuesday\"){
                istartday = 5;
            }else if(activity.startday.split(\" \")[0]==\"Wednesday\"){
                istartday = 4;
            }else if(activity.startday.split(\" \")[0]==\"Thursday\"){
                istartday = 3;
            }else if(activity.startday.split(\" \")[0]==\"Friday\"){
                istartday = 2;
            }else if(activity.startday.split(\" \")[0]==\"Saturday\"){
                istartday = 1;
            }
            for(var j=0; j<=istartday; j++){
                activity.uploads.push({
                    x:0,
                    y:(istartday-j),
                    value:parseInt(resultdata.getElementsByTagName('score')[j].getElementsByTagName('value')[0].textContent),
                    name:resultdata.getElementsByTagName('score')[j].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5)
                });
            }
            for(var i=1; i<52; i++){
                for(var j=0; j<7; j++){
                    if((i*7)+j-(6-istartday)<activity.nrdays){
                        activity.uploads.push({
                            x:i,
                            y:6-j,
                            value:parseInt(resultdata.getElementsByTagName('score')[(i*7)+j-(6-istartday)].getElementsByTagName('value')[0].textContent),
                            name:resultdata.getElementsByTagName('score')[(i*7)+j-(6-istartday)].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5)
                        });
                    }
                }
            }
        }else{
            console.log(\"Invalid gamification API result\");
        }
    }).fail(function(resultdata){
            console.log(\"Gamification API failed\");
    });
});

$(function getDownloadsDone(){
    $.ajax({
        method:'GET',
        url:'".BASE_URL."api_new/v1/json/gamification/downloads_done/u/".$this->user_id."/lastyear_perday'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('score').length>0){
            activity.nrdays = resultdata.getElementsByTagName('score').length;
            activity.startday = resultdata.getElementsByTagName('score')[0].getElementsByTagName('from')[0].textContent;
            activity.endday = resultdata.getElementsByTagName('score')[activity.nrdays-1].getElementsByTagName('from')[0].textContent;
            var istartday = 0;
            if(activity.startday.split(\" \")[0]==\"Monday\"){
                istartday = 6;
            }else if(activity.startday.split(\" \")[0]==\"Tuesday\"){
                istartday = 5;
            }else if(activity.startday.split(\" \")[0]==\"Wednesday\"){
                istartday = 4;
            }else if(activity.startday.split(\" \")[0]==\"Thursday\"){
                istartday = 3;
            }else if(activity.startday.split(\" \")[0]==\"Friday\"){
                istartday = 2;
            }else if(activity.startday.split(\" \")[0]==\"Saturday\"){
                istartday = 1;
            }
            for(var j=0; j<=istartday; j++){
                activity.downloads.push({
                    x:0,
                    y:(istartday-j),
                    value:parseInt(resultdata.getElementsByTagName('score')[j].getElementsByTagName('value')[0].textContent),
                    name:resultdata.getElementsByTagName('score')[j].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5)
                });
            }
            for(var i=1; i<52; i++){
                for(var j=0; j<7; j++){
                    if((i*7)+j-(6-istartday)<activity.nrdays){
                        activity.downloads.push({
                            x:i,
                            y:6-j,
                            value:parseInt(resultdata.getElementsByTagName('score')[(i*7)+j-(6-istartday)].getElementsByTagName('value')[0].textContent),
                            name:resultdata.getElementsByTagName('score')[(i*7)+j-(6-istartday)].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5)
                        });
                    }
                }
            }
        }else{
            console.log(\"Invalid gamification API result\");
        }
    }).fail(function(resultdata){
            console.log(\"Gamification API failed\");
    });
});

$(function getActivity() {
    $.ajax({
        method:'GET',
        url:'".BASE_URL."api_new/v1/json/gamification/activity/u/".$this->user_id."/lastyear_perday'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('score').length>0){
            activity.nrdays = resultdata.getElementsByTagName('score').length;
            activity.startday = resultdata.getElementsByTagName('score')[0].getElementsByTagName('from')[0].textContent;
            activity.endday = resultdata.getElementsByTagName('score')[activity.nrdays-1].getElementsByTagName('from')[0].textContent;
            var istartday = 0;
            if(activity.startday.split(\" \")[0]==\"Monday\"){
                istartday = 6;
            }else if(activity.startday.split(\" \")[0]==\"Tuesday\"){
                istartday = 5;
            }else if(activity.startday.split(\" \")[0]==\"Wednesday\"){
                istartday = 4;
            }else if(activity.startday.split(\" \")[0]==\"Thursday\"){
                istartday = 3;
            }else if(activity.startday.split(\" \")[0]==\"Friday\"){
                istartday = 2;
            }else if(activity.startday.split(\" \")[0]==\"Saturday\"){
                istartday = 1;
            }
            for(var j=0; j<=istartday; j++){
                activity.total.push({
                    x:0,
                    y:(istartday-j),
                    value:parseInt(resultdata.getElementsByTagName('score')[j].getElementsByTagName('value')[0].textContent),
                    name:resultdata.getElementsByTagName('score')[j].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5)
                });
            }
            for(var i=1; i<52; i++){
                for(var j=0; j<7; j++){
                    if((i*7)+j-(6-istartday)<activity.nrdays){
                        activity.total.push({
                            x:i,
                            y:6-j,
                            value:parseInt(resultdata.getElementsByTagName('score')[(i*7)+j-(6-istartday)].getElementsByTagName('value')[0].textContent),
                            name:resultdata.getElementsByTagName('score')[(i*7)+j-(6-istartday)].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5)
                        });
                    }
                }
            }
            redrawActivityChart('Activity');
        }else{
            console.log(\"Invalid gamification API result\");
        }
    }).fail(function(resultdata){
            console.log(\"Gamification API failed\");
    });

});

$(function getReach() {
    $.ajax({
        method:'GET',
        url:'".BASE_URL."api_new/v1/json/gamification/reach/u/".$this->user_id."/lastmonth_perday'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('score').length>0){
            reach.nrdays = resultdata.getElementsByTagName('score').length;
            reach.startday = resultdata.getElementsByTagName('score')[0].getElementsByTagName('from')[0].textContent;
            reach.endday = resultdata.getElementsByTagName('score')[reach.nrdays-1].getElementsByTagName('from')[0].textContent;
            for(var j=0; j<reach.nrdays; j++){
                reach.total.push(parseInt(resultdata.getElementsByTagName('score')[j].getElementsByTagName('value')[0].textContent));
                reach.days.push(resultdata.getElementsByTagName('score')[j].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5));
            }
            redrawReachChart('Reach');
        }else{
            console.log(\"Invalid gamification API result\");
        }
    }).fail(function(resultdata){
        console.log(\"Gamification API failed\");
    });
});

$(function getLikesReceived() {
    var totalreach = 0;
    $.ajax({
        method:'GET',
        url:'".BASE_URL."api_new/v1/json/gamification/likes_received/u/".$this->user_id."/lastmonth_perday'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('score').length>0){
            reach.nrdays = resultdata.getElementsByTagName('score').length;
            reach.startday = resultdata.getElementsByTagName('score')[0].getElementsByTagName('from')[0].textContent;
            reach.endday = resultdata.getElementsByTagName('score')[reach.nrdays-1].getElementsByTagName('from')[0].textContent;
            for(var j=0; j<reach.nrdays; j++){
                reach.likes.push(parseInt(resultdata.getElementsByTagName('score')[j].getElementsByTagName('value')[0].textContent));
                reach.days.push(resultdata.getElementsByTagName('score')[j].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5));
            }
        }else{
            console.log(\"Invalid gamification API result\");
        }
    }).fail(function(resultdata){
        console.log(\"Gamification API failed\");
    });
});

$(function getDownloadsReceived() {
    var totalreach = 0;
    $.ajax({
        method:'GET',
        url:'".BASE_URL."api_new/v1/json/gamification/downloads_received/u/".$this->user_id."/lastmonth_perday'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('score').length>0){
            reach.nrdays = resultdata.getElementsByTagName('score').length;
            reach.startday = resultdata.getElementsByTagName('score')[0].getElementsByTagName('from')[0].textContent;
            reach.endday = resultdata.getElementsByTagName('score')[reach.nrdays-1].getElementsByTagName('from')[0].textContent;
            for(var j=0; j<reach.nrdays; j++){
                reach.downloads.push(parseInt(resultdata.getElementsByTagName('score')[j].getElementsByTagName('value')[0].textContent));
                reach.days.push(resultdata.getElementsByTagName('score')[j].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5));
            }
        }else{
            console.log(\"Invalid gamification API result\");
        }
    }).fail(function(resultdata){
        console.log(\"Gamification API failed\");
    });
});

$(function getImpact() {
    $.ajax({
        method:'GET',
        url:'".BASE_URL."api_new/v1/json/gamification/impact/u/".$this->user_id."/lastmonth_perday'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('score').length>0){
            impact.nrdays = resultdata.getElementsByTagName('score').length;
            impact.startday = resultdata.getElementsByTagName('score')[0].getElementsByTagName('from')[0].textContent;
            impact.endday = resultdata.getElementsByTagName('score')[impact.nrdays-1].getElementsByTagName('from')[0].textContent;
            for(var j=0; j<impact.nrdays; j++){
                impact.total.push(parseInt(resultdata.getElementsByTagName('score')[j].getElementsByTagName('value')[0].textContent));
                impact.days.push(resultdata.getElementsByTagName('score')[j].getElementsByTagName('from')[0].textContent.split(\" \")[1].substring(5));
            }
            redrawImpactChart('Impact');
        }else{
            console.log(\"Invalid gamification API result\");
        }
    }).fail(function(resultdata){
        console.log(\"Gamification API failed\");
    });
});

$(function getBadges() {
    $.ajax({
        method:'GET',
        url:'".BASE_URL."api_new/v1/json/gamification/badges/u/".$this->user_id."'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('badge-info').length>0){
            var info = resultdata.getElementsByTagName('badge-info');
            for(var i=0; i<info.length; i++){
                var rank = parseInt(info[i].getElementsByTagName('acquiredrank')[0].textContent);
                if(rank>=0){
                    $('#badges').append('<img src=\"img/'+(info[i].getElementsByTagName('badge-image')[rank].textContent).replace(/ /g,'')+'\" style=\"width:64px;height:64px;\"> ');
                }
            }
        }else{
            console.log(\"Invalid gamification API result\");
        }
    }).fail(function(resultdata){
        console.log(\"Gamification API failed\");
    });
});


$('#keyupgrade').submit(function() {
    var c = confirm("API key will be regenerated. ");
    return c; //you can just return c because it will be true or false
});



$('#keydegrade').submit(function() {
    var c = confirm("By doing this, API key can be used for read-operations only. Is this OK? ");
    return c; //you can just return c because it will be true or false
});

<?php } ?>
