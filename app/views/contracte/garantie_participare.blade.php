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

                    <div class="form-group col-lg-12                   
                        @if ($errors->has('Valoare')) has-error 
                        @elseif(Input::old('Valoare')) has-success 
                        @endif">
                        <label>Valoare garantie de participare</label>
                        <input class="form-control auto text-right" name="Valoare" type="text" data-a-dec="," data-a-sep="." 
                        @if ($gr_participare)    
                            value = "{{ $gr_participare->Valoare }}"
                        @else
                            value = "{{ Input::old('Valoare') }}" 
                        @endif
                        @if ($errors->has('Valoare')) 
                            title="{{ $errors->first('Valoare') }}" 
                        @endif>
                    </div>

                    <div class="form-group col-lg-6                   
                        @if ($errors->has('PerioadaValabilitate')) has-error 
                        @elseif(Input::old('PerioadaValabilitate')) has-success 
                        @endif">
                        <label>Perioada de valabilitate a garantiei de participare</label>
                        <input class="form-control auto text-right" name="PerioadaValabilitate" type="text" data-a-dec="," data-a-sep="." 
                        @if ($gr_participare)    
                            value = "{{ $gr_participare->PerioadaValabilitate }}"
                        @else
                            value = "{{ Input::old('PerioadaValabilitate') }}" 
                        @endif
                        @if ($errors->has('PerioadaValabilitate')) 
                            title="{{ $errors->first('PerioadaValabilitate') }}" 
                        @endif>
                    </div>

                    <div class="form-group col-lg-6
                        @if($errors->has('um_timp')) has-error 
                        @elseif(Input::old('um_timp')) has-success 
                        @endif ">
                        <label for = "">Unitate de masura de timp</label>
                        <select name="um_timp" id="um_timp" 
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Selectioneaza unitatea de masura de timp</option>
                            @if ($gr_participare)
                                @foreach ($ums_timp as $um_timp) 
                                    <option value="{{ $um_timp->IdUM }}" 
                                        @if ($um_timp->IdUM == $gr_participare->id_um) selected @endif>{{ $um_timp->Denumire }}
                                    </option>
                                @endforeach
                            @else
                                @foreach ($ums_timp as $um_timp)
                                    <option value="{{ $um_timp->IdUM }}" 
                                        @if (Input::old('um_timp')) selected @endif>{{ $um_timp->Denumire }}
                                    </option> 
                                @endforeach
                            @endif
                        </select>
                    </div> 

                    <div class="form-group col-lg-6">
                        <label>Data constituirii garantiei de participare</label>
                        <div class="input-group 
                        @if ($errors->has('DataConstituirii')) has-error 
                        @elseif(Input::old('DataConstituirii')) has-success 
                        @endif">
                            <input 
                                class="form-control data-picker" 
                                name="DataConstituirii" 
                                data-placement="top" 
                                placeholder="Data deschiderii contului de garantie" 
                                type="text"

                            @if ($gr_participare)
                                value = "{{ $gr_participare->DataConstituirii }}"
                            @else 
                                value = "{{ Input::old('DataConstituirii') }}"
                            @endif 
                            @if ($errors->has('DataConstituirii')) 
                                title="{{ $errors->first('DataConstituirii') }}" 
                            @endif />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Data eliberarii garantiei de participare</label>
                        <div class="input-group 
                        @if ($errors->has('DataEliberarii')) has-error 
                        @elseif(Input::old('DataEliberarii')) has-success 
                        @endif">
                            <input 
                                class="form-control data-picker" 
                                name="DataEliberarii" 
                                data-placement="top" 
                                placeholder="Data eliberarii garantiei de participare" 
                                type="text"

                            @if ($gr_participare)
                                value = "{{ $gr_participare->DataEliberarii }}"
                            @else 
                                value = "{{ Input::old('DataEliberarii') }}"
                            @endif 
                            @if ($errors->has('DataEliberarii')) 
                                title="{{ $errors->first('DataEliberarii') }}" 
                            @endif />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>

                    <div class="form-group col-lg-6                   
                        @if ($errors->has('NecesitaGarantie')) has-error 
                        @elseif(Input::old('NecesitaGarantie')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                             @if ($gr_participare) 
                             {{ Form::checkbox('NecesitaGarantie', '1', $gr_participare->NecesitaGarantie ) }} 
                             @else
                             {{ Form::checkbox('NecesitaGarantie', '1', (Input::old('NecesitaGarantie', ''))) }}
                             @endif                               
                            <label for="NecesitaGarantie" class="label_check">S-a constituit garantie de participare</label>
                        </div>
                    </div> 

                    <div class="form-group col-lg-12 text-center">               
                        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Salveaza" />
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