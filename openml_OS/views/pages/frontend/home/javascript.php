window.onresize = function(event) {
  try{updateCanvasDimensions()}catch(err){}
};

(function(){
  function update(){
    client.search({ index: 'openml', body: { aggs: { count_by_type: { terms: { field: '_type' } } } } }, function (error, response) {
      var r = response.aggregations.count_by_type.buckets;
      var res = new Array();
      for (i = 0; i < r.length; i++) {
        res[r[i].key] = r[i].doc_count;
        $('#'+r[i].key+'counter').html(r[i].doc_count);
      }
      $('#data_count').html((res['data'] ? res['data'] : '0'));
      $('#task_count').html((res['task'] ? res['task'] : '0'));
      $('#flow_count').html((res['flow'] ? res['flow'] : '0'));
      $('#run_count').html((res['run'] ? res['run'] : '0'));
    });
  }
  update();
  //Run the update function once every 5 seconds
  setInterval(update, 5000);
})();

$(function() {
  // fetch counts for menu bar
  client.search(<?php echo json_encode($this->alltypes); ?>).then(function (body) {
    var buckets = body.aggregations.type.buckets;
    for (var b in buckets.reverse()){
      $('#'+buckets[b].key+'counter').html(buckets[b].doc_count);
    }
  }, function (error) {
    console.trace(error.message);
  });
});
