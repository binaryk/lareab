@extends('layouts.master')

@section('title')
    Adauga ocupatie
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif                  
                    <div class="col-md-2">
                        {{ Form::textField('Cod ocupatie', 'id') }}                    
                    </div> 
                    <div class="col-md-10">
                        {{ Form::textField('Denumire ocupatie', 'denumire') }}                    
                    </div>                                                         
                                                                                                       
                    <div class="col-md-12 center"> 
                        <input type="submit" id="submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" disabled="disabled"/>
                        <a href="{{ URL::route('ocupatii_list') }}">
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
    {{ HTML::script('assets/js/cnp.js') }}
    <script>
        $(document).ready(function(){
        }); 
        $('input').bind("change keyup input",(function(){
            $("#submit").removeAttr("disabled");
        }));         
       
    </script>
@stop