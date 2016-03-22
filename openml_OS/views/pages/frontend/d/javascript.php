/// Feature graphs
<?php

//get data from ES for visualizations
$this->p = array();
$this->p['index'] = 'openml';
$this->p['type'] = 'data';
$this->p['id'] = $this->id;

try{
  $this->data = $this->searchclient->get($this->p)['_source'];
} catch (Exception $e) {}

$fgraphs = '';
$fgraphs_all = '';

if (!empty($this->data['features'])){
	$featCount = 0;
	foreach( $this->data['features'] as $r ) {
		$newGraph = '';
			if($r['type'] == "numeric"){
			$newGraph = '$(\'#feat'.$r['index'].'\').highcharts({chart:{type:\'boxplot\',inverted:true,backgroundColor:null},exporting:false,credits:false,title: null,legend:{enabled: false},tooltip:false,xAxis:{title:null,labels:{enabled:false},tickLength:0},yAxis:{title:null,labels:{style:{fontSize:\'8px\'}}},series: [{data: [['.$r['min'].','.($r['mean']-$r['stdev']).','.$r['mean'].','.($r['mean']+$r['stdev']).','.$r['max'].']]}]});';
		} else if (count($r['distr'])>0) {
			$distro = $r['distr'];
      if(count($distro)>0){
         $this->classvalues = $distro[0];
			   $newGraph = '$(\'#feat'.$r['index'].'\').highcharts({chart:{type:\'column\',backgroundColor:null},exporting:false,credits:false,title:false,xAxis:{title:false,labels:{'.(count($distro[0])>10 ? 'enabled:false' : 'style:{fontSize:\'9px\'}').'},tickLength:0,categories:[\''.implode("','", str_replace("'", "", $distro[0])).'\']},yAxis:{min:0,title:false,gridLineWidth:0,minorGridLineWidth:0,labels:{enabled:false},stackLabels:{enabled:true,useHTML:true,style:{fontSize:\'9px\'}}},legend:{enabled: false},tooltip:{useHTML:true,shared:true},plotOptions:{column:{stacking:\'normal\'}},series:[';

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


/// Wiki
jQuery.loadScript = function (url, callback) {
    jQuery.ajax({
        url: url,
        dataType: 'script',
        success: callback,
        async: true
    });
}

// Loading the Wiki through CORS. This allows it to be loaded from anywhere.
$.ajax({
  type: 'GET',
  url: '<?php echo 'http://wiki.openml.org/'.$this->url;?>',
  contentType: 'text/plain',
  xhrFields: { withCredentials: false },
  headers: {  },
  success: function(data) {
    data = data.match(/<body[^>]*>[\s\S]*<\/body>/gi)[0];
    data = '<?php echo $this->preamble; ?>' + data.replace('body>', 'div>');
    data = data.replace('action="/edit/<?php echo $this->wikipage; ?>','');
    data = data.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,'');
    $(".description").html(data);

    //customizations
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
    $("#wiki-waiting").css("display","none");
    $("#wiki-ready").css("display","block");

    //load gollum javascript
    var headID = document.getElementsByTagName("head")[0];
    var newScript = document.createElement('script');
    newScript.type = 'text/javascript';
    newScript.src = 'js/libs/gollum.js';
    headID.appendChild(newScript);
  },
  error: function() {
    // Here's where you handle an error response.
    // Note that if the error was due to a CORS issue,
    // this function will still fire, but there won't be any additional
    // information about the error.
    console.log('Woops, there was an error making the request.');
  }
});

$( "#gollum-editor-preview" ).click(function() {
	var $form = $($('#gollum-editor form').get(0));
        $form.attr('action', '');
});

$("a[title*='View commit']").each(function() {
   var _href = $(this).attr("href");
   $(this).attr('href', 'd/<?php echo $this->id; ?>/view' + _href);
});



var isliked = false;
<?php if ($this->ion_auth->logged_in()) {
      if ($this->ion_auth->user()->row()->id != $this->data['uploader_id']) {
echo "
$.ajax({
    method:'GET',
    url:'",BASE_URL,"api_new/v1/json/votes/up/",$this->ion_auth->user()->row()->id,"/d/", $this->id, "'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('boolean').length>0){
            if(Boolean(resultdata.getElementsByTagName('boolean')[0].textContent)){
                isliked = true;
                $('#likeicon').removeClass(\"fa-heart-o\").addClass(\"fa-heart\");
                $('#likebutton').prop('title', 'Click to unlike');
            } else{
                isliked = false;
                $('#likeicon').removeClass(\"fa-heart\").addClass(\"fa-heart-o\");
                $('#likebutton').prop('title', 'Click to like');
            }
        }
    }).fail(function(resultdata){
        isliked = false;
        $('#likeicon').removeClass(\"fa-heart\").addClass(\"fa-heart-o\");
        $('#likebutton').prop('title', 'Click to like');
 });";}}?>

function refreshNrLikes(){
    $.ajax({
        method:'GET',
        url:'<?php echo BASE_URL; ?>api_new/v1/json/votes/up/any/d/<?php echo $this->id ?>'
        }).done(function(resultdata){
            if(resultdata.getElementsByTagName('like').length>0){
                var nrlikes = resultdata.getElementsByTagName('like').length;
                $('#likecount').html(nrlikes+" likes");
            }else{
                $('#likecount').html("0 likes");
            }
        }).fail(function(resultdata){        
            $('#likecount').html("0 likes");
     });
 }
 
 function refreshNrDownloads(){
    $.ajax({
       method:'GET',
       url:'<?php echo BASE_URL; ?>api_new/v1/json/downloads/any/d/<?php echo $this->id ?>'
    }).done(function(resultdata){
       if(resultdata.getElementsByTagName('download').length>0){
           var nrdownloads = resultdata.getElementsByTagName('download').length;
           var totaldownloads = 0;
           for(var i=0; i<nrdownloads; i++){
               totaldownloads+=parseInt(resultdata.getElementsByTagName('download')[i].getElementsByTagName('count')[0].textContent);
           }
           $('#downloadcount').html("downloaded by "+nrdownloads+" people, "+totaldownloads+" total downloads");
       }else{
           $('#downloadcount').html("downloaded by 0 people, 0 total downloads");
       }
    }).fail(function(resultdata){        
       $('#downloadcount').html("downloaded by 0 people, 0 total downloads");
    });
 }

<?php if ($this->ion_auth->logged_in()) {
      if ($this->ion_auth->user()->row()->id != $this->data['uploader_id']) {
          echo "
function doLike(){
    if(isliked){
        meth = 'DELETE';
    }else{
        meth = 'POST';
    }
    $.ajax({
        method: meth,
        url: '". BASE_URL."api_new/v1/json/votes/up/d/".$this->id ."'
    }).done(function(resultdata){
        if(resultdata.getElementsByTagName('like').length>0){
            //changes already done
        }else{
            //undo changes
            flipLikeHTML();
        }
    }).fail(function(resultdata){
        //undo changes
        flipLikeHTML();
    });
    //change as if the api call is succesful
    flipLikeHTML();
}";}}?>

function flipLikeHTML(){
    if(isliked){
        isliked = false;
        $('#likeicon').removeClass("fa-heart").addClass("fa-heart-o");
        $('#likebutton').prop('title', 'Click to like');
        var likecounthtml = $('#likecount').html();
        var nrlikes = parseInt(likecounthtml.split(" ")[0]);
        nrlikes = nrlikes-1;
        $('#likecount').html(nrlikes+" likes");
        var reachhtml = $('#reach').html();
        var reach = parseInt(reachhtml.split(" ")[0]);
        reach = reach-2;
        $('#reach').html(reach+" reach");
    }else{
        isliked = true;
        $('#likeicon').removeClass("fa-heart-o").addClass("fa-heart");
        $('#likebutton').prop('title', 'Click to unlike');
        var likecounthtml = $('#likecount').html();
        var nrlikes = parseInt(likecounthtml.split(" ")[0]);
        nrlikes = nrlikes+1;
        $('#likecount').html(nrlikes+" likes");
        var reachhtml = $('#reach').html();
        var reach = parseInt(reachhtml.split(" ")[0]);
        reach = reach+2;
        $('#reach').html(reach+" reach");
    }
}

<?php if ($this->ion_auth->logged_in()) {
      if ($this->ion_auth->user()->row()->id != $this->data['uploader_id']) {
          echo "
function doDownload(){
    $.ajax({
            method: 'POST',
            url: '<?php echo BASE_URL; ?>api_new/v1/json/downloads/d/". $this->id."'
           }
    ).done(function(){
        refreshNrDownloads();
    });
}";}}?>

