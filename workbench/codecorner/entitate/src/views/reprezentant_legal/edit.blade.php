@extends('layouts.master')

@section('title')
    Modifica reprezentant legal
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
                        @if ($errors->has('nume')) has-error 
                        @elseif(Input::old('nume')) has-success 
                        @endif">
                        <label>Nume si prenume *</label>
                        <input class="form-control" name="nume" id="nume" type="text"
                        @if(Input::old('denumire')) 
                            value="{{ Input::old('nume') }}" 
                        @else 
                            value="{{ $reprezentant->nume }}" 
                        @endif                        
                        @if ($errors->has('nume')) 
                            title="{{ $errors->first('nume') }}" 
                        @endif>
                    </div>                                                           
                    <div class="form-group                         
                        @if ($errors->has('cnp')) has-error 
                        @elseif(Input::old('cnp')) has-success 
                        @endif">
                        <label>CNP *</label>
                        <input class="form-control" name="cnp" id="cnp" type="text"
                        @if(Input::old('cnp')) 
                            value="{{ Input::old('cnp') }}" 
                        @else 
                            value="{{ $reprezentant->cnp }}" 
                        @endif 
                        @if ($errors->has('cnp')) 
                            title="{{ $errors->first('cnp') }}" 
                        @endif>
                    </div>                                                    
                    <input type="submit" name="submit" id="submit" disabled class="btn btn-primary btn-lg" value="Salveaza" />
                    {{ Form::token() }}
                </fieldset>
            </form>
        </div>
    </div>
@stop

@section('footer_scripts')
    {{ HTML::script('assets/js/cnp.js') }}
    <script>
        $(document).ready(function(){
        })
  
         $('#cnp,#nume').bind("change keyup input",(function(){
            //if (verifica_cnp($(this).val().toString()))
            if (verifica_cnp($('#cnp').val()))
            {
                $("#submit").removeAttr("disabled");
            } else {
                $('#submit').attr("disabled", "disabled");
            }
        }));
    </script>
@stop