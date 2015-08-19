@extends('layouts.master')

@section('title')
    <p>Adauga tip constructie</p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">                      
                <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                         
            </div>
            <br /><br />
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif               
                                                                
                    <div class="col-md-12">
                        {{ Form::textField('Denumire', 'denumire', $tip_constructie->denumire_tip_const) }}                    
                    </div>

                    <div class="col-md-12">
                        {{ Form::selectField('Categoria de care apartine tipul', 'categorie_constructie', ['' => 'Selecteaza categorie'] + $categorii_constructie, $tip_constructie->id_categoria_constructie) }}                    
                    </div>  
                                                                    
                    <div class="form-group col-lg-12">               
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg" value="Salveaza" />
                        {{ Form::token() }}
                    </div>                   
                </fieldset>
            </form>
        </div>
    </div>
@stop

@section('footer_scripts')
    {{ HTML::script('assets/js/segmentare.js') }}
    <script>        
        $(document).ready(function(){       

        });
    </script>
@stop