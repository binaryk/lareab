@extends('layouts.master')

@section('title')
    <p>Adauga client partener al organizatiei</p>
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
                        @if ($errors->has('denumire')) has-error 
                        @elseif(Input::old('denumire')) has-success 
                        @endif">
                        <label>Denumire</label>
                        <input class="form-control" name="denumire" type="text" value="{{ Input::old('denumire') }}" 
                        @if ($errors->has('required')) 
                            title="{{ $errors->first('required') }}" 
                        @endif>
                    </div>                                                                 
                    <div class="form-group col-lg-6                   
                        @if ($errors->has('cif')) has-error 
                        @elseif(Input::old('cif')) has-success 
                        @endif">
                        <label>CIF</label>
                        <input class="form-control" name="cif" type="text" value="{{ Input::old('cif') }}" 
                        @if ($errors->has('cif')) 
                            title="{{ $errors->first('cif') }}" 
                        @endif>
                    </div>                                                                 
                    <div class="form-group col-lg-6                   
                        @if ($errors->has('num_ord_rc')) has-error 
                        @elseif(Input::old('num_ord_rc')) has-success 
                        @endif">
                        <label>Numarul de ordine in registrul comertului</label>
                        <input class="form-control" name="num_ord_rc" id="num_ord_rc" type="text" value="{{ Input::old('num_ord_rc') }}" 
                        @if ($errors->has('num_ord_rc')) 
                            title="{{ $errors->first('num_ord_rc') }}" 
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

                    <div class="form-group col-lg-12
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

                    <div class="form-group col-lg-12                   
                        @if ($errors->has('adresa')) has-error 
                        @elseif(Input::old('adresa')) has-success 
                        @endif">
                        <label>Adresa</label>
                        <input class="form-control" name="adresa" type="text" value="{{ Input::old('adresa') }}" 
                        @if ($errors->has('adresa')) 
                            title="{{ $errors->first('adresa') }}" 
                        @endif>
                    </div>                                                                 

                    <div class="form-group col-lg-4                   
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
                        @if ($errors->has('telefon')) has-error 
                        @elseif(Input::old('telefon')) has-success 
                        @endif">
                        <label>Telefon</label>
                        <input class="form-control" name="telefon" type="text" value="{{ Input::old('telefon') }}" 
                        @if ($errors->has('telefon')) 
                            title="{{ $errors->first('telefon') }}" 
                        @endif>
                    </div>                                                                 

                    <div class="form-group col-lg-4                   
                        @if ($errors->has('fax')) has-error 
                        @elseif(Input::old('fax')) has-success 
                        @endif">
                        <label>Fax</label>
                        <input class="form-control" name="fax" type="text" value="{{ Input::old('fax') }}" 
                        @if ($errors->has('fax')) 
                            title="{{ $errors->first('fax') }}" 
                        @endif>
                    </div>                                                                 
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('servicii')) has-error 
                        @elseif(Input::old('servicii')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                            {{ Form::checkbox('servicii', '1', Input::old('servicii', '')) }}
                            <label for="servicii" class="label_check">Poate realiza servicii</label>
                        </div>
                    </div>             

                    <div class="form-group col-lg-4                   
                        @if ($errors->has('lucrari')) has-error 
                        @elseif(Input::old('lucrari')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                            {{ Form::checkbox('lucrari', '1', Input::old('lucrari', '')) }}
                            <label for="lucrari" class="label_check">Poate realiza lucrari</label>
                        </div>
                    </div>             

                    <div class="form-group col-lg-4                   
                        @if ($errors->has('furnizare')) has-error 
                        @elseif(Input::old('furnizare')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                            {{ Form::checkbox('furnizare', '1', Input::old('furnizare', '')) }}
                            <label for="furnizare" class="label_check">Poate realiza furnizare</label>
                        </div>
                    </div>             

                    <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Salveaza" />
                    {{ Form::token() }}
                </fieldset>
            </form>
        </div>
    </div>
@stop

@section('footer_scripts')
    {{ HTML::script('assets/js/segmentare.js') }}
    <script>        
        $('#tip_entitate').change(function()
        {        
            if ($(this).val() == 2) 
            {
                $('#num_ord_rc').val('');
                $('#num_ord_rc').attr("disabled", "disabled");                            
            } else {
                $('#num_ord_rc').removeAttr("disabled");
            }
        });
        
        $(document).ready(function(){       
            var tari = getTari();
            console.log(tari);
            tari = JSON.parse(tari);
            console.log(tari);
            $("#tara").empty().append('<option value="0">Selecteaza o tara</option>');                
            for (var key in tari) {
                if (tari.hasOwnProperty(key)) {                
                    $("#tara").append('<option value="' + 
                        tari[key].id_tara+'">' + 
                        tari[key].denumire + '</option>');                
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
                        regiuni[key].id_regiune+'">' + 
                        regiuni[key].denumire + '</option>');                
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
                        judete[key].id_judet+'">' + 
                        judete[key].denumire + '</option>');                
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
                        localitati[key].id_localitate+'">' + 
                        localitati[key].denumire + '</option>');                
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