;
function MetodePublicare( properties )
{

	console.log(properties);
	this.properties = properties; 
	/**
	 * INFO - sa afiseaza row cu tipurile de anunturi ale acestui tip de proceduri de achizitii
	 * --------------------------------------------------*/
	$('table').on('click', 'td .show-anunturi', function(){
		var dt = self.properties.datatable;
		var tr = $(this).closest('tr');
		var row = dt.row( tr );
		if ( row.child.isShown() ) 
        {
        	$(this).find('i').switchClass('fa-minus','fa-plus', 1000, 'easeInOutQuad')
            row.child.hide();
            tr.removeClass('shown');
        }
        else 
        {
        	$(this).find('i').switchClass('fa-plus','fa-minus', 1000, 'easeInOutQuad')
        	var id_procedura_achizitie = $(this).data('id');
			$.ajax({
				url      : self.properties.endpoints['get-anunturi'],
				type     : 'post',
				dataType : 'json',
				data     : { id_procedura_achizitie : id_procedura_achizitie },
				success  : function(result)
				{
					row.child( result.html ).show();
           			tr.addClass('shown');
				} 
			});
        }
	});

	var self = this;
}