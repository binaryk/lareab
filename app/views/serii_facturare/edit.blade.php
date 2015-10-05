@extends('layouts.master')

@section('title')
    <p>Modifica serie facturare</p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif                                                    
                    
                    <div class="col-md-6">
                        {{ Form::selectField('Denumire entitate', 'entitate', $entitati, $serie->id_entitate) }}                    
                    </div>   
                    
                    <div class="col-md-3">
                        {{ Form::textField('Serie factura', 'serie', $serie->serie) }}                    
                    </div> 

                    <div class="col-md-3">
                        {{ Form::textField('Numar factura', 'numar', $serie->numar) }}                    
                    </div> 
                                                                    
                    <div class="col-md-12 center"> 
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" />
                        <a href="{{ URL::route('serii_facturare') }}">
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