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
                    <div class="form-group col-lg-12
                        @if($errors->has('livrabil')) has-error 
                        @elseif(Input::old('livrabil')) has-success 
                        @endif ">
                        <label for = "">Livrabile disponibile</label>
                        <select class="form-control" name="livrabil" id="livrabil">
                            <option value="0">Selectioneaza un livrabil</option>
                            @foreach($livrabile as $livrabil)
                                <option value="{{ $livrabil->id_livrabil }}">
                                    {{ $livrabil->denumire }}
                                </option>
                            @endforeach                             
                        </select>  
                    </div>                                                                                                                                                   
                    <div class="form-group col-lg-6                   
                        @if ($errors->has('valoare_livrabil')) has-error 
                        @elseif(Input::old('valoare_livrabil')) has-success 
                        @endif">
                        <label>Valoare fara TVA</label>
                        <input class="form-control auto text-right" name="valoare_livrabil" type="text" data-a-dec="," data-a-sep="." value="{{ Input::old('valoare_livrabil') }}" 
                        @if ($errors->has('valoare_obiectiv')) 
                            title="{{ $errors->first('valoare_livrabil') }}" 
                        @endif>
                    </div>                                               
                    <div class="form-group col-lg-6
                        @if($errors->has('stadiu')) has-error 
                        @elseif(Input::old('stadiu')) has-success 
                        @endif ">
                        <label for = "">Stadiu livrabil</label>
                        <select class="form-control" name="stadiu" id="stadiu">
                            <option value="0">Selectioneaza un stadiul livrabilului</option>
                            @foreach($stadii as $stadiu)
                                <option value="{{ $stadiu->id_stadiu_livrabil }}">
                                    {{ $stadiu->denumire }}
                                </option>
                            @endforeach                             
                        </select>  
                    </div>                              
                    <div class="row col-lg-12 text-center">
                        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Salveaza" />
                        <a href="{{ URL::route('livrabile_etapa_list', $id_etapa) }}">
                            <input type="button" id="back" class="btn btn-warning btn-lg" value="Inapoi" />
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
            $('#submit').click(function(){        
                $('#submit').attr("disabled", "disabled");                            
                setTimeout(function(){ $('#submit').removeAttr("disabled"); }, 3000);
            });
        });  
    </script>
@stop