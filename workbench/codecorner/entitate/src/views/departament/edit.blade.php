@extends('layouts.master')

@section('title')
    Modifica date departament
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
                        {{ Form::textField('Denumire departament', 'denumire', $departament->denumire) }}                    
                    </div>

                    <div class="col-md-12">
                        {{ Form::textareaField('Descriere departament', 'descriere', $departament->descriere) }}                    
                    </div>

                    <div class="col-md-12">
                        {{ Form::selectField('Entitati', 'entitate', isset($entitati) ? $entitati : [$id_entitate => $denumire], $departament->id_entitate) }}                    
                    </div>                                    
                  
                    <div class="col-md-12 center"> 
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" />
                        <a href="{{ URL::route('departament_list_organizatie') }}">
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
    </script>
@stop