function COMBOBOX(parameters)
{

	this.id      = parameters.id;
	this.url     = parameters.url;
	this.control = parameters.control;
	this.model   = parameters.model;
	this.field   = parameters.field;

	this.data = function()
	{
		return {
			'id'    : this.id,
			'model' : this.model,
			'field' : this.field
		};
	};

	this.setOptions = function(options, value)
	{
		$(this.control).find('option').remove();
		var htmloptions = '';
		for(i = 0; i < options.length; i++)
		{
			htmloptions += '<option' + ' value="' + options[i].id + '">' + options[i].text + '</option>'
		}
		$(this.control).html(htmloptions);
	};

	this.populate = function( value )
	{
		var self = this;
		$.ajax({
			url      : this.url,
        	type     : 'post',
        	dataType : 'json',
        	data     : this.data(),
        	//async     : false, 
        	success  : function(result)
        	{
        		console.log('--------------------->', result.options);
        		self.setOptions(result.options, value);
        		// console.log(self.control + ' <----- ' + value);
        		$(self.control).val(value);
        	}
		})
	}
}

/*function COMBOBOX(parameters)
{

	this.id      = parameters.id;
	this.url     = parameters.url;
	this.control = parameters.control;
	this.model   = parameters.model;
	this.field   = parameters.field;
	this.selected= parameters.selected;

	this.data = function()
	{
		return {
			'id'    : this.id,
			'model' : this.model,
			'field' : this.field
		};
	};

	this.setOptions = function(options, value)
	{
		console.log('value');
		console.log(value);
		$(this.control).find('option').remove();
		var htmloptions = '';
		for(i = 0; i < options.length; i++)
		{
			htmloptions += '<option' + (value == options[i].id ? ' selected="selected"' : '') + ' value="' + options[i].id + '">' + options[i].text + '</option>'
		}
		$(this.control).html(htmloptions);
	};

	this.populate = function( value )
	{
		var self = this;
		console.log(self.data());
		$.ajax({
			url      : self.url,
        	type     : 'post',
        	dataType : 'json',
        	data     : self.data(),
        	success  : function(result)
        	{
        		self.setOptions(result.options, self.selected);
        		// $(self.control).focus();
        	}
		})
	}
}*/