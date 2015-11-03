;
var PlanAchizitiiProiect = function( parameters )
{
	for( property in parameters)
	{
		this[property] = parameters[property];
	}

	this.modal = new CtModal({'id' : '#frm-templates'});
	this.modalitati_publicare = [];

	this.calculateValoareRon = function()
	{
		var valoare_eur  = numeral().unformat($('#valoare_estimata_eur_fara_tva').val());
		var curs_valutar = numeral().unformat($('#curs_valutar').val());
		var valoare_lei = valoare_eur * curs_valutar;
		$('#valoare_estimata_ron_fara_tva').val( valoare_lei.toFixed(2) );
	}

	this.getCursvalutar = function( date, currency)
	{
		hideFieldsErrors();
		$('#curs_valutar').val(0);
		$.ajax({
			url      : self.endpoints['get-curs-valutar'],
			type     : 'post',
			dataType : 'json',
			data     : { date:date, currency:currency},
			success  : function(result){
				if( result.curs != null)
				{

					$('#curs_valutar').val(result.curs.value);
					self.calculateValoareRon();
				}
				else
				{
					showFieldsErrors({'curs_valutar' : ['BNR nu a furnizat cursul EUR la data ' + date + '.']});
				}
			}
		});
	}

	var self = this;

	/*
	 * Input mask for numbers
	 */
	$('.to-float-2')
		.css({'text-align' : 'right'})
		.inputmask('decimal', { 
			radixPoint     : ',',
			digits         : 2,
			groupSeparator : '.',
			autoGroup      : true,
			suffix         : ''
		})
		.val(0);
	$('.to-float-4')
		.css({'text-align' : 'right'})
		.inputmask('decimal', { 
			radixPoint     : ',',
			digits         : 4,
			groupSeparator : '.',
			autoGroup      : true,
			suffix         : ''
		})

	$('.to-datepicker').datepicker({
		dateFormat:'dd.mm.yy'
	});

	$('#btn-get-curs-valutar').click( function(e){
		var data_curs_valutar = $('#data_curs').val();
		if( data_curs_valutar.length == 0)
		{
			showFieldsErrors({'data_curs' : ['Selectati data cursului']});
		}
		else
		{
			self.getCursvalutar(dateToMysql(data_curs_valutar), 'EUR');
		}
	});

	$('#tip_contract').change(function(e){
		if( $(this).val() != '-' )
		{
			hideMyError( $(this) );
		}
		else
		{
			showFieldsErrors({'tip_contract' : ['Selectati tipul de contract.']});
		}
	});	

	$('#valoare_estimata_eur_fara_tva').keyup(function(e){
		if( $(this).val().length != 0 )
		{
			hideMyError( $(this) );
			self.calculateValoareRon();
		}
		else
		{
			showFieldsErrors({'valoare_estimata_eur_fara_tva' : ['Completati valoarea estimata in EUR.']});
		}
	});	

	$('#curs_valutar').keyup(function(e){
		self.calculateValoareRon();
	});

	$('#btn-get-templete-record').click( function(e){
		var tip_contract = $('#tip_contract').val();
		if(tip_contract == '-')
		{
			showFieldsErrors({'tip_contract' : ['Selectati tipul de contract.']});
			return false;
		}
		var valoare_eur = $('#valoare_estimata_eur_fara_tva').val();
		if(valoare_eur.length == 0)
		{
			showFieldsErrors({'valoare_estimata_eur_fara_tva' : ['Completati valoarea estimata in EUR.']});
			return false;
		}
		$.ajax({
			url      : self.endpoints['get-form-templates'],
			type     : 'post',
			dataType : 'json',
			data     : {
				'tip_achizitor' : self.proiect.tip_achizitor,
				'tip_contract'  : tip_contract, 
				'valoare_eur'   : toFloat(valoare_eur)
			},
			success  : function(result){
				self.modal.show(result.title, result.body, result.footer);
			}
		});
	});

	this.createComboboxTipAchizitie = function( tip_achizitie)
	{
		var combobox = $('#id_tip_achizitie');
		combobox.find('option').remove();
		combobox.append($("<option/>", {value : 0, text : " --- Selectati tipul de achizitie --- "}));
		for( i = 0; i < tip_achizitie.length; i++ )
		{
			combobox.append($("<option/>", {
		        value : tip_achizitie[i].id,
		        text  : tip_achizitie[i].nume
		    }));
		}
	}

	this.fillModalitatiPublicareFields = function( id )
	{
		var record = null;
		for(i = 0; i < this.modalitati_publicare.length; i++ )
		{
			if(this.modalitati_publicare[i].id == id)
			{
				record = this.modalitati_publicare[i];
				break;
			} 
		}
		if( record != null )
		{
			$('#is_anunt_anterior_').val( record.is_anunt_anterior_);
			$('#complexitate_').val( record.complexitate_ );
			$('#zile_depunere_publicare_').val( record.zile_depunere_publicare_ );	

			$('#is_anunt_anterior').val( record.anunt_anterior);
			$('#complexitate').val( record.tip_complexitate );
			$('#zile_depunere_publicare').val( record.zile_depunere_publicare_ );			
		}
	}

	$(document).on('change', '#id_modalitate_publicare', function(e){
		self.fillModalitatiPublicareFields( $(this).val() );
	});

	this.createComboboxModalitatiPublicare = function()
	{
		var combobox = $('#id_modalitate_publicare');
		combobox.find('option').remove();
		combobox.append($("<option/>", {value : 0, text : " --- Selectati modalitatea de publicare --- "}));
		for( i = 0; i < this.modalitati_publicare.length; i++ )
		{
			combobox.append($("<option/>", {
		        value : this.modalitati_publicare[i].id,
		        text  : this.modalitati_publicare[i].nume
		    }));
		}
	}

	this.fillTemplateFields = function( template )
	{
		$('#cod_procedura').val( template.cod_procedura );
		$('#descriere_procedura').val( template.descriere_procedura );
		$('#tip_procedura_').val( template.tip_procedura_ );
		$('#tip_anunt_').val( template.tip_anunt_ );
		$('#plafon_maxim').val( template.plafon_maxim );
		$('#id_template').val( template.id );
		$('#id_tip_procedura').val( template.tip_procedura );
		$('#id_tip_anunt').val( template.tip_anunt );
		this.createComboboxTipAchizitie( template.tip_achizitie_ );
		this.modalitati_publicare = template.modalitati_publicare;
		this.createComboboxModalitatiPublicare();
	}

	$(document).on('click', '#btn-select-template', function(e){
		var template_id = 0;
		if( $('input[name=selected-record]:checked').length > 0)
		{
			template_id = $('input[name=selected-record]:checked').data('id');
		}
		if( template_id > 0)
		{
			$.ajax({
				url      : self.endpoints['get-template-record'],
				type     : 'post',
				dataType : 'json',
				data     : {
					id_template : template_id
				},
				success  : function(result){
					self.modal.hide();
					self.fillTemplateFields( result.record );
				}
			});
		}
	});

	this.form.aftershow = function(record, action)
	{
		$('input[type=text][readonly]').removeAttr('style').css({'background-color' : '#d9edf7 !important', 'border' : '1px solid #31708f'});
		$('#valoare_estimata_ron_fara_tva').css({'text-align' : 'right'});
		if( action == 'insert')
		{
			$('#valoare_estimata_eur_fara_tva').val(0.00);
			$('#valoare_estimata_ron_fara_tva').val(0.00);
			$('#curs_valutar').val(0.0000);
		}
	};
	
}