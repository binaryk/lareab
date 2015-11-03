;
function TemplateAchizitii( parameters )
{
	this.proceduriurl = parameters.get_tip_proceduri_url;
	this.tip_achizitii_url = parameters.get_tip_achizitie_url;
	this.tableClass   = 'table#tip_achizitii';
	this.tach 	      = parameters.tach;
	this.endpoints    = parameters.endpoints;

	this.modal = new CtModal({'id' : '#frm-template-achizitii'});

	var self = this;

	this.onAchizitorChange = function( event, id_tip_achizitor, id_tip_procedura ){
		var combobox = new COMBOBOX({
			'url'     : this.proceduriurl.url,
			'id'      : id_tip_achizitor,
			'control' : '#tip_procedura',
			'field'   : 'nume',
			'model'	  : '\\Binaryk\\Models\\Nomenclator\\TipProceduriAchizitii' 
		});
		combobox.populate(id_tip_procedura);
	}

	this.onProceduraChange = function( event, id_tip_procedura, id_tip_anunt )
	{
		var combobox = new COMBOBOX({
			'url'     : this.proceduriurl.url_anunt,
			'id'      : id_tip_procedura,
			'control' : '#tip_anunt',
		});
		combobox.populate(id_tip_anunt);
	}

	this.initCalendar = function(){
		if (jQuery().datepicker) {
			$('#data_semnare_cf').datepicker(
				{
				language: "ro",
				format: "dd.mm.yyyy",
				autoclose: true,
				rtl: Metronic.isRTL(),
				orientation: "left",
				autoclose: true,
				todayBtn: 'linked',
				clearBtn: true
				}).on('changeDate', function(e)
				{});
		}
	}

	this.checkTipAchizitii = function( tip_achizitii)
	{
		for(tip in tip_achizitii)
		{
			$('#tip-achizitii-' + tip_achizitii[tip].id).prop('checked', true);
		}
	}

	$('#box-template-achizitii').on('click', '.vezi-modalitati-publicare, #view-modalitati-publicare-by-tip-anunt', function(e){
		var id_tip_anunt = 0;

		if( $(this).data('anunt') )
		{
			id_tip_anunt = $(this).data('anunt');
		}
		else
		{
			id_tip_anunt = $('#tip_anunt').val();
		}

		if( id_tip_anunt != 0)
		{
			e.preventDefault();
			$.ajax({
				url : self.endpoints['get-modal-modalitati-publicare-by-tip-anunt'],
				type : 'POST',
				dataType : 'json',
				data : {'id_tip_anunt' : id_tip_anunt },
				success : function(result){
					if(result.success)
					{
						self.modal.show(result.modal.header, result.modal.body, result.modal.footer);
					}
				}
			});
		}
	});

	this.init = function(){
		self.initCalendar();
		/*
		self.initHandlers();
		*/
	}

}