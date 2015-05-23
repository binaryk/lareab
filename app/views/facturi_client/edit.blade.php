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
                        @if($errors->has('prestator')) has-error 
                        @elseif(Input::old('prestator')) has-success 
                        @endif ">
                        <label for = "">Prestator</label>
                        <select disabled name="prestator" id="prestator"  
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Cine factureaza</option>
                            @foreach ($prestatori as $prestator) 
                                <option value="{{ $prestator->IdEntitate }}" 
                                    @if ($prestator->IdEntitate == $factura->id_prestator) selected @endif>
                                    {{ $prestator->Denumire }}
                                </option>
                            @endforeach                            
                        </select>
                    </div>                                                                                                                                                              
                    <div class="form-group col-lg-12
                        @if($errors->has('client')) has-error 
                        @elseif(Input::old('client')) has-success 
                        @endif ">
                        <label for = "">Client</label>
                        <select disabled name="client" id="client" 
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Pentru cine este factura</option>
                            @foreach ($clienti as $client) 
                                <option value="{{ $client->IdEntitate }}" 
                                    @if ($client->IdEntitate == $factura->id_client) selected @endif>
                                    {{ $client->Denumire }}
                                </option>
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
                        <input class="form-control" name="termen_plata" type="text"
                        @if(Input::old('termen_plata')) 
                            value="{{ Input::old('termen_plata') }}" 
                        @else 
                            value="{{ $factura->termen_plata }}" 
                        @endif
                        @if ($errors->has('termen_plata')) 
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
                        @endif></input>
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
    {{ HTML::script('segmentare.js') }}
    <script>        
        $(document).ready(function(){                      
        })
    </script>
@stop