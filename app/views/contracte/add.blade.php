@extends('layouts.master')

@section('title')
    <p>Adauga contract</p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif               
                    <div class="form-group col-lg-6                   
                        @if ($errors->has('numar')) has-error 
                        @elseif(Input::old('numar')) has-success 
                        @endif">
                        <label>Numar contract</label>
                        <input class="form-control" name="numar" type="text" value="{{ Input::old('numar') }}" 
                        @if ($errors->has('numar')) 
                            title="{{ $errors->first('numar') }}" 
                        @endif>
                    </div>
                    <div class="col-lg-6 margin-bottom">
                        <label>Data semnarii</label>
                        <div class="input-group 
                        @if ($errors->has('data_semnare')) has-error 
                        @elseif(Input::old('data_semnare')) has-success 
                        @endif">
                            <input 
                                class="form-control date1" 
                                name="data_semnare" 
                                data-placement="top" 
                                placeholder="Data semnarii" 
                                type="text" 
                                value="{{ Input::old('data_semnare') }}" 
                                @if ($errors->has('data_semnare')) 
                                title="{{ $errors->first('data_semnare') }}" 
                                @endif />
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
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
                    <div class="form-group col-lg-12
                        @if($errors->has('entitate_organizatie')) has-error 
                        @elseif(Input::old('entitate_organizatie')) has-success 
                        @endif ">
                        <label for = "">Firma ce apartine grupului (organizatiei)</label>
                        <select name="entitate_organizatie" id="entitate_organizatie" 
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Selectioneaza firma care semneaza contractul</option>
                            @foreach ($entitati_organizatie as $entitate_organizatie) 
                                <option value="{{ $entitate_organizatie->id_entitate }}" @if (Input::old('entitate_organizatie')) selected @endif>{{ $entitate_organizatie->denumire }}</option>
                            @endforeach                            
                        </select>
                    </div>                                                                                                                          
                    <div class="form-group col-lg-12
                        @if($errors->has('parte_in_contract')) has-error 
                        @elseif(Input::old('parte_in_contract')) has-success 
                        @endif ">
                        <label for = "">Parte in contract (partea pe care o reprezinta firma din grup in acest contract)</label>
                        <select name="parte_in_contract" id="parte_in_contract" 
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Ce parte este firma care semneaza contractul</option>
                            @foreach ($parti_contract as $parte_in_contract) 
                                <option value="{{ $parte_in_contract->id_tip_nivel }}" @if (Input::old('parte_in_contract')) selected @endif>{{ $parte_in_contract->denumire }}</option>
                            @endforeach                            
                        </select>
                    </div>                      
                    <div class="form-group col-lg-12
                        @if($errors->has('partener_organizatie')) has-error 
                        @elseif(Input::old('partener_organizatie')) has-success 
                        @endif ">
                        <label for = "">Partener al grupului (organizatiei)</label>
                        <select name="partener_organizatie" id="partener_organizatie" 
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Selectioneaza entitatea care semneaza contractul</option>
                            @foreach ($parteneri_organizatie as $partener_organizatie) 
                                <option value="{{ $partener_organizatie->id_entitate }}" @if (Input::old('partener_organizatie')) selected @endif>{{ $partener_organizatie->denumire }} (FIRMA)</option>
                            @endforeach                            
                            @foreach ($entitati_publice as $entitate_publica) 
                                <option value="{{ $entitate_publica->id_entitate }}" @if (Input::old('partener_organizatie')) selected @endif>{{ $entitate_publica->denumire }} (UAT)</option>
                            @endforeach                            
                        </select>
                    </div>       
                    <div class="form-group col-lg-6
                        @if($errors->has('stadiu_contract')) has-error 
                        @elseif(Input::old('stadiu_contract')) has-success 
                        @endif ">
                        <label for = "">Stadiu contract</label>
                        <select name="stadiu_contract" id="stadiu_contract" 
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Selectioneaza stadiu contract</option>
                            @foreach ($stadii_contract as $stadiu_contract) 
                                <option value="{{ $stadiu_contract->id_stadiu_contract }}" @if (Input::old('stadiu_contract')) selected @endif>{{ $stadiu_contract->denumire }}</option>
                            @endforeach                            
                        </select>
                    </div>  

                    <div class="form-group col-lg-6
                        @if($errors->has('tip_contract')) has-error 
                        @elseif(Input::old('tip_contract')) has-success 
                        @endif ">
                        <label for = "">Tip contract</label>
                        <select name="tip_contract" id="tip_contract" 
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Selectioneaza tip contract</option>
                            @foreach ($tipuri_contract as $tip_contract) 
                                <option value="{{ $tip_contract->id_tip_contract }}" @if (Input::old('tip_contract')) selected @endif>{{ $tip_contract->denumire }}</option>
                            @endforeach                            
                        </select>
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

                    <div class="form-group col-lg-3                   
                        @if ($errors->has('durata_contract')) has-error 
                        @elseif(Input::old('durata_contract')) has-success 
                        @endif">
                        <label>Durata contract</label>
                        <input class="form-control" name="durata_contract" type="number" value="{{ Input::old('durata_contract') }}" 
                        @if ($errors->has('durata_contract')) 
                            title="{{ $errors->first('durata_contract') }}" 
                        @endif>
                    </div>                                                                 
                    
                    <div class="form-group col-lg-3
                        @if($errors->has('um_timp')) has-error 
                        @elseif(Input::old('um_timp')) has-success 
                        @endif ">
                        <label for = "">Unitate de masura de timp</label>
                        <select name="um_timp" id="um_timp" 
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Selectioneaza unitatea de masura de timp</option>
                            @foreach ($ums_timp as $um_timp) 
                                <option value="{{ $um_timp->id_um }}" @if (Input::old('um_timp')) selected @endif>{{ $um_timp->denumire }}</option>
                            @endforeach                            
                        </select>
                    </div>      
                                                             
                    <div class="form-group col-lg-3                   
                        @if ($errors->has('valoare_contract')) has-error 
                        @elseif(Input::old('valoare_contract')) has-success 
                        @endif">
                        <label>Valoare fara TVA</label>
                        <input class="form-control auto text-right" name="valoare_contract" type="text" data-a-dec="," data-a-sep="." value="{{ Input::old('valoare_contract') }}" 
                        @if ($errors->has('valoare_contract')) 
                            title="{{ $errors->first('valoare_contract') }}" 
                        @endif>
                    </div>                                                                 

                    <div class="form-group col-lg-3                   
                        @if ($errors->has('procent_tva')) has-error 
                        @elseif(Input::old('procent_tva')) has-success 
                        @endif">
                        <label>Procent TVA(%)</label>
                        <input class="form-control auto text-right" name="procent_tva" type="text" data-a-dec="," data-a-sep="." value="{{ Input::old('procent_tva') }}" 
                        @if ($errors->has('procent_tva')) 
                            title="{{ $errors->first('procent_tva') }}" 
                        @endif>
                    </div>                                                                   
                    <div class="form-group col-lg-12 text-center">               
                        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Salveaza" />
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
            console.log(cod_postal);                       
            $("#cod_postal").val(cod_postal);
        });

        $(function() {
            $( ".date1" ).datepicker({ minDate: 0, dateFormat: "dd-mm-yy"
            });         
        });
    </script>
@stop