@extends('layouts.master')

@section('title')
    Intrare document in registru
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif                  
                    <div class="form-group ">
                        <label>Expeditor</label>
                        <input class="form-control" name="expeditor" type="text" value="">
                    </div>                    
                    <!-- div class="form-group 
                        @if ($errors->has('numar_inregistrare_expeditor')) has-error 
                        @elseif(Input::old('numar_inregistrare_expeditor')) has-success 
                        @endif" >
                        <label>Numar de inregistrare expeditor</label>
                        <input class="form-group" name="numar_inregistrare_expeditor" type="text" value="">                   
                    </div -->
                    <div class="form-group 
                        @if ($errors->has('numar_inregistrare_expeditor')) has-error 
                        @elseif(Input::old('numar_inregistrare_expeditor')) has-success 
                        @endif" >
                        <label>Numar de inregistrare expeditor</label>
                        <input 
                            class="form-control" 
                            name="numar_inregistrare_expeditor" 
                            type="text" 
                            @if ($errors->has('numar_inregistrare_expeditor')) 
                                title="{{ $errors->first('numar_inregistrare_expeditor') }}" 
                            @endif/>
                    </div>                    
                    <div class="form-group ">
                        <label>Numar anexe</label>
                        <input class="form-control" name="numar_anexe" type="text" value="">
                    </div>
                    <div class="form-group ">
                        <label>Continut pe scurt</label>
                        <input class="form-control" name="continut" type="text" value="">
                    </div>
                    <div class="form-group ">
                        <label>Destinatar</label>
                        <input class="form-control" name="destinatar" type="text" value="">
                    </div>
                    <div class="form-group ">
                        <label>Observatii</label>
                        <input class="form-control" name="observatii" type="text" value="">
                    </div>

                    <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Salveaza" />
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