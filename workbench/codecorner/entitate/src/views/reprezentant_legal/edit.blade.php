@extends('layouts.master')

@section('title')
    Modifica reprezentant legal
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
                        {{ Form::textField('Nume si prenume', 'nume', $reprezentant->nume) }}                    
                    </div>                                                         
                    <div class="col-md-6">
                        {{ Form::textField('CNP', 'cnp', $reprezentant->cnp) }}                    
                    </div>                                                         
                                        
                    <div class="col-md-12 center"> 
                        <input type="submit" id="submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" disabled="disabled"/>
                        <a href="{{ URL::route('reprezentant_legal_list') }}">
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
        })
  
         $('#cnp,#nume').bind("change keyup input",(function(){
            if (verifica_cnp($('#cnp').val()))
            {
                $("#submit").removeAttr("disabled");
            } else {
                $('#submit').attr("disabled", "disabled");
            }
        }));
    </script>
@stop