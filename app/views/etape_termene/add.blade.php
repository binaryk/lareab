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
                    <div class="col-md-6">
                        {{ Form::textField('Numar etapa', 'nr_etapa') }}                    
                    </div>                    
                    <div class="col-md-6">
                        {{ Form::textField('Data inceperii', 'data_start', null, ['class'=>'form-control date1'], '<i class="fa fa-calendar"></i>') }}                    
                    </div>  
                    <div class="col-md-6">
                        {{ Form::textNumericField('Termen predare', 'termen_predare') }}                    
                    </div>                  
                    <div class="col-md-6">
                        {{ Form::selectField('Unitate de masura de timp', 'um_timp', $ums_timp) }}                    
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
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" />
                        <a href="{{ URL::route('etapa_list', $id_obiectiv) }}">
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
            $("#back").click(function(){
                //window.history.go(-1);
            });            
            $('#btn_submit').click(function(){        
                $('#btn_submit').attr("disabled", "disabled");                            
                setTimeout(function(){ $('#btn_submit').removeAttr("disabled"); }, 3000);
            });
        });  
        $(function() {
            $( ".date1" ).datepicker({ minDate: new Date(2010, 1, 1), dateFormat: "dd-mm-yy"
            });         
        });
    </script>
@stop