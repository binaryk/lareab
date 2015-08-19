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
                    <div class="col-md-6">
                        {{ Form::textField('Numar etapa', 'nr_etapa', $etapa->nr_etapa) }}                    
                    </div>                    
                    <div class="col-md-6">
                        {{ Form::textField('Data inceperii', 'data_start', $etapa->data_start, ['class'=>'form-control date1'], '<i class="fa fa-calendar"></i>', $etapa->data_start) }}                    
                    </div>  
                    <div class="col-md-6">
                        {{ Form::textNumericField('Termen predare', 'termen_predare', $etapa->termen_predare) }}                    
                    </div>                  
                    <div class="col-md-6">
                        {{ Form::selectField('Unitate de masura de timp', 'um_timp', $ums_timp, $etapa->id_um_timp) }}                    
                    </div>                                                   
                                                                                     
                    <div class="form-group col-lg-12">                       
                        <div class="checkbox checkbox-primary">
                            {{ Form::checkbox('instiintare', '1', Input::old('instiintare', $etapa->instiintare_contractor)) }}
                            <label for="instiintare" class="label_check">Necesita ordin de incepere de la contractor</label>
                        </div>
                    </div>             

                    <div class="row col-lg-12 text-center">
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg" value="Salveaza" />
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
        $(function() {
            $( ".date1" ).datepicker({ minDate: new Date(2010, 1, 1), dateFormat: "dd-mm-yy"
            });         
        });
    </script>
@stop