@extends('achizitii::~layouts.datatable.index')

@section('_content')
	@parent
	{{ $modal_form->out() }}
@stop

@section('custom-styles')
	@parent
	<link rel="stylesheet" type="text/css" href="{{ asset('packages/binaryk/achizitii/assets/css/custom/plan-achizitii-proiect.css') }}"> 
@stop

@section('custom-scripts')
	@parent
	<script type="text/javascript" src="{{ asset('packages/binaryk/achizitii/packages/inputmask/js/jquery.inputmask.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/binaryk/achizitii/packages/inputmask/js/jquery.inputmask.numeric.extensions.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/binaryk/achizitii/packages/moment/moment.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/binaryk/achizitii/packages/numeral/numeral.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/binaryk/achizitii/packages/numeral/languages/ro.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/binaryk/achizitii/admin/js/libraries/commons/helper.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/binaryk/achizitii/admin/js/libraries/form/ctmodal.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/binaryk/achizitii/assets/js/plan-achizitii-proiect/plan-achizitii-proiect.js') }}"></script>
	<script>
	numeral.language('ro');
	numeral.defaultFormat('(0,0.0000)');
	moment.locale('ro');
	</script>
@stop

@section('datatable-specific-page-jquery-initializations')
	var pap = new PlanAchizitiiProiect({
		'endpoints' : {
			'get-curs-valutar'    : "{{ URL::route('get-curs-valutar') }}",
			'get-form-templates'  : "{{ URL::route('get-form-templates') }}",
			'get-template-record' : "{{ URL::route('get-template-record') }}"
		},
		'proiect' : {{ $proiect }},
		form : form
	})
@stop