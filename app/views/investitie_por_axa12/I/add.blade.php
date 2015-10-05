@extends('layouts.master')

@section('title')
    Adauga obiect investitie
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif                  
  
                    <div class="col-md-12">
                        {{ Form::textField('Denumire obiect', 'denumire') }}                    
                    </div>                                                         
                                        
                    <div class="col-md-12 center"> 
                        <input type="submit" id="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" disabled="disabled"/>
                        <a href="{{ URL::route('investitie_por_axa12_obiecte_list', $id_investitie) }}">
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
    <script>
        $(document).ready(function(){
        });
  
        $('input').bind("change keyup input",(function(){
            $("#btn_submit").removeAttr("disabled");
        }));
    </script>
@stop