  $(document).ready(function () {

    // initialize endless scrolling
    initPaginator();

    // handle clicks on cards
    $(".searchresult").click(function(){
        window.location = $(this).find("a:first").attr("href");
        return false;
    });

    $(".searchresult").hover(function () {
        window.status = $(this).find("a:first").attr("href");
    }, function () {
        window.status = "";
    });

    // fetch counts for menu bar
    client.search(<?php echo json_encode($this->alltypes); ?>).then(function (body) {
      var buckets = body.aggregations.type.buckets;
      for (var b in buckets.reverse()){
        $('#'+buckets[b].key+'counter').html(buckets[b].doc_count);
      }
    }, function (error) {
      console.trace(error.message);
    });

    <?php
    if($this->table) {
    ?>
      $('#tableview').dataTable( {
    		"responsive": "true",
    		"dom": 'CT<"clear">lfrtip',
    		"aaData": <?php echo json_encode($this->tableview); ?>,
        "scrollY": "600px",
        "scrollCollapse": true,
    		"deferRender": true,
        "paging": false,
    		"processing": true,
    		"bSort" : true,
    		"bInfo": false,
    		"tableTools": {
    						"sSwfPath": "//cdn.datatables.net/tabletools/2.2.3/swf/copy_csv_xls_pdf.swf"
    				},
    		"aaSorting" : [],
    		"aoColumns": [
    	  <?php
          $cnt = sizeOf($this->cols);
    			foreach( $this->tableview[0] as $k => $v ) {
    			$newcol = '{ "mData": "'.$k.'" , "defaultContent": "", ';
    			if(is_numeric($v))
    				$newcol .= '"sType":"numeric", ';
    			if($k == 'name' || $k == 'runs' || $k == 'NumberOfInstances' || $k == 'NumberOfFeatures' || $k == 'NumberOfClasses')
          	$newcol .= '"bVisible":true},';
    			else
    				$newcol .= '"bVisible":false},';
    			if(array_key_exists($k,$this->cols)){
    				$this->cols[$k] = $newcol;
    			} else {
    				//$this->cols[] = $newcol;
    				$cnt++;
    			}
    		  	}
    			foreach( $this->cols as $k => $v ) {
     				echo $v;
    			}?>

    		]
    	    } );

    	$('.topmenu').show();

    function toggleResults( resultgroup ) {
    	var oDatatable = $('#tableview').dataTable(); // is not reinitialisation, see docs.

    	redrawScatterRequest = true;
    	redrawLineRequest = true;
    	for( var i = 1; i < colcount; i++) {
    		if( i > colmax * resultgroup && i <= colmax * (resultgroup+1) )
    			oDatatable.fnSetColumnVis( i, true );
    		else
    			oDatatable.fnSetColumnVis( i, false );
    	}
    }
    <?php } ?>

  });
