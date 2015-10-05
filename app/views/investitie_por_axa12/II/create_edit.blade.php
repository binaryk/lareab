@extends('layouts.master')

@section('title')
    Adauga / Modifica valori articol deviz
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif                  
  
                    <div class="col-md-4">
                        {{ Form::textNumericField('Valoare fara TVA (Etapa STUDIU DE FEZABILITATE)', 'val_sf', $articol->valoare_ftva_1) }}                    
                    </div>                                                         
                    <div class="col-md-4">
                        {{ Form::textNumericField('Valoare fara TVA (Etapa PROIECT TEHNIC)', 'val_pt', $articol->valoare_ftva_2) }}
                    </div>                                                     
                    <div class="col-md-4">
                        {{ Form::textNumericField('Valoare fara TVA (Etapa FINAL ACHIZITII)', 'val_fa', $articol->valoare_ftva_3) }}                    
                    </div>

                    <div class="col-md-12 center"> 
                        <input type="submit" id="submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" disabled="disabled"/>
                        <a href="{{ URL::route('investitie_por_axa12_articol_valori_list', $id_investitie) }}">
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
            $("#submit").removeAttr("disabled");
        }));
    </script>
@stop