@extends('layouts.master')

@section('title')
    Adaugă sucursală bancară
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
                        {{ Form::selectField('Banca', 'id_banca', $banci, $banca->id_banca) }}                    
                    </div>                 
                    <div class="col-md-6">
                        {{ Form::textField('Sucursala', 'sucursala', $banca->sucursala) }}                    
                    </div>

                    <div class="col-md-6">
                        {{ Form::textField('IBAN', 'iban', $banca->iban) }}                    
                    </div>
                  
                    <div class="col-md-12 center"> 
                        <input type="submit" id="submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" disabled="disabled"/>
                        <a href="{{ URL::route('banci_list_entitate', [$id_entitate, $entitate]) }}">
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
    {{ HTML::script('assets/js/iban.js') }}      
    <script>
        $(document).ready(function(){
        });
        $('#sucursala,#iban').bind("change keyup input",(function(){
            console.log("intrat");
            if (iban_valid($('#iban').val()))
            {
                console.log('valid');
                $("#submit").removeAttr("disabled");
            } else {
                console.log('innnnnvalid');
                $('#submit').attr("disabled", "disabled");
            }
        }));     
    </script>
@stop