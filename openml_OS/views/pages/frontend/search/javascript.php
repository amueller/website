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
  });
