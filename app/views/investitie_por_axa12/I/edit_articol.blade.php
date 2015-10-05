@extends('layouts.master')

@section('title')
    Modifica articol de deviz
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif                  
  
                    <div class="col-md-12">
                        {{ Form::textField('Denumire articol de deviz', 'denumire', $articol->denumire) }}                    
                    </div>                                                         
                    <div class="col-md-6">
                        {{ Form::selectField('Destinatie spatiu', 'destinatie_spatiu', $destinatie_spatiu, $articol->id_destinatie_spatiu) }}                    
                    </div>                                 
                    
                    <div class="col-md-6">
                        {{ Form::selectField('Tip lucrari', 'tip_lucrari', $tip_lucrari, $articol->id_tip_lucrare) }}                    
                    </div>

                    <div class="form-group col-lg-12                   
                        @if ($errors->has('esl')) has-error 
                        @elseif(Input::old('esl')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                            {{ Form::checkbox('esl', '0', Input::old('esl', $articol->eligibil_spatii_locuit)) }}
                            <label for="esl" class="label_check">Eligibil spatii de locuit</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-12                   
                        @if ($errors->has('nesl')) has-error 
                        @elseif(Input::old('nesl')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                            {{ Form::checkbox('esl', '0', Input::old('nesl', $articol->neeligibil_spatii_locuit)) }}
                            <label for="nesl" class="label_check">Neeligibil spatii de locuit</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-12                   
                        @if ($errors->has('nsad')) has-error 
                        @elseif(Input::old('nsad')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                            {{ Form::checkbox('nsad', '0', Input::old('nsad', $articol->neeligibil_spatii_alta_destinatie)) }}
                            <label for="nsad" class="label_check">Neeligibil spatii alta destinatie</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-12                   
                        @if ($errors->has('esad')) has-error 
                        @elseif(Input::old('esad')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                            {{ Form::checkbox('esad', '0', Input::old('esad', $articol->eligibil_spatii_alta_destinatie)) }}
                            <label for="esad" class="label_check">Eligibil spatii alta destinatie</label>
                        </div>
                    </div>

                    <div class="col-md-12 center"> 
                        <input type="submit" id="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" disabled="disabled"/>
                        <a href="{{ URL::route('investitie_por_axa12_obiecte_list', $id_investitie) }}">
                            <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
                        </a>                         
                    </div>
                    {{ Form::token() }}
                </fieldset>
            </form>
        </div>
    </div>
@stop

@section('footer_scripts')
    <script>
        $(document).ready(function(){
        });
  
        $('input').bind("change keyup input",(function(){
            $("#btn_submit").removeAttr("disabled");
        }));
    </script>
@stop