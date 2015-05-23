@extends('layouts.master')

@section('title')
    <p>Modifica date etapa
        @if(isset($etapa->NrEtapa)) {{ $etapa->NrEtapa }} @endif
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
                    <div class="form-group col-lg-6                    
                        @if ($errors->has('nr_etapa')) has-error 
                        @elseif(Input::old('nr_etapa')) has-success 
                        @endif">
                        <label>Numar etapa</label>
                        <input class="form-control" name="nr_etapa" type="text"
                        @if(Input::old('nr_etapa')) 
                            value="{{ Input::old('nr_etapa') }}" 
                        @else 
                            value="{{ $etapa->nr_etapa }}" 
                        @endif
                        @if ($errors->has('nr_etapa')) 
                            title="{{ $errors->first('nr_etapa') }}" 
                        @endif>
                    </div>   
                    <div class="form-group col-lg-6 margin-bottom">
                        <label>Data inceperii</label>
                        <div class="input-group 
                        @if ($errors->has('data_inceperii')) has-error 
                        @elseif(Input::old('data_inceperii')) has-success 
                        @endif">
                            <input 
                                class="form-control date1" 
                                name="data_inceperii" 
                                data-placement="top" 
                                placeholder="Data semnarii" 
                                type="text" 
                                @if(Input::old('data_inceperii')) 
                                    value="{{ Input::old('data_inceperii') }}" 
                                @else 
                                    value="{{ $etapa->data_start }}" 
                                @endif                                
                                @if ($errors->has('data_inceperii')) 
                                title="{{ $errors->first('data_inceperii') }}" 
                                @endif />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>                                                                                    
                    <div class="form-group col-lg-6                   
                        @if ($errors->has('termen_predare')) has-error 
                        @elseif(Input::old('termen_predare')) has-success 
                        @endif">
                        <label>Termen predare</label>
                        <input class="form-control" name="termen_predare" type="text"
                        @if(Input::old('termen_predare')) 
                            value="{{ Input::old('termen_predare') }}" 
                        @else 
                            value="{{ $etapa->termen_predare }}" 
                        @endif                        
                        @if ($errors->has('termen_predare')) 
                            title="{{ $errors->first('termen_predare') }}" 
                        @endif>
                    </div>        
                    <div class="form-group col-lg-6
                        @if($errors->has('um_timp')) has-error 
                        @elseif(Input::old('um_timp')) has-success 
                        @endif ">
                        <label for = "">Unitatea de masura</label>
                        <select name="um_timp" id="um_timp" class="selectpicker form-control" data-live-search="true">
                            <option value="0">Selectioneaza unitatea de masura</option>
                            @foreach ($ums_timp as $um_timp) 
                                <option value="{{ $um_timp->id_um }}" 
                                    @if ($um_timp->id_um == $etapa->id_um_timp) selected 
                                    @endif>{{ $um_timp->denumire }}
                                </option>                               
                            @endforeach                            
                        </select>
                    </div>                                                                                  
                    <div class="form-group col-lg-12">                       
                        <div class="checkbox checkbox-primary">
                            {{ Form::checkbox('instiintare', '1', Input::old('instiintare', $etapa->instiintare_contractor)) }}
                            <label for="instiintare" class="label_check">Necesita ordin de incepere de la contractor</label>
                        </div>
                    </div>             

                    <div class="row col-lg-12 text-center">
                        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Salveaza" />
                        <a href="{{ URL::route('etapa_list', $etapa->id_obiectiv) }}">
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
        });            
        $(function() {
            $( ".date1" ).datepicker({ minDate: 0, dateFormat: "dd-mm-yy"
            });         
        });
    </script>
@stop