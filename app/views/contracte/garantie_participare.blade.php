@extends('layouts.master')

@section('title')
    <p>Adauga / modifica garantie de participare</p>
@stop

@section('content')
	<div class="row">
    	<div class="col-lg-12">
    		<form role="form" action="{{ URL::current() }}" method="post">
    			<fieldset>
    				@if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif
                    {{ Form::open() }}

                    <div class="col-md-12">
                        {{ Form::textNumericField('Valoare garantie de participare', 'valoare', isset($gr_participare->valoare) ? $gr_participare->valoare : 0) }}                    
                    </div>

                    <div class="col-md-6">
                        {{ Form::textNumericField('Perioada de valabilitate a garantiei de participare', 'perioada_valabilitate', isset($gr_participare->perioada_valabilitate) ? $gr_participare->perioada_valabilitate : 0) }}                    
                    </div>                     

                    <div class="col-md-6">
                        {{ Form::selectField('Unitate de masura de timp', 'um_timp', $ums_timp, isset($gr_participare->id_um) ? $gr_participare->id_um : null) }}
                    </div>                        

                    <div class="form-group col-lg-6">
                        <label>Data constituirii garantiei de participare</label>
                        <div class="input-group 
                        @if ($errors->has('data_constituirii')) has-error 
                        @elseif(Input::old('data_constituirii')) has-success 
                        @endif">
                            <input 
                                class="form-control data-picker" 
                                name="data_constituirii" 
                                data-placement="top" 
                                placeholder="Data deschiderii contului de garantie" 
                                type="text"

                            @if ($gr_participare)
                                value = "{{ $gr_participare->data_constituirii }}"
                            @else 
                                value = "{{ Input::old('data_constituirii') }}"
                            @endif 
                            @if ($errors->has('data_constituirii')) 
                                title="{{ $errors->first('data_constituirii') }}" 
                            @endif />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Data eliberarii garantiei de participare</label>
                        <div class="input-group 
                        @if ($errors->has('data_eliberarii')) has-error 
                        @elseif(Input::old('data_eliberarii')) has-success 
                        @endif">
                            <input 
                                class="form-control data-picker" 
                                name="data_eliberarii" 
                                data-placement="top" 
                                placeholder="Data eliberarii garantiei de participare" 
                                type="text"

                            @if ($gr_participare)
                                value = "{{ $gr_participare->data_eliberarii }}"
                            @else 
                                value = "{{ Input::old('data_eliberarii') }}"
                            @endif 
                            @if ($errors->has('data_eliberarii')) 
                                title="{{ $errors->first('data_eliberarii') }}" 
                            @endif />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>

                    <div class="form-group col-lg-6                   
                        @if ($errors->has('necesita_garantie')) has-error 
                        @elseif(Input::old('necesita_garantie')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                             @if ($gr_participare) 
                             {{ Form::checkbox('necesita_garantie', '1', $gr_participare->necesita_garantie ) }} 
                             @else
                             {{ Form::checkbox('necesita_garantie', '1', (Input::old('necesita_garantie', ''))) }}
                             @endif                               
                            <label for="necesita_garantie" class="label_check">S-a constituit garantie de participare</label>
                        </div>
                    </div> 

                    <div class="form-group col-lg-12 text-center">               
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg" value="Salveaza" />
                        {{ Form::token() }}
                    </div>

                    {{ Form::close() }}   

    			</fieldset>
    		</form>
        </div>
    </div>	
@stop

@section('footer_scripts')
    
    {{ HTML::script('segmentare.js') }}
    <script>
        
        $(function() {
            $( ".data-picker" ).datepicker({ minDate: 0, dateFormat: "dd-mm-yy"});         
        });

    </script>

@stop