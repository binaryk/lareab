@extends('layouts.master')

@section('title')
    Adauga personal entitate
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
                    <input type="submit" name="submit" id="submit" class="btn btn-primary btn-lg" value="Salveaza" />
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
    </script>
@stop