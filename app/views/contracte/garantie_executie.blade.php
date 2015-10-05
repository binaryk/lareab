@extends('layouts.master')

@section('title')
    <p>Adauga / modifica garantie de buna executie</p>
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
                        @if ($errors->has('NrCont')) has-error 
                        @elseif(Input::old('NrCont')) has-success 
                        @endif">
                        <label>Numar cont</label> 
                        <input class="form-control" name="NrCont" type="text"  
                        @if ($gr_executie) 
                            value = "{{ $gr_executie->NrCont }}" 
                        @else  
                            value = "{{ Input::old('NrCont') }}" 
                        @endif
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('required') }}" 
                        @endif>
                    </div>

                    <div class="form-group col-lg-12
                        @if ($errors->has('banca')) has-error 
                        @elseif(Input::old('banca')) has-success 
                        @endif">
                        <label>Banca</label>
                        <input class="form-control" name="banca" type="text" 
                        @if ($gr_executie)
                            value = "{{ $gr_executie->banca }}"
                        @else
                            value = "{{ Input::old('banca') }}"
                        @endif 
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('required') }}" 
                        @endif>
                    </div>

                    <div class="form-group col-lg-6                   
                        @if ($errors->has('procent_valoare')) has-error 
                        @elseif(Input::old('procent_valoare')) has-success 
                        @endif">
                        <label>Procent garantie(%)</label>
                        <input class="form-control auto text-right" name="procent_valoare" type="text" data-a-dec="," data-a-sep="." 
                        @if ($gr_executie)    
                            value = "{{ $gr_executie->procent_valoare }}"
                        @else
                            value = "{{ Input::old('procent_valoare') }}" 
                        @endif
                        @if ($errors->has('procent_valoare')) 
                            title="{{ $errors->first('procent_valoare') }}" 
                        @endif>
                    </div>

                    <div class="form-group col-lg-6                   
                        @if ($errors->has('ProcentValoare')) has-error 
                        @elseif(Input::old('ProcentValoare')) has-success 
                        @endif">
                        <label>Valoare garantie</label>
                        <input class="form-control auto text-right" name="ValoareGarantie" type="text" data-a-dec="," data-a-sep="." 
                        @if ($gr_executie && $contract)    
                            value = "{{ ($contract[0]->Valoare * $gr_executie->ProcentValoare) / 100 }}"
                        @else
                            value = "{{ 0 }}" 
                        @endif readonly>
                    </div>

                    <div class="form-group col-lg-6                   
                        @if ($errors->has('ProcentInitial')) has-error 
                        @elseif(Input::old('ProcentInitial')) has-success 
                        @endif">
                        <label>Procent constituit initial(%)</label>
                        <input class="form-control auto text-right" name="ProcentInitial" type="text" data-a-dec="," data-a-sep="." 
                        @if ($gr_executie)
                            value = "{{ $gr_executie->ProcentInitial }}"
                        @else
                            value = "{{ Input::old('ProcentInitial') }}"
                        @endif 
                        @if ($errors->has('ProcentInitial')) 
                            title="{{ $errors->first('ProcentInitial') }}" 
                        @endif>
                    </div>

                    <div class="form-group col-lg-6                   
                        @if ($errors->has('ProcentInitial')) has-error 
                        @elseif(Input::old('ProcentInitial')) has-success 
                        @endif">
                        <label>Valoare constituita initial</label>
                        <input class="form-control auto text-right" name="ValoareInitiala" type="text" data-a-dec="," data-a-sep="." 
                        @if ($gr_executie && $contract)    
                            value = "{{ ((($contract[0]->Valoare * $gr_executie->ProcentValoare) / 100)* $gr_executie->ProcentInitial) / 100 }}"
                        @else
                            value = "{{ 0 }}" 
                        @endif readonly>
                    </div>

                    <div class="form-group col-lg-12">
                        <label>Sold la zi</label>
                        <input class="form-control auto text-right" name="ValoareInitiala" type="text" data-a-dec="," data-a-sep="." 
                        @if ($gr_executie && $contract && $valoare_incasari)    
                            value = "{{ (($contract[0]->Valoare * $gr_executie->ProcentValoare) / 100) + $valoare_incasari[0]->ValoareIncasari }}"
                        @else
                            value = "{{ 0 }}" 
                        @endif readonly>
                    </div>

                    <div class="col-lg-12 margin-bottom">
                        <label>Data deschiderii contului de garantie</label>
                        <div class="input-group 
                        @if ($errors->has('DataDeschidere')) has-error 
                        @elseif(Input::old('DataDeschidere')) has-success 
                        @endif">
                            <input 
                                class="form-control data_deschidere" 
                                name="DataDeschidere" 
                                data-placement="top" 
                                placeholder="Data deschiderii contului de garantie" 
                                type="text"

                            @if ($gr_executie)
                                value = "{{ $gr_executie->DataDeschidere }}"
                            @else 
                                value = "{{ Input::old('DataDeschidere') }}"
                            @endif 
                            @if ($errors->has('DataDeschidere')) 
                                title="{{ $errors->first('DataDeschidere') }}" 
                            @endif />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>

                    <div class="form-group col-lg-6                   
                        @if ($errors->has('NecesitaGarantie')) has-error 
                        @elseif(Input::old('NecesitaGarantie')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                             @if ($gr_executie) 
                             {{ Form::checkbox('NecesitaGarantie', '1', $gr_executie->NecesitaGarantie ) }} 
                             @else
                             {{ Form::checkbox('NecesitaGarantie', '1', (Input::old('NecesitaGarantie', ''))) }}
                             @endif                               
                            <label for="NecesitaGarantie" class="label_check">S-a constituit garantie de buna executie</label>
                        </div>
                    </div> 

                    <div class="form-group col-lg-12">               
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
            $( ".data_deschidere" ).datepicker({ minDate: 0, dateFormat: "dd-mm-yy"});         
        });

    </script>

@stop