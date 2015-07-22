window.onresize = function(event) {
  try{updateCanvasDimensions()}catch(err){}
};

(function(){
  function update(){
    client.search({ index: 'openml', searchType: 'count', body: { facets: { count_by_type: { terms: { field: '_type' } } } } }, function (error, response) {
      var r = response.facets.count_by_type.terms;
      var res = new Array();
      for (i = 0; i < r.length; i++) {
        res[r[i].term] = r[i].count;
      }
      $('#data_count').html(res['data']);
      $('#task_count').html(res['task']);
      $('#flow_count').html(res['flow']);
      $('#run_count').html(res['run']);
    });
  }
  update();
  //Run the update function once every 5 seconds
  setInterval(update, 5000);
})();
