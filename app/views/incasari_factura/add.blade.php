@extends('layouts.master')

@section('title')
    <p>Adauga incasare factura
        @if(isset($factura->serie)) {{ $factura->serie . '/' . $factura->numar }} din data {{ $factura->data_facturare }} @endif
    </p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif               

                    <div class="col-lg-4 margin-bottom">
                        <label>Data incasarii</label>
                        <div class="input-group 
                        @if ($errors->has('data_incasare')) has-error 
                        @elseif(Input::old('data_incasare')) has-success 
                        @endif">
                            <input 
                                class="form-control date1" 
                                name="data_incasare" 
                                data-placement="top" 
                                placeholder="Data incasare" 
                                type="text" 
                                value="{{ Input::old('data_incasare') }}" 
                                @if ($errors->has('data_incasare')) 
                                title="{{ $errors->first('data_incasare') }}" 
                                @endif />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-4                    
                        @if ($errors->has('valoare_incasata')) has-error 
                        @elseif(Input::old('valoare_incasata')) has-success 
                        @endif">
                        <label>Valoare incasata</label>
                        <input class="form-control auto text-right" name="valoare_incasata" type="text" 
                        data-a-dec="," data-a-sep="."  
                        value="{{ Input::old('valoare_incasata') }}" 
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('required') }}" 
                        @endif>
                    </div>                                                                 
                    <div class="form-group col-lg-4                    
                        @if ($errors->has('valoare_virata_CG')) has-error 
                        @elseif(Input::old('valoare_virata_CG')) has-success 
                        @endif">
                        <label>Valoare virata in contul de garantie</label>
                        <input class="form-control auto text-right" name="valoare_virata_CG" 
                        type="text" data-a-dec="," data-a-sep="." 
                        value="{{ Input::old('valoare_virata_CG') }}" 
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('required') }}" 
                        @endif>
                    </div>                                                                                                                                                                                              
                    <div class="col-md-12 center"> 
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" />
                        <a href="{{ URL::route('incasari_factura', $factura->id) }}">
                            <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
                        </a>                         
                    </div>                  
                </fieldset>
            </form>
        </div>
    </div>
@stop

@section('footer_scripts')
    {{ HTML::script('segmentare.js') }}
    <script>        
        $(document).ready(function(){       
        });
        $(function() {
            $( ".date1" ).datepicker({ minDate: 0, dateFormat: "dd-mm-yy"
            });         
        });
    </script>
@stop