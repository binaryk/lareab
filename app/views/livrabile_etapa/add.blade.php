@extends('layouts.master')

@section('title')
    <p>Adauga livrabil la etapa</p>
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
                        {{ Form::selectField('Livrabile disponibile', 'livrabil', $livrabile, Input::old('livrabil')) }}                    
                    </div>

                    <div class="col-md-8">
                        {{ Form::selectField('Stadiu livrabil', 'stadiu', $stadii, Input::old('stadiu')) }}                    
                    </div> 

                    @if (Entrust::can('manage_finance'))                                         
                        <div class="col-md-4">
                            {{ Form::textNumericField('Valoare fara TVA', 'valoare_livrabil') }}                    
                        </div>
                    @endif
                    <div class="row col-lg-12 text-center">
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" />
                        <a href="{{ URL::route('livrabile_etapa_list', $id_etapa) }}">
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
            $('#btn_submit').click(function(){        
                $('#btn_submit').attr("disabled", "disabled");                            
                setTimeout(function(){ $('#btn_submit').removeAttr("disabled"); }, 3000);
            });
        });  
    </script>
@stop