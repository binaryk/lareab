@extends('layouts.master')

@section('title')
    Adauga reprezentant legal
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
                        value="{{ Input::old('nume') }}" 
                        @if ($errors->has('nume')) 
                            title="{{ $errors->first('nume') }}" 
                        @endif autofocus/>
                    </div>                                                           
                    <div class="form-group                         
                        @if ($errors->has('cnp')) has-error 
                        @elseif(Input::old('cnp')) has-success 
                        @endif">
                        <label>CNP *</label>
                        <input class="form-control" name="cnp" id="cnp" type="text" 
                        value="{{ Input::old('cnp') }}"
                        @if ($errors->has('required')) title="{{ $errors->first('required') }}" 
                        @endif/>
                    </div>

                    <div class="form-group                         
                        @if ($errors->has('entitate')) has-error 
                        @elseif(Input::old('entitate')) has-success 
                        @endif">
                        <label>Entitatea de care apartine *</label>
                        <select class="form-control" name="entitate" id="entitate">
                            @if(isset($id_entitate) && isset($denumire))
                                <option value="{{ $id_entitate }}">{{ $denumire }}</option>
                            @else
                                <option value="0">Selectioneaza o entitate</option>
                                @if(isset($entitati))
                                    @foreach($entitati as $entitate)
                                        <option value="{{ $entitate->id_entitate }}">
                                            {{ $entitate->denumire }}
                                        </option>
                                    @endforeach          
                                @endif                         
                            @endif
                        </select>                                           
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
        });
  
        $('#cnp,#nume,#entitate').bind("change keyup input",(function(){
            if (verifica_cnp($('#cnp').val()))
            {
                $("#submit").removeAttr("disabled");
            } else {
                $('#submit').attr("disabled", "disabled");
            }
        }));
    </script>
@stop