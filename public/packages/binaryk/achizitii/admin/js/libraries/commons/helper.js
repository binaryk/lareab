function dateToMysql( date )
{
	return moment(date, 'DD.MM.YYYY').format('YYYY-MM-DD');
}


function hideFieldsErrors()
{
	$('.form-group').removeClass('has-error').find('p.help-block').remove();
	$('.form-group').find('label.error-sign').remove();
}

function hideMyError(object)
{
	object.closest('.form-group').removeClass('has-error').find('p.help-block').remove();
	object.closest('.form-group').find('label.error-sign').remove();
}
	
function showFieldsErrors( errors )
{
	// console.log(errors);
	for( field in errors )
	{
		var formGroup = $('#' + field).closest('.form-group');
		formGroup.removeClass('has-error').find('p.help-block').remove();
		formGroup.addClass('has-error').append('<p class="help-block has-error">' + errors[field][0] + '</p>');
	}
}

function toFloat(value, sufix)
{
	value = parseFloat(value.replace(sufix, '').replace('.', '').replace(',', '.'));
	if( isNaN(value) )
	{
		value = 0;
	}
	return value;
}