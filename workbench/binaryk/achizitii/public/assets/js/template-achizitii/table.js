function Table(parameters)
{

	this.id          = parameters.id;
	this.parent_id	 = parameters.parent_id;
	this.parent_model= parameters.parent_model;
	this.url     	 = parameters.url;
	this.control 	 = parameters.control;

	this.getChilds = function(){

	}

	this.data = function()
	{
		return {
			'id'           : this.id,
			'parent_model' : this.parent_model,
			'parent_id'    : this.parent_id,
		};
	};

	this.setOptions = function(options, value)
	{
		console.log(options);
		
		var htmloptions = $(this.control + ' tbody').html();
		for(i = 0; i < options.length; i++)
		{
			console.log(options[i].nume);
			htmloptions += '<tr> <td>' + options[i].nume + '</td></tr>'
		}
		console.log(htmloptions);
		$(this.control + ' tbody').html(htmloptions);
	};

	this.removeTr = function(){
		$(this.control + ' tbody').find('tr').remove();
	}

	this.populate = function( value )
	{
		var self = this;
		$.ajax({
			url      : this.url,
        	type     : 'post',
        	dataType : 'json',
        	data     : this.data(),
        	success  : function(result)
        	{
        		console.log(result);
        		self.setOptions(result.options);
        		// $(self.control).focus();
        	}
		})
	}
}