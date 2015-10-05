@extends('layouts.master')

@section('title')
    Adauga document de iesire in registru
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif                  
                    <div class="form-group                         
                        @if ($errors->has('expeditor')) has-error 
                        @elseif(Input::old('expeditor')) has-success 
                        @endif">
                        <label>Expeditor</label>
                        <input class="form-control" name="expeditor" type="text" value=""
                        @if ($errors->has('expeditor')) 
                            title="{{ $errors->first('expeditor') }}" 
                        @endif>
                    </div>                                                 
                    <div class="form-group                         
                        @if ($errors->has('numar_inregistrare_intrare')) has-error 
                        @elseif(Input::old('numar_inregistrare_intrare')) has-success 
                        @endif">

                        <label>Relationat cu documentul de intrare</label>
                            <select class="form-control" name="numar_inregistrare_intrare">
                                <option value="0">Selectioneaza un document de intrare</option>
                                @foreach($intrari as $intrare)
                                    <option value="{{ $intrare->id_registru }}">
                                    {{ 
                                        "Doc.nr. " . 
                                        $intrare->numar_inregistrare . " (" .
                                        $intrare->expeditor . ", " .
                                        $intrare->continut . ")" 
                                        }}
                                    </option>
                                @endforeach                                   
                            </select>                        
                    </div>             
                    <div class="form-group                         
                        @if ($errors->has('numar_anexe')) has-error 
                        @elseif(Input::old('numar_anexe')) has-success 
                        @endif">
                        <label>Numar anexe</label>
                        <input class="form-control" name="numar_anexe" type="text" value=""
                        @if ($errors->has('numar_anexe')) 
                            title="{{ $errors->first('numar_anexe') }}" 
                        @endif>
                    </div>
                     <div class="form-group                         
                        @if ($errors->has('continut')) has-error 
                        @elseif(Input::old('continut')) has-success 
                        @endif">
                        <label>Continut pe scurt</label>
                        <input class="form-control" name="continut" type="text" value=""
                        @if ($errors->has('continut')) 
                            title="{{ $errors->first('continut') }}" 
                        @endif>
                    </div>
                     <div class="form-group                         
                        @if ($errors->has('destinatar')) has-error 
                        @elseif(Input::old('destinatar')) has-success 
                        @endif">
                        <label>Destinatar</label>
                        <input class="form-control" name="destinatar" type="text" value=""
                        @if ($errors->has('destinatar')) 
                            title="{{ $errors->first('destinatar') }}" 
                        @endif>
                    </div>
                     <div class="form-group                         
                        @if ($errors->has('observatii')) has-error 
                        @elseif(Input::old('observatii')) has-success 
                        @endif">
                        <label>Observatii</label>
                        <input class="form-control" name="observatii" type="text" value=""
                        @if ($errors->has('observatii')) 
                            title="{{ $errors->first('observatii') }}" 
                        @endif>
                    </div>

                    <input type="submit" name="btn_submit" class="btn btn-primary btn-lg" value="Salveaza" />
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