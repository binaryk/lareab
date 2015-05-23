@extends('layouts.master')

@section('title')
    <p>Adauga etapa la obiectiv</p>
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
                        <input class="form-control" name="nr_etapa" type="text" value="{{ Input::old('nr_etapa') }}" 
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('required') }}" 
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
                                placeholder="Data inceperii" 
                                type="text" 
                                value="{{ Input::old('data_inceperii') }}" 
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
                        <input class="form-control" name="termen_predare" id="termen_predare" type="text" value="{{ Input::old('termen_predare') }}" 
                        @if ($errors->has('termen_predare')) 
                            title="{{ $errors->first('termen_predare') }}" 
                        @endif>                                            
                    </div>    
                    <div class="form-group col-lg-6
                        @if($errors->has('um_timp')) has-error 
                        @elseif(Input::old('um_timp')) has-success 
                        @endif ">
                        <label for = "">Unitatea de masura</label>
                        <select class="form-control" name="um_timp" id="um_timp">
                            <option value="0">Selectioneaza unitatea de masura</option>
                            @foreach($ums_timp as $um_timp)
                                <option value="{{ $um_timp->id_um }}">
                                    {{ $um_timp->denumire }}
                                </option>
                            @endforeach                             
                        </select>  
                    </div>                                                                                                                                                   
                    <div class="form-group col-lg-12                   
                        @if ($errors->has('instiintare')) has-error 
                        @elseif(Input::old('instiintare')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                            {{ Form::checkbox('instiintare', '1', Input::old('instiintare', '')) }}
                            <label for="instiintare" class="label_check">Necesita ordin de incepere de la contractor</label>
                        </div>
                    </div>                                                
                       
                    <div class="row col-lg-12 text-center">
                        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Salveaza" />
                        <a href="{{ URL::route('etapa_list', $id_obiectiv) }}">
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
            $("#back").click(function(){
                //window.history.go(-1);
            });            
            $('#submit').click(function(){        
                $('#submit').attr("disabled", "disabled");                            
                setTimeout(function(){ $('#submit').removeAttr("disabled"); }, 3000);
            });
        });  
        $(function() {
            $( ".date1" ).datepicker({ minDate: 0, dateFormat: "dd-mm-yy"
            });         
        });
    </script>
@stop