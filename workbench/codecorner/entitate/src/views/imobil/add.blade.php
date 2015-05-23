@extends('layouts.master')

@section('title')
    <p>Adauga imobil</p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif     
        
                    <div class="form-group col-lg-12                    
                        @if ($errors->has('adresa')) has-error 
                        @elseif(Input::old('adresa')) has-success 
                        @endif">
                        <label>Adresa</label>
                        <input class="form-control" name="adresa" type="text" value="{{ Input::old('adresa') }}" 
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('required') }}" 
                        @endif>
                    </div>   
                    <div class="form-group col-lg-4
                        @if($errors->has('tara')) has-error 
                        @elseif(Input::old('tara')) has-success 
                        @endif ">
                        <label>Tara</label>
                        <select 
                            id="tara" 
                            class="selectpicker form-control" 
                            name="tara" 
                            data-live-search="true">                            
                        </select>
                    </div>
                    <div class="form-group col-lg-4
                        @if($errors->has('regiune')) has-error 
                        @elseif(Input::old('regiune')) has-success 
                        @endif ">
                        <label>Regiune</label>
                        <select 
                            name="regiune" 
                            id="regiune" 
                            class="selectpicker form-control" 
                            data-live-search="true">                 
                        </select>
                    </div>

                    <div class="form-group judet col-lg-4
                        @if($errors->has('judet')) has-error 
                        @elseif(Input::old('judet')) has-success 
                        @endif ">
                        <label for = "">Judet</label>
                        <select 
                            name="judet" 
                            id="judet" 
                            class="selectpicker form-control" 
                            data-live-search="true">                 
                        </select>
                    </div>

                    <div class="form-group col-lg-10
                        @if($errors->has('localitate')) has-error 
                        @elseif(Input::old('localitate')) has-success 
                        @endif ">
                        <label for = "">Localitate</label>
                        <select 
                            name="localitate" 
                            id="localitate" 
                            class="selectpicker form-control" 
                            data-live-search="true">                 
                        </select>
                    </div>

                    <div class="form-group col-lg-2                   
                        @if ($errors->has('cod_postal')) has-error 
                        @elseif(Input::old('cod_postal')) has-success 
                        @endif">
                        <label>Cod postal</label>
                        <input class="form-control" name="cod_postal" type="text" id="cod_postal" value="{{ Input::old('cod_postal') }}" 
                        @if ($errors->has('cod_postal')) 
                            title="{{ $errors->first('cod_postal') }}" 
                        @endif>
                    </div>                                                                                     
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('lot')) has-error 
                        @elseif(Input::old('lot')) has-success 
                        @endif">
                        <label>Lot</label>
                        <input class="form-control" name="lot" type="text" value="{{ Input::old('lot') }}" 
                        @if ($errors->has('lot')) 
                            title="{{ $errors->first('lot') }}" 
                        @endif>
                    </div>                                                                 
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('numar_lot')) has-error 
                        @elseif(Input::old('numar_lot')) has-success 
                        @endif">
                        <label>Numar lot</label>
                        <input class="form-control" name="numar_lot" type="text" value="{{ Input::old('numar_lot') }}" 
                        @if ($errors->has('numar_lot')) 
                            title="{{ $errors->first('numar_lot') }}" 
                        @endif>
                    </div>                                                                  
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('numar_apartamente')) has-error 
                        @elseif(Input::old('numar_apartamente')) has-success 
                        @endif">
                        <label>Numar apartamente</label>
                        <input class="form-control" name="numar_apartamente" type="text" value="{{ Input::old('numar_apartamente') }}" 
                        @if ($errors->has('numar_apartamente')) 
                            title="{{ $errors->first('numar_apartamente') }}" 
                        @endif>
                    </div>                                                                                                                                                   
                    <div class="form-group col-lg-12 text-center">
                        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Salveaza" />
                    </div>
                    {{ Form::token() }}
                </fieldset>
            </form>
        </div>
    </div>
@stop

@section('footer_scripts')
    {{ HTML::script('assets/js/segmentare.js') }}
    <script>        
        $(document).ready(function(){       
            var tari = getTari();
            console.log(tari);
            tari = JSON.parse(tari);
            console.log(tari);
            $("#tara").empty().append('<option value="0">Selecteaza o tara</option>');                
            for (var key in tari) {
                if (tari.hasOwnProperty(key)) {                
                    $("#tara").append('<option value="' + 
                        tari[key].IdTara+'">' + 
                        tari[key].Denumire + '</option>');                
                }            
            }
        })
          
        $('#tara').change(function(){
            //var regiuni = getRegiuni($(this).val());
            var functie = 'getRegiuni_tara_' + $(this).val().toString();
            console.log(functie);
            var fn = window[functie];
            var regiuni = null;
            if (typeof fn === "function") 
                regiuni = fn();            
            
            //console.log(regiuni);            
            regiuni = JSON.parse(regiuni);
            //console.log(regiuni);
            $("#regiune").empty().append('<option value="0">Selecteaza o regiune</option>');                
            for (var key in regiuni) {
                if (regiuni.hasOwnProperty(key)) {                
                    $("#regiune").append('<option value="' + 
                        regiuni[key].IdRegiune+'">' + 
                        regiuni[key].Denumire + '</option>');                
                }            
            }
        });   

        $('#regiune').change(function(){
            var functie = 'getJudete_regiune_' + $(this).val().toString();
            console.log(functie);
            var fn = window[functie];
            var judete = null;
            if (typeof fn === "function") 
                judete = fn();            
   
            judete = JSON.parse(judete);
            $("#judet").empty().append('<option value="0">Selecteaza un judet</option>');                
            for (var key in judete) {
                if (judete.hasOwnProperty(key)) {                
                    $("#judet").append('<option value="' + 
                        judete[key].IdJudet+'">' + 
                        judete[key].Denumire + '</option>');                
                }            
            }
        });   

        $('#judet').change(function(){
            var functie = 'getLocalitati_judet_' + $(this).val().toString();
            console.log(functie);
            var fn = window[functie];
            var localitati = null;
            if (typeof fn === "function") 
                localitati = fn();            

            localitati = JSON.parse(localitati);
            $("#localitate").empty().append('<option value="0">Selecteaza o localitate</option>');                
            for (var key in localitati) {
                if (localitati.hasOwnProperty(key)) {                
                    $("#localitate").append('<option value="' + 
                        localitati[key].IdLocalitate+'">' + 
                        localitati[key].Denumire + '</option>');                
                }            
            }
        });

        $('#localitate').change(function(){
            var functie = 'getcod_postal_localitate_' + $(this).val().toString();
            console.log(functie);
            var fn = window[functie];
            var cod_postal = null;
            if (typeof fn === "function") 
                cod_postal = fn();                        
            $("#cod_postal").val(cod_postal);
        });

    </script>
@stop