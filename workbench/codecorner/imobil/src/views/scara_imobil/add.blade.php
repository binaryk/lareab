@extends('layouts.master')

@section('title')
    <p>Adauga scara imobil</p>
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
					{{ Form::textField('Scara', 'scara', null, ['class' => 'text-uppercase form-control']) }}
				</div>	
				
				<div class="col-md-12">
					{{ Form::textareaField('Observatii', 'observatii', null) }}
				</div>

				<div class="col-md-12">
					{{ Form::selectField('Asociatie de proprietari', 'asociatie', $asociatii) }}					
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