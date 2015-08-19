@extends('layouts.master')

@section('title')
    <p>Modifica scara imobil</p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
           <div class="box box-warning"> 
	            @if(Session::has('message'))
	                <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
	            @endif  

		        {{ Form::open() }}
		
				<div class="col-md-12">  
					{{ Form::textField('Scara', 'scara', $scara->scara) }}
				</div>	
				
				<div class="col-md-12">
					{{ Form::textareaField('Observatii', 'observatii', $scara->observatii) }}
				</div>

				<div class="col-md-12">
					{{ Form::selectField('Asociatie de proprietari', 'asociatie', $asociatii, $scara->id_ap) }}					
				</div>				 

		        {{ Form::token() }}
				
				<div class="col-md-6" style="clear: both;">
					{{ Form::submitButton('Salveaza')  }}
				</div>

		        {{ Form::close() }}
			
			</div><!-- /.box -->
		</div>
	</div>
@stop