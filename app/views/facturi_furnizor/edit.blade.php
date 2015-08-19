@extends('layouts.master')

@section('title')       
    <p>Modifica factura
        @if(isset($factura->serie)) {{ $factura->serie . '/' . $factura->numar }} din data {{ $factura->data_facturare }} @endif
    </p>    
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif               
                    
                    <!--div class="col-md-12">
                        {{ Form::selectField('Beneficiar', 'beneficiar', $beneficiari, $factura->id_beneficiar) }}                    
                    </div> 

                    <div class="col-md-12">
                        {{ Form::selectField('Furnizor', 'furnizor', $furnizori, $factura->id_furnizor) }}                    
                    </div--> 
   
                    <div class="col-md-6">  
                        {{ Form::textNumericField('Procent TVA(%)','procent_tva', $factura->tva) }}
                    </div> 
                    <div class="col-md-6">  
                        {{ Form::textField('Termen de plata (zile)','termen_plata', $factura->termen_plata) }}
                    </div> 
                    
                    <div class="col-md-12">  
                        {{ Form::textField('Observatii','observatii', $factura->observatii) }}
                    </div>   
                    
                    <div class="col-md-12 center"> 
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" />
                        <a href="{{ URL::route('facturi_furnizor') }}">
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
        })
    </script>
@stop