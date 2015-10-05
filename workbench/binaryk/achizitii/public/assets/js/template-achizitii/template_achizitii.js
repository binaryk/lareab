;
function TemplateAchizitii( parameters )
{
	this.proceduriurl = parameters.get_tip_proceduri_url;
	this.tip_achizitii_url = parameters.get_tip_achizitie_url;
	this.tableClass   = 'table#tip_achizitii';
	this.tach 	      = parameters.tach;
	var self = this;

	this.generateCombobox = function(parameters ){
		/*var combobox = new COMBOBOX({
			'url'     : parameters.url,
			'id'      : parameters.id,
			'control' : parameters.control,
			'field'   : parameters.field,
			'model'	  : parameters.model 
		});
		console.log(combobox);*/
		// return combobox;
	}

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

	this.addRow = function(btn){
		var select = '<select class="form-control data-source input-group form-select init-on-update-delete array_data" id="tip_achizitie" data-control-source="tip_achizitie" data-control-type="combobox" name="tip_achizitie" style="background-color: rgb(255, 255, 255);"> </select>';
		var data=[select];
		console.log(data);
		self.tach.row.add(data).draw();

		var combobox = new COMBOBOX({
			'url'     :self.tip_achizitii_url.init,
			'id'      :66,
			'control' :'.array_data:last',
			'field'   :'nume',
			'model'	  :'\\Binaryk\\Models\\Nomenclator\\TipAchizitii' 
		}); 
		combobox.populate(0);
	}
	
	
	this.initHandlers = function(){
		$(document).on('click', '#add_row', function(e){
			self.addRow(this);
		});
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

	this.getTipAchizitii = function(id_template){
		var table = new Table({
			parent_id	: id_template,
			parent_model: 'Binaryk\\Models\\Nomenclator\\Template',
			url 	    : self.tip_achizitii_url.url,
			control     : 'table#tip_achizitii'   
		});

		table.populate();
	}

	this.init = function(){
		self.initCalendar();
		self.initHandlers();
	}

}