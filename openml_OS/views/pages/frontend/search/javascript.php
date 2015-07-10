  $(document).ready(function () {
    initPaginator();
    
    $(".searchresult").click(function(){
        window.location = $(this).find("a:first").attr("href");
        return false;
    });

    $(".searchresult").hover(function () {
        window.status = $(this).find("a:first").attr("href");
    }, function () {
        window.status = "";
    });
  });
