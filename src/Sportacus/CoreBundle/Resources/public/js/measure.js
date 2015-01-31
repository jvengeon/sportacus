$(document).ready()
{
	$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
	$('.datepicker').hide();
	$('.typeMeasure').hide();
	$('.mainDatepicker').datepicker({
		onClose: function(date){
			$('.datepicker').val(date);
		}
	});
}