@extends('layouts.master')

@section('title')
    Modifoca informatie statistica @if(isset($entitate)) {{ $entitate }} @endif
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
                        {{ Form::textField('An bilant', 'an', $informatii_statistice->an) }}                    
                    </div>
                    <div class="col-md-4">
                        {{ Form::textField('Numar angajati', 'numar_angajati', $informatii_statistice->num_angajati) }}                    
                    </div>
                    <div class="col-md-4">
                        {{ Form::textNumericField('Cifra de afaceri', 'cifra_afaceri', $informatii_statistice->cifra_afaceri) }}                    
                    </div>
                    <div class="col-md-3">
                        {{ Form::textNumericField('Profit exploatare', 'profit_exploatare', $informatii_statistice->profit_exploatare) }}                    
                    </div>
                    <div class="col-md-3">
                        {{ Form::textNumericField('Venituri', 'venituri', $informatii_statistice->venituri) }}                    
                    </div>
                    <div class="col-md-3">
                        {{ Form::textNumericField('Active totale', 'active_totale', $informatii_statistice->active_totale) }}                    
                    </div>
                    <div class="col-md-3">
                        {{ Form::textNumericField('Cheltuieli cercetare', 'cheltuieli_cercetare', $informatii_statistice->cheltuieli_cercetare) }}                    
                    </div>
                  
                    <div class="col-md-12 center"> 
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" />
                        <a href="{{ URL::route('informatii_statistice_list', [$id_entitate, $entitate, true]) }}">
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