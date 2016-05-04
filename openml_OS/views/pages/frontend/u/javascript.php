var activity = {
    startday:"",
    endday:"",
    nrdays:null,
    days:[],
    total:[],
    uploads:[],
    likes:[],
    downloads:[],
    totalscore:0,
    uploadscore:0,
    likescore:0,
    downloadscore:0
};

var reach = {
    startday:"",
    endday:"",
    nrdays:null,
    days:[],
    total:[],
    likes:[],
    downloads:[],
    totalscore:0,
    likescore:0,
    downloadscore:0
};

var impact = {
    startday:"",
    endday:"",
    nrdays:null,
    days:[],
    total:[],
    reach:[],
    impact:[],
    totalscore:0,
    reachscore:0,
    impactscore:0
};


function redrawImpactChart(type){
    $("#Impact-chart").collapse('show');
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
                    color: '#8E24AA',
                    name: type,
                    data: values
                }]
        };
        $("#impactplot").highcharts(chartOptions);
        $("#impacttoggle").css('visibility', 'visible');
        $("#impacttoggle").removeClass("fa-plus").addClass("fa-minus");
    }
}

function redrawReachChart(type){
    $("#Reach-chart").collapse('show');
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
                    color: '#8E24AA',
                    name: type,
                    data: values
                }]
        };
        $("#reachplot").highcharts(chartOptions);
        $("#reachtoggle").css('visibility', 'visible');
        $("#reachtoggle").removeClass("fa-plus").addClass("fa-minus");
    }
}

function redrawActivityChart(type) {
    $("#Activity-chart").collapse('show');
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
                height:  Math.max($('#Activity-chart').width()/7,200)
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
                type: 'logarithmic',
                minColor: '#FFFFFF',
                maxColor: '#8E24AA'
            },
            tooltip: {
                formatter: function () {
                    return 'Amount of <span style="color:#8E24AA"> '+type+' </span> was <br><b>' +
                            Math.floor(this.point.value) + '</b> on ' + this.point.name + ' <br>';
                }
            },
            series: [{
                    name: type+' per day',
                    borderWidth: 1,
                    data: values,
                    dataLabels: {
                        enabled: false,
                        formatter: function () {
                            return this.point.name + '<br>' + Math.floor(this.point.value);
                        }
                    }
            }]
        };
        $("#activityplot").highcharts(chartOptions);
        $("#activitytoggle").css('visibility', 'visible');
        $("#activitytoggle").removeClass("fa-plus").addClass("fa-minus");
    }
}

$('#activitytoggle').click(function(){
    if($('#Activity-chart').hasClass("in")){
        $("#activitytoggle").removeClass("fa-minus").addClass("fa-plus");
    }else if($('#Activity-chart').hasClass("collapse")){
        $("#activitytoggle").removeClass("fa-plus").addClass("fa-minus");
    }
});

$('#reachtoggle').click(function(){
    if($('#Reach-chart').hasClass("in")){
        $("#reachtoggle").removeClass("fa-minus").addClass("fa-plus");
    }else if($('#Reach-chart').hasClass("collapse")){
        $("#reachtoggle").removeClass("fa-plus").addClass("fa-minus");
    }
});

$('#impacttoggle').click(function(){
    if($('#Impact-chart').hasClass("in")){
        $("#impacttoggle").removeClass("fa-minus").addClass("fa-plus");
    }else if($('#Reach-chart').hasClass("collapse")){
        $("#impacttoggle").removeClass("fa-plus").addClass("fa-minus");
    }
});

