@extends('achizitii::~layouts.datatable.index')

@section('custom-styles')
@parent
<link rel="stylesheet" type="text/css" href="{{ asset('packages/binaryk/achizitii/admin/css/select2/select2.css') }}"> 
@stop
@section('custom-scripts')
@parent
<script type="text/javascript" src="{{ asset('assets/js/plugins/editable/select2.js') }}"></script>
@stop

@section('datatable-specific-page-jquery-initializations')
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


	var tach = $('table#tip_achizitii').DataTable({
		dom: ''
		});
	var template = new TemplateAchizitii({
			tach : tach,
			get_tip_proceduri_url : {
										url: "{{route('get-tip-proceduri-by-achizitor')}}",
										procedura_publica : "{{\Config::get('achizitii::types.procedura_publica')}}",
										procedura_privata : "{{\Config::get('achizitii::types.procedura_privata')}}"
									},
			get_tip_achizitie_url : {
					url: "{{route('get_tip_achizitie_template_url')}}",
					init: "{{route('get_tip_achizitii_url')}}"
			} 										
		});
	template.init();

	$('#tip_achizitor').on('change',  function(event){
		console.log('change')
		template.onAchizitorChange( event, $(this).val(), 0 );
	}); 

	form.aftershow = function(record, action){

		if(action == "update" || action == "delete"){

			if(record.tip_achizitor > 0){
				$('#tip_achizitor').val(record.tip_achizitor);
				template.onAchizitorChange( null , record.tip_achizitor, record.tip_procedura);
			}
			template.getTipAchizitii(record.id);
		}

	}

	form.afterEmptyControls = function(){}
@stop
