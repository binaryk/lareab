@extends('layouts.master')

@section('title')
    Modifica personal grup
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
                        {{ Form::textField('Nume si prenume', 'nume', $persoana->nume) }}                    
                    </div>                                                         
                    <div class="col-md-6">
                        {{ Form::textField('CNP', 'cnp', $persoana->cnp) }}                    
                    </div>                                                         
                    <div class="col-md-6">
                        {{ Form::textField('Telefon 1', 'telefon_1', $persoana->telefon_1) }}                    
                    </div>                                                         
                    <div class="col-md-6">
                        {{ Form::textField('Telefon 2', 'telefon_2', $persoana->telefon_2) }}                    
                    </div>                                                         
                    <div class="col-md-6">
                        {{ Form::textField('Mail 1', 'mail_1', $persoana->mail_1) }}                    
                    </div>                                                         
                    <div class="col-md-6">
                        {{ Form::textField('Mail 2', 'mail_2', $persoana->mail_2) }}                    
                    </div>                                                         
                    <div class="col-md-6">
                        {{ Form::selectField('Ocupatie', 'ocupatie', ['' => 'Selectioneaza ocupatie'] + $ocupatii, $persoana->id_ocupatie) }}
                    </div>

                    <div class="col-md-12 center"> 
                        <input type="submit" id="submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" disabled="disabled"/>
                        <a href="{{ URL::route('personal_list') }}">
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
        $('input, select').bind("change keyup input",(function(){
            if (verifica_cnp($('#cnp').val()))
            {
                $("#submit").removeAttr("disabled");
            } else {
                $('#submit').attr("disabled", "disabled");
            }
        }));         
    </script>
@stop