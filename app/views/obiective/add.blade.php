@extends('layouts.master')

@section('title')
    <p>Adauga obiectiv</p>
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
                        <label>Numar obiectiv</label>
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
                        @if($errors->has('template')) has-error 
                        @elseif(Input::old('template')) has-success 
                        @endif ">
                        <label for = "">Template</label>
                        <select name="template" id="template" 
                        class="selectpicker form-control" data-live-search="true">
                            <option value="0">Selectioneaza template-ul pe baza caruia se creeaza obiectivul</option>
                            @foreach ($templates as $template) 
                                <option value="{{ $template->id_template }}" @if (Input::old('template')) selected @endif>{{ $template->denumire }}</option>
                            @endforeach                            
                        </select>
                    </div>                                                                                                                                             
                    <div class="form-group col-lg-12
                        @if($errors->has('contract')) has-error 
                        @elseif(Input::old('contract')) has-success 
                        @endif ">
                        <label for = "">Contractul de care apatine acest obiectiv</label>
                        <select name="contract" id="contract" 
                        class="selectpicker form-control" data-live-search="true"
                            @if ($contract_selectionat !== null) 
                                disabled 
                            @endif>
                            <option value="0">Selectioneaza contractul de care apartine acest obiectiv</option>
                            @foreach ($contracte as $contract) 
                                <option value="{{ $contract->id_contract }}" 
                                    @if (Input::old('contract') || ($contract->id_contract == $contract_selectionat)) selected 
                                    @endif>{{ $contract->denumire }}</option>
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
                        @if ($errors->has('valoare_obiectiv')) has-error 
                        @elseif(Input::old('valoare_obiectiv')) has-success 
                        @endif">
                        <label>Valoare fara TVA</label>
                        <input class="form-control auto text-right" name="valoare_obiectiv" type="text" data-a-dec="," data-a-sep="." value="{{ Input::old('valoare_obiectiv') }}" 
                        @if ($errors->has('valoare_obiectiv')) 
                            title="{{ $errors->first('valoare_obiectiv') }}" 
                        @endif>
                    </div>                                                                 
                    <div class="form-group col-lg-4                   
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
    {{ HTML::script('segmentare.js') }}
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
            $( ".date1" ).datepicker({ minDate: 0, dateFormat: "dd-mm-yy" });         
        });
    </script>
@stop