/// DETAIL
<?php
if(false !== strpos($_SERVER['REQUEST_URI'],'/d/')) {
?>

$(document).ready(function() {
	$('.pop').popover();
	$('.selectpicker').selectpicker();
});

<?php
}
?>