<?php
if ($this->ion_auth->logged_in()) {?>
getBadges();
$(function getActivity() {
    $.ajax({
        method:'GET',
        url:'<?php echo BASE_URL; ?>api_new/v1/json/gamification/activity/u/<?php echo $this->user_id; ?>/lastyear_perday',
        dataType:'json'
    }).done(function(resultdata){
        activity.startday = resultdata['activity-progress']['progresspart'][0]['date'];
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
        $.each(resultdata['activity-progress']['progresspart'], function(i, item) {
            //console.log(item);
            activity.total.push({
                                x:Math.floor(i/7),
                                y:(istartday-(i%7)),
                                value: parseInt(item['activity']) + 0.000001,
                                name: item['date'].split(" ")[1]});
            activity.totalscore+= +item['activity'];
            activity.likes.push({
                                x:Math.floor(i/7),
                                y:(istartday-(i%7)),
                                value: parseInt(item['likes']) + 0.000001,
                                name: item['date'].split(" ")[1]});
            activity.likescore+= +item['likes'];
            activity.downloads.push({
                                x:Math.floor(i/7),
                                y:(istartday-(i%7)),
                                value: parseInt(item['downloads']) + 0.000001,
                                name: item['date'].split(" ")[1]});
            activity.downloadscore+= +item['downloads'];
            activity.uploads.push({
                                x:Math.floor(i/7),
                                y:(istartday-(i%7)),
                                value: parseInt(item['uploads']) + 0.000001,
                                name: item['date'].split(" ")[1]});
            activity.uploadscore+= +item['uploads'];
            activity.days.push(item['date'].split(" ")[1]);
        });
        activity.nrdays = activity.total.length;
        activity.endday = resultdata['activity-progress']['progresspart'][activity.nrdays-1]['date'];
        $("#ActivityThisYear").html(activity.totalscore+" /");
        $("#UploadsThisYear").html(activity.uploadscore+" /");
        $("#LikesThisYear").html(activity.likescore+" /");
        $("#DownloadsThisYear").html(activity.downloadscore+" /");
        redrawActivityChart('Activity');
        /*if(resultdata.getElementsByTagName('progresspart').length>0){
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
        }*/
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
            reach.totalscore=+item['reach'];
            reach.likes.push(item['likes']);
            reach.likescore=+item['likes'];
            reach.downloads.push(item['downloads']);
            reach.downloadscore=+item['downloads'];
            reach.days.push(item['date'].split(" ")[1]);
        });
        reach.nrdays = reach.total.length;
        reach.endday = resultdata['reach-progress']['progresspart'][reach.nrdays-1]['date'];
        $("#ReachThisMonth").html(reach.totalscore+" /");
        $("#LikesReceivedThisMonth").html(reach.likescore+" /");
        $("#DownloadsReceivedThisMonth").html(reach.downloadscore+" /");
        redrawReachChart('Reach');
    }).fail(function(resultdata, textStatus, errorThrown){
        console.log("Gamification API failed: "+textStatus+" ("+errorThrown+")");
    });
});


$(function getImpact() {
    $.ajax({
        method:'GET',
        url:'<?php echo BASE_URL ?>api_new/v1/json/gamification/impact/u/<?php echo $this->user_id ?>/lastmonth_perday',
        dataType:'json'
    }).done(function(resultdata){
        impact.startday = resultdata['impact-progress']['progresspart'][0]['date'];
        $.each(resultdata['impact-progress']['progresspart'], function(i, item) {
            impact.total.push(item['impact']);
            impact.totalscore=+item['impact'];
            impact.days.push(item['date'].split(" ")[1]);
        });
        impact.nrdays = impact.total.length;
        impact.endday = resultdata['impact-progress']['progresspart'][impact.nrdays-1]['date'];
        $("#ImpactThisMonth").html(impact.totalscore+" /");
        redrawImpactChart('Impact');
    }).fail(function(resultdata, textStatus, errorThrown){
        console.log("Gamification API failed: "+textStatus+" ("+errorThrown+")");
    });
});

function checkBadge(id){
    $.ajax({
            method:'GET',
            url:'<?php echo BASE_URL; ?>api_new/v1/json/badges/check/<?php echo $this->user_id; ?>/'+id
        }).done(function(resultdata){
            getBadges();
        }).fail(function(resultdata){
            console.log("Gamification API failed");
        });
}

function getBadges() {
    $.ajax({
        method:'GET',
        url:'<?php echo BASE_URL; ?>api_new/v1/json/badges/list/<?php echo $this->user_id; ?>'
    }).done(function(resultdata){
        $('#badges').html("");
        $.each(resultdata['badges']['badge'], function(i,item){
            if(<?php echo $this->user_id; ?> == <?php echo $this->ion_auth->user()->row()->id; ?> || item['rank']>0){
                $('#badges').append('<div class="col-sm-3">'+
                                        '<img class="btn" src="'+item['image']+'" alt="'+item['name']+'" style="width:128px;height:128px;" onclick="checkBadge('+item['id']+')" title="Click to evaluate rank">'+
                                        '<br>'+
                                        '<h4 style="padding-top:5px">'+item['name']+'</h4>'+
                                        '<b>Current rank: </b>'+item['description_current']+
                                        '<br>'+
                                        '<b>Next rank: </b>'+item['description_next']+
                                    '</div>');
            }
        });
    }).fail(function(resultdata){
        console.log("Gamification API failed");
    });
}


$('#keyupgrade').submit(function() {
    var c = confirm("API key will be regenerated. ");
    return c; //you can just return c because it will be true or false
});



$('#keydegrade').submit(function() {
    var c = confirm("By doing this, API key can be used for read-operations only. Is this OK? ");
    return c; //you can just return c because it will be true or false
});

<?php } ?>
