

$('#keyupgrade').submit(function() {
    var c = confirm("API key will be regenerated. ");
    return c; //you can just return c because it will be true or false
});



$('#keydegrade').submit(function() {
    var c = confirm("By doing this, API key can be used for read-operations only. Is this OK? ");
    return c; //you can just return c because it will be true or false
});
