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

                    <div class="col-md-4">
                        {{ Form::textField('Numar contract', 'numar') }}                    
                    </div> 

                    <div class="col-md-4">
                        {{ Form::textField('Data semnarii', 'data_semnare', null, ['class'=>'form-control date1'], '<i class="fa fa-calendar"></i>') }}                    
                    </div>

                    <div class="col-md-4">
                        {{ Form::selectField('Tip contract', 'tip_contract', $tipuri_contract) }}                    
                    </div>

                    <div class="col-md-12">
                        {{ Form::textField('Denumire', 'denumire') }}                    
                    </div>            

                    <div class="col-md-12">
                        {{ Form::selectField('Al carui departament este contractul?', 'departament', $departamente) }}                    
                    </div> 

                    <div class="col-md-12">
                        {{ Form::selectField('Parte in contract (partea pe care o reprezinta firma din grup in acest contract)', 'parte_in_contract', $parti_contract) }}                    
                    </div>                                          
  
                    <div class="col-md-12">
                        {{ Form::selectField('Partener al grupului / Entitate publica', 'partener_organizatie', ['' => 'Selecteaza entitate'] + $parteneri) }}                    
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
         
                    <div class="col-md-3">
                        {{ Form::textNumericField('Durata contract', 'durata_contract') }}                    
                    </div> 
                    
                    <div class="col-md-3">
                        {{ Form::selectField('Unitate de masura de timp', 'um_timp', $ums_timp) }}                    
                    </div>   
                     
                    @if (Entrust::can('manage_finance'))                                         
                        <div class="col-md-3">
                            {{ Form::textNumericField('Valoare fara TVA', 'valoare_contract') }}                    
                        </div>

                        <div class="col-md-3">
                            {{ Form::textNumericField('Procent TVA(%)', 'procent_tva') }}                    
                        </div> 
                    @endif
                                                                    
                    <div class="col-md-12 center"> 
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" />
                        <a href="{{ URL::route('contract_list') }}">
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
                    if (tari[key].id_tara == 169)
                    {              
                        $("#tara").append('<option selected value="' + 
                            tari[key].id_tara+'">' + 
                            tari[key].denumire + '</option>');                
                    }
                    else
                    {
                        $("#tara").append('<option value="' + 
                            tari[key].id_tara+'">' + 
                            tari[key].denumire + '</option>');                                        
                    }
                }            
            }
            $("#tara").change();
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
            $( ".date1" ).datepicker({ minDate: new Date(2010, 1, 1), dateFormat: "dd-mm-yy"
            });                 
        });

    </script>
@stop