function ftoc(id) {
	$('input#userId3').val(id);
}

$("a[data-toggle=popover]").popover().click(function(e) {
	e.preventDefault()
});

$("span[data-toggle=popover]").popover({
	html : true,
	trigger : 'hover'
});

$("[data-toggle=tooltip]").tooltip();

$('.toggle').hide();

$('.toggletrigger').click(function() {
	$(".toggle[data-toggle=" + $(this).attr('data-toggle') + "]").toggle()
	var icon = $("i#icon" + $(this).attr('data-toggle'));
	var p = 'icon-plus';
	var m = 'icon-minus';
	if (icon.hasClass(p)) {
		icon.removeClass(p);
		icon.addClass(m);
	} else {
		icon.removeClass(m);
		icon.addClass(p);

	}
});

// //DATE TIME PICKERS
$(function() {
	$('#picker1').datetimepicker({
		pickDate : false,
		pickSeconds : false
	});
});
$('#picker1').on(
		'changeDate',
		function(e) {
			$('#picker1Container').val(
					e.localDate.getHours() + ":" + e.localDate.getMinutes());
		});
$(function() {
	$('#picker4').datetimepicker({
		pickDate : false,
		pickSeconds : false
	});
});
$('#picker4').on(
		'changeDate',
		function(e) {
			$('#picker4Container').val(
					e.localDate.getHours() + ":" + e.localDate.getMinutes());
		});


$(function() {
	$('#picker2').datetimepicker({
		pickSeconds : false,
		pickTime: false
	});
});
$('#picker2').on(
		'changeDate',
		function(e) {
			$('#picker2Container').val(
					e.localDate.getDate()+"-"+(e.localDate.getMonth()+1)+
					"-"+e.localDate.getFullYear() );
		});
$(function() {
	$('#picker3').datetimepicker({
		pickSeconds : false,
		pickTime: false
	});
});
$('#picker3').on(
		'changeDate',
		function(e) {
			$('#picker3Container').val(
					e.localDate.getDate()+"-"+(e.localDate.getMonth()+1)+
					"-"+e.localDate.getFullYear() );
		});
$(function() {
	$('#picker5').datetimepicker({
		pickSeconds : false
	});
});
$('#picker5').on(
		'changeDate',
		function(e) {
			$('#picker5Container').val(
					e.localDate.getDate()+"-"+(e.localDate.getMonth()+1)+
					"-"+e.localDate.getFullYear() + " " +
					e.localDate.getHours() + ":" + e.localDate.getMinutes());
		});
$(function() {
	$('#picker6').datetimepicker({
		pickSeconds : false
	});
});
$('#picker6').on(
		'changeDate',
		function(e) {
			$('#picker6Container').val(
					e.localDate.getDate()+"-"+(e.localDate.getMonth()+1)+
					"-"+e.localDate.getFullYear() + " " +
					e.localDate.getHours() + ":" + e.localDate.getMinutes());
		});
// END
