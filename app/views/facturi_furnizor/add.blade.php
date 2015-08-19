@extends('layouts.master')

@section('title')
    <p>Adauga factura furnizor</p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif  
                    <div class="form-group col-lg-6
                        @if($errors->has('serie_facturare')) has-error 
                        @elseif(Input::old('serie_facturare')) has-success 
                        @endif ">
                        <label for = "">Serie/Numar</label>
                        <select name="serie_facturare" id="serie_facturare" 
                            class="selectpicker form-control col-lg-2">
                            @foreach ($serii_facturare as $serie) 
                              <option value="{{ $serie->id_serie_factura }}" @if (Input::old('serie_facturare')) selected @endif>{{ $serie->serie . '/' . $serie->numar }}</option>
                            @endforeach                                                     
                        </select>                        
                    </div>                  
                    <div class="col-lg-6 margin-bottom">
                        <label>Data facturare</label>
                        <div class="input-group 
                        @if ($errors->has('data_facturare')) has-error 
                        @elseif(Input::old('data_facturare')) has-success 
                        @endif">
                            <input 
                                class="form-control date1" 
                                name="data_facturare" 
                                data-placement="top" 
                                placeholder="Data facturare" 
                                type="text" 
                                value="{{ Input::old('data_facturare') }}" 
                                @if ($errors->has('data_facturare')) 
                                title="{{ $errors->first('data_facturare') }}" 
                                @endif />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>                                           
                    <div class="form-group col-lg-12
                        @if($errors->has('beneficiar')) has-error 
                        @elseif(Input::old('beneficiar')) has-success 
                        @endif ">
                        <label for = "">Beneficiar</label>
                        <select name="beneficiar" id="beneficiar" 
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Pentru cine este factura</option>
                            @foreach ($beneficiari as $beneficiar) 
                                <option value="{{ $beneficiar->id_entitate }}" @if (Input::old('beneficiar')) selected @endif>{{ $beneficiar->denumire }}</option>
                            @endforeach                            
                        </select>
                    </div>                                        
                    <div class="form-group col-lg-12
                        @if($errors->has('furnizor')) has-error 
                        @elseif(Input::old('furnizor')) has-success 
                        @endif ">
                        <label for = "">Furnizor</label>
                        <select name="furnizor" id="furnizor" 
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Cine emite factura</option>
                            @foreach ($furnizori as $furnizor) 
                                <option value="{{ $furnizor->id_entitate }}" @if (Input::old('furnizor')) selected @endif>{{ $furnizor->Denumire }}</option>
                            @endforeach                            
                        </select>
                    </div>  
                    <div class="form-group col-lg-6                   
                        @if ($errors->has('procent_tva')) has-error 
                        @elseif(Input::old('procent_tva')) has-success 
                        @endif">
                        <label>Procent TVA(%)</label>
                        <input class="form-control auto text-right" name="procent_tva" type="text" data-a-dec="," data-a-sep="." value="{{ Input::old('procent_tva') }}" 
                        @if ($errors->has('procent_tva')) 
                            title="{{ $errors->first('procent_tva') }}" 
                        @endif>
                    </div>
                    <div class="form-group col-lg-6                   
                        @if ($errors->has('termen_plata')) has-error 
                        @elseif(Input::old('termen_plata')) has-success 
                        @endif">
                        <label>Termen de plata (zile)</label>
                        <input class="form-control" name="termen_plata" type="text" value="{{ Input::old('termen_plata') }}" 
                        @if ($errors->has('termen_plata')) 
                            title="{{ $errors->first('termen_plata') }}" 
                        @endif>
                    </div>                                                                                                 
                    <div class="form-group col-lg-12 text-center">
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg" value="Salveaza" />
                        <input type="hidden" id="sf" name="sf">
                        <input type="hidden" id="nf" name="nf">
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
            $("#serie_facturare").trigger("change");
        });
        
        $('#serie_facturare').change( function () {
          var _text = $('#serie_facturare option:selected').text();
        
          if (_text.indexOf('/') > -1) {
              $('#sf').val(_text.split('/')[0]);
              $('#nf').val(_text.split('/')[1]);
          }
        });          
        $(function() {
            $( ".date1" ).datepicker({ minDate: 0, dateFormat: "dd-mm-yy"
            });         
        });
    </script>
@stop