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
                    <div class="form-group col-lg-12
                        @if($errors->has('beneficiar')) has-error 
                        @elseif(Input::old('beneficiar')) has-success 
                        @endif ">
                        <label for = "">Beneficiar</label>
                        <select disabled name="beneficiar" id="beneficiar" 
                        class="selectpicker form-control" data-live-search="true">
                            @foreach ($beneficiari as $beneficiar) 
                                <option value="{{ $beneficiar->id_entitate }}" 
                                    @if ($beneficiar->id_entitate == $factura->id_beneficiar) selected @endif>
                                    {{ $beneficiar->denumire }}
                                </option>
                            @endforeach                            
                        </select>
                    </div>                                                                                                                                                              
                    <div class="form-group col-lg-12
                        @if($errors->has('furnizor')) has-error 
                        @elseif(Input::old('furnizor')) has-success 
                        @endif ">
                        <label for = "">Furnizor</label>
                        <select disabled name="furnizor" id="furnizor" 
                        class="selectpicker form-control" data-live-search="true">
                            @foreach ($furnizori as $furnizor) 
                                <option value="{{ $furnizor->id_entitate }}" 
                                @if ($furnizor->id_entitate == $factura->id_furnizor) selected @endif>{{ $furnizor->denumire }}</option>
                            @endforeach                            
                        </select>
                    </div>                                                   
                    <div class="form-group col-lg-6                   
                        @if ($errors->has('procent_tva')) has-error 
                        @elseif(Input::old('procent_tva')) has-success 
                        @endif">
                        <label>Procent TVA(%)</label>
                        <input class="form-control auto text-right" name="procent_tva" type="text" data-a-dec="," data-a-sep=".",
                        @if(Input::old('procent_tva')) 
                            value="{{ Input::old('procent_tva') }}" 
                        @else 
                            value="{{ $factura->tva }}" 
                        @endif
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('procent_tva') }}" 
                        @endif>
                    </div>    
                    <div class="form-group col-lg-6                   
                        @if ($errors->has('termen_plata')) has-error 
                        @elseif(Input::old('termen_plata')) has-success 
                        @endif">
                        <label>Termen de plata (zile)</label>
                        <input class="form-control text-right" name="termen_plata" type="text"
                        @if(Input::old('termen_plata')) 
                            value="{{ Input::old('termen_plata') }}" 
                        @else 
                            value="{{ $factura->termen_plata }}" 
                        @endif
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('termen_plata') }}" 
                        @endif>
                    </div> 
                    <div class="form-group col-lg-12                    
                        @if ($errors->has('observatii')) has-error 
                        @elseif(Input::old('observatii')) has-success 
                        @endif">
                        <label>Observatii</label>
                        <input class="form-control" name="observatii" id="observatii" rows="4" 
                        @if(Input::old('observatii')) 
                            value="{{ Input::old('observatii') }}" 
                        @else 
                            value="{{ $factura->observatii }}" 
                        @endif 
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('required') }}" 
                        @endif>
                        </input>
                    </div>  
                    <div class="form-group col-lg-12">               
                        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Salveaza" />                        
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