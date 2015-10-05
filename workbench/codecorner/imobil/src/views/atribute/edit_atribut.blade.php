@extends('layouts.master')

@section('title')
    <p>Modifica atribut</p>
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
					{{ Form::textField('Denumire atribut', 'denumire', $atribut->denumire) }}
				</div>	

				<div class="col-md-12">  
					{{ Form::textareaField('Descriere atribut', 'descriere', $atribut->descriere) }}
				</div>					
				{{ Form::token() }}
                <div class="col-md-12 center top24"> 
                    <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" />
                    <a href="{{ URL::route('tipuri_atribute_imobil_list') }}">
                        <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
                    </a>                         
                </div>
				{{ Form::close() }}
			</div><!-- /.box -->
		</div>
	</div>
@stop