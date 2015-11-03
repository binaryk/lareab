@extends('achizitii::~layouts.datatable.index')

@section('content')
	@parent
	{{
	\Easy\Form\Modal::make('achizitii::~layouts.form.modals.modal')
	->id('frm-template-achizitii')
	->caption('1111')
	->closable(true)
	->body('2222')
	->footer('3333')
	->out()
	}}
@stop

@section('custom-styles')
	@parent
	<link rel="stylesheet" type="text/css" href="{{ asset('packages/binaryk/achizitii/admin/css/select2/select2.css') }}"> 
@stop

@section('custom-scripts')
	@parent
	<script type="text/javascript" src="{{ asset('assets/js/plugins/editable/select2.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/binaryk/achizitii/admin/js/libraries/form/ctmodal.js') }}"></script>
@stop

@section('datatable-specific-page-jquery-initializations')
	/*
	$(function(){
	    $('#options').editable({
	        value: [2, 3],    
	        source: [
	              {value: 1, text: 'option1'},
	              {value: 2, text: 'option2'},
	              {value: 3, text: 'option3'}
	           ]
	    });
	});
	*/

	var tach = $('table#tip_achizitii').DataTable({
		dom: ''
	});
	
	var template = new TemplateAchizitii({
		tach                  : tach,
		get_tip_proceduri_url : {
			url: "{{route('get-tip-proceduri-by-achizitor')}}",
			procedura_publica : "{{\Config::get('achizitii::types.procedura_publica')}}",
			procedura_privata : "{{\Config::get('achizitii::types.procedura_privata')}}",
			url_anunt: "{{route('get-tip-anunt-by-procedura')}}",
		},
		get_tip_achizitie_url : {
			url: "{{route('get_tip_achizitie_template_url')}}",
			init: "{{route('get_tip_achizitii_url')}}"
		},
		endpoints : {
			'get-modal-modalitati-publicare-by-tip-anunt' : "{{ route('get-modal-modalitati-publicare-by-tip-anunt') }}"
		}
	});
	
	template.init();

	$('#tip_achizitor').on('change',  function(event){template.onAchizitorChange( event, $(this).val(), 0 );});
	$('#tip_procedura').on('change',  function(event){template.onProceduraChange( event, $(this).val(), 0 );}); 

	form.aftershow = function(record, action)
	{
		$('.tipuri-achizitii').prop('checked', false);
		if( action == 'insert')
		{
		}
		else
			if(action == "update" || action == "delete")
			{
				if(record.tip_achizitor > 0)
				{
					$('#tip_achizitor').val(record.tip_achizitor);
					template.onAchizitorChange( null , record.tip_achizitor, record.tip_procedura);
					if(parseInt(record.tip_anunt) > 0)
					{
						template.onProceduraChange( null, record.tip_procedura, record.tip_anunt );
					}
				}
				template.checkTipAchizitii(record.tip_achizitie);
			}
	}

	form.afterEmptyControls = function(){}
@stop
