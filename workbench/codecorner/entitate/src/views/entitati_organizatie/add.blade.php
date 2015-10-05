@extends('layouts.master')

@section('title')
    @if($tip_entitate == 1)
        <p>Adauga firma ce apartine organizatiei</p>
    @elseif($tip_entitate == 2)        
        <p>Adauga client partener al organizatiei</p>
    @endif        
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div id="accordion" class="panel-group">                                                                            
                <form role="form" action="{{ URL::current() }}" method="post">
                    <fieldset>
                        @if(Session::has('message'))
                            <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                        @endif
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#detalii-identificare" data-parent="#accordion" data-toggle="collapse">
                                        <i class="fa fa-minus-square"></i>
                                        Detalii de identificare</a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse in" id="detalii-identificare">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        {{ Form::textField('Denumire', 'denumire') }}                    
                                    </div> 
                                    <div class="col-md-4">
                                        {{ Form::textField('CIF', 'cif') }}                    
                                    </div>                                                                
                                    <div class="col-md-4">
                                        {{ Form::textField('Numarul de ordine in registrul comertului', 'num_ord_rc') }}                    
                                    </div>                                                      
                                    <div class="col-md-4">
                                        {{ Form::textField('Anul infiintarii', 'an_infiintare') }}
                                    </div>                                                                                          
                                </div>
                            </div>
                        </div>                                          
               
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#date-contact" data-parent="#accordion" data-toggle="collapse" class="collapsed" aria-expanded="false">
                                        <i class="fa fa-plus-square"></i>
                                        Sediu si date de contact</a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse" id="date-contact" aria-expanded="false" style="height: 0px;">
                                <div class="panel-body">
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
                                    <div class="col-md-12">
                                        {{ Form::textField('Adresa', 'adresa') }}                    
                                    </div>                                                                 
                                    <div class="col-md-4">
                                        {{ Form::textField('Cod postal', 'cod_postal') }}                    
                                    </div> 
                                    <div class="col-md-4">
                                        {{ Form::textField('Telefon', 'telefon') }}                    
                                    </div>                 
                                    <div class="col-md-4">
                                        {{ Form::textField('Fax', 'fax') }}                    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#domeniu-activitate" data-parent="#accordion" data-toggle="collapse" class="collapsed" aria-expanded="false">
                                        <i class="fa fa-plus-square"></i> 
                                        Detalii suplimentare</a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse" id="domeniu-activitate" aria-expanded="false" style="height: 0px;">
                                <div class="panel-body">
                                    <div class="col-md-4">
                                        {{ Form::selectField('Tip intreprindere', 'tip_intreprindere', ['' => 'Click pentru a alege'] + $tip_intreprindere) }}                    
                                    </div> 

                                    <div class="col-md-4">
                                        {{ Form::selectField('Marime intreprindere', 'marime_intreprindere', ['' => 'Click pentru a alege'] + $marime_intreprindere) }}                    
                                    </div>

                                    <div class="col-md-4">
                                        {{ Form::textNumericField('Capital social', 'capital_social') }}                    
                                    </div>                                                                                                                         
                                    
                                    <div class="col-md-4">
                                        {{ Form::textNumericField('Procent din capitalul social detinut de persoane fizice', 'procent_cs_pf') }}                    
                                    </div> 
                                    <div class="col-md-4">
                                        {{ Form::textNumericField('Procent din capitalul social detinut de IMM-uri', 'procent_cs_imm') }}                    
                                    </div>                     
                                    <div class="col-md-4">
                                        {{ Form::textNumericField('Procent din capitalul social detinut de SCM-uri', 'procent_cs_scm') }}                    
                                    </div> 
                                    <div class="form-group col-lg-12                   
                                        @if ($errors->has('servicii')) has-error                                             
                                        @elseif(Input::old('servicii')) has-success 
                                        @endif">
                                        <div class="checkbox checkbox-primary">
                                            {{ Form::checkbox('servicii', '1', Input::old('servicii', '')) }}
                                            <label for="servicii" class="label_check">Poate realiza servicii</label>
                                        </div>
                                    </div>             

                                    <div class="form-group col-lg-12                   
                                        @if ($errors->has('lucrari')) has-error 
                                        @elseif(Input::old('lucrari')) has-success 
                                        @endif">
                                        <div class="checkbox checkbox-primary">
                                            {{ Form::checkbox('lucrari', '1', Input::old('lucrari', '')) }}
                                            <label for="lucrari" class="label_check">Poate realiza lucrari</label>
                                        </div>
                                    </div>             

                                    <div class="form-group col-lg-12                   
                                        @if ($errors->has('furnizare')) has-error 
                                        @elseif(Input::old('furnizare')) has-success 
                                        @endif">
                                        <div class="checkbox checkbox-primary">
                                            {{ Form::checkbox('furnizare', '1', Input::old('furnizare', '')) }}
                                            <label for="furnizare" class="label_check">Poate realiza furnizare</label>
                                        </div>
                                    </div>             
                                    
                                    <div class="form-group col-lg-12                   
                                        @if ($errors->has('platitor_tva')) has-error 
                                        @elseif(Input::old('platitor_tva')) has-success 
                                        @endif">
                                        <div class="checkbox checkbox-primary">
                                            {{ Form::checkbox('platitor_tva', '1', Input::old('platitor_tva', '')) }}
                                            <label for="platitor_tva" class="label_check">Platitor de TVA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                    

                        <div class="col-md-12 center top24"> 
                            <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" />
                            <a href="{{ URL::route('entitati_organizatie_list', $tip_entitate) }}">
                                <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
                            </a>                         
                        </div>
                        {{ Form::token() }}
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@stop

@section('footer_scripts')
    {{ HTML::script('assets/js/segmentare.js') }}
    <script>        
        $(document).ready(function(){  
            $("body").on('click', ".panel-title a", function() {
                $(this).find('i').toggleClass('fa-plus-square fa-minus-square');
            });

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
            $("#judet").empty();
            $("#localitate").empty();
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
            $("#localitate").empty();
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