@extends('layouts.master')

@section('title')
    @if($tip_entitate == 1)
        <p>Modifica date firma ce apartine organizatiei</p>
    @elseif($tip_entitate == 2)        
        <p>Modifica date client partener al organizatiei</p>
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
                                        {{ Form::textField('Denumire', 'denumire', $entitate->denumire) }}                    
                                    </div> 
                                    <div class="col-md-4">
                                        {{ Form::textField('CIF', 'cif', $entitate->cif) }}                    
                                    </div>                                                                
                                    <div class="col-md-4">
                                        {{ Form::textField('Numarul de ordine in registrul comertului', 'num_ord_rc', $entitate->norc) }}                    
                                    </div>                                                                                                        
                                    <div class="col-md-4">
                                        {{ Form::textField('Anul infiintarii', 'an_infiintare', $entitate->an_infiintare) }}                    
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
                                            <option   
                                            @if(Input::old('tara')) 
                                                value="{{ Input::old('tara') }}"                                   
                                            @else 
                                                value="{{ $entitate->id_tara }}" 
                                            @endif>{{ $entitate->tara }}
                                            </option>                            
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
                                            <option   
                                            @if(Input::old('regiune')) 
                                                value="{{ Input::old('regiune') }}"                                   
                                            @else 
                                                value="{{ $entitate->id_regiune }}" 
                                            @endif>{{ $entitate->regiune }}
                                            </option>                                    
                                        </select>        
                                    </div>

                                    <div class="form-group col-lg-4
                                        @if($errors->has('judet')) has-error 
                                        @elseif(Input::old('judet')) has-success 
                                        @endif ">
                                        <label for = "">Judet</label>
                                        <select 
                                            name="judet" 
                                            id="judet" 
                                            class="selectpicker form-control" 
                                            data-live-search="true">
                                            <option   
                                            @if(Input::old('judet')) 
                                                value="{{ Input::old('judet') }}"                                   
                                            @else 
                                                value="{{ $entitate->id_judet }}" 
                                            @endif>{{ $entitate->judet }}
                                            </option>                                    
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
                                            <option   
                                            @if(Input::old('localitate')) 
                                                value="{{ Input::old('localitate') }}"                                   
                                            @else 
                                                value="{{ $entitate->id_localitate }}" 
                                            @endif>{{ $entitate->localitate }}
                                            </option>                                              
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        {{ Form::textField('Adresa', 'adresa', $entitate->adresa) }}                    
                                    </div>                                                                 
                                    <div class="col-md-4">
                                        {{ Form::textField('Cod postal', 'cod_postal', $entitate->cod_postal) }}                    
                                    </div> 
                                    <div class="col-md-4">
                                        {{ Form::textField('Telefon', 'telefon', $entitate->telefon) }}                    
                                    </div>                 
                                    <div class="col-md-4">
                                        {{ Form::textField('Fax', 'fax', $entitate->fax) }}                    
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
                                        {{ Form::selectField('Tip intreprindere', 'tip_intreprindere', ['' => 'Click pentru a alege'] + $tip_intreprindere, $entitate->id_tip_intreprindere) }}                    
                                    </div> 

                                    <div class="col-md-4">
                                        {{ Form::selectField('Marime intreprindere', 'marime_intreprindere', ['' => 'Click pentru a alege'] + $marime_intreprindere, $entitate->id_marime_intreprindere) }}                    
                                    </div>

                                    <div class="col-md-4">
                                        {{ Form::textNumericField('Capital social', 'capital_social', $entitate->capital_social) }}                    
                                    </div>                                                                                                                         
                                    
                                    <div class="col-md-4">
                                        {{ Form::textNumericField('Procent din capitalul social detinut de persoane fizice', 'procent_cs_pf', $entitate->procent_cs_pf) }}                    
                                    </div> 
                                    <div class="col-md-4">
                                        {{ Form::textNumericField('Procent din capitalul social detinut de IMM-uri', 'procent_cs_imm', $entitate->procent_cs_imm) }}                    
                                    </div>                     
                                    <div class="col-md-4">
                                        {{ Form::textNumericField('Procent din capitalul social detinut de SCM-uri', 'procent_cs_scm', $entitate->procent_cs_scm) }}                    
                                    </div> 
                                    <div class="form-group col-lg-12                   
                                        @if ($errors->has('servicii')) has-error                                             
                                        @elseif(Input::old('servicii')) has-success 
                                        @endif">
                                        <div class="checkbox checkbox-primary">
                                            {{ Form::checkbox('servicii', '1', Input::old('servicii', $entitate->servicii)) }}
                                            <label for="servicii" class="label_check">Poate realiza servicii</label>
                                        </div>
                                    </div>             

                                    <div class="form-group col-lg-12                   
                                        @if ($errors->has('lucrari')) has-error 
                                        @elseif(Input::old('lucrari')) has-success 
                                        @endif">
                                        <div class="checkbox checkbox-primary">
                                            {{ Form::checkbox('lucrari', '1', Input::old('lucrari', $entitate->lucrari)) }}
                                            <label for="lucrari" class="label_check">Poate realiza lucrari</label>
                                        </div>
                                    </div>             

                                    <div class="form-group col-lg-12                   
                                        @if ($errors->has('furnizare')) has-error 
                                        @elseif(Input::old('furnizare')) has-success 
                                        @endif">
                                        <div class="checkbox checkbox-primary">
                                            {{ Form::checkbox('furnizare', '1', Input::old('furnizare', $entitate->furnizare)) }}
                                            <label for="furnizare" class="label_check">Poate realiza furnizare</label>
                                        </div>
                                    </div>             
                                    
                                    <div class="form-group col-lg-12                   
                                        @if ($errors->has('platitor_tva')) has-error 
                                        @elseif(Input::old('platitor_tva')) has-success 
                                        @endif">
                                        <div class="checkbox checkbox-primary">
                                            {{ Form::checkbox('platitor_tva', '1', Input::old('platitor_tva', $entitate->platitor_tva)) }}
                                            <label for="platitor_tva" class="label_check">Platitor de TVA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                                                                                     

                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#informatii-statistice" data-parent="#accordion" data-toggle="collapse" class="collapsed" aria-expanded="false">
                                        <i class="fa fa-plus-square"></i> 
                                        Informatii statistice</a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse" id="informatii-statistice" aria-expanded="false" style="height: 0px;">
                                <div class="panel-body">
                                  <table class="table table-striped table-bordered table-hover" id="dataTables-entitati_publice">
                                    <thead>
                                      <tr>                                   
                                        <th class="text-center">An</th>                      
                                        <th class="text-center">Numar angajati</th>
                                        <th class="text-center">Cifra afaceri</th>
                                        <th class="text-center">Profit exploatare</th>
                                        <th class="text-center">Venituri</th>
                                        <th class="text-center">Active totale</th>
                                        <th class="text-center">Cheltuieli cercetare</th>  
                                        <th class="text-center">Actiuni</th>
                                      </tr>
                                    </thead>
                                    <tbody>                             
                                      @foreach ($informatii_statistice as $informatie)
                                        <tr data-id="{{ $informatie->id }}">
                                          <td class="text-center">{{ $informatie->an }}</td>
                                          <td class="text-center">{{ $informatie->num_angajati }}</td>
                                          <td class="text-right">{{ number_format($informatie->cifra_afaceri, 2, ',', '.') }}</td>
                                          <td class="text-right">{{ number_format($informatie->profit_exploatare, 2, ',', '.') }}</td>
                                          <td class="text-right">{{ number_format($informatie->venituri, 2, ',', '.') }}</td>
                                          <td class="text-right">{{ number_format($informatie->active_totale, 2, ',', '.') }}</td>
                                          <td class="text-right">{{ number_format($informatie->cheltuieli_cercetare, 2, ',', '.') }}</td>

                                          <td class="center action-buttons">
                                            <a href="{{ URL::route('informatii_statistice_edit', [$informatie->id, $entitate->id, $entitate->denumire]) }}">
                                              <i class="fa fa-pencil-square-o" 
                                              title="Vizualizeaza sau modifica"></i>
                                            </a>                                            
                                          </td>                                  
                                        </tr>
                                      @endforeach                             
                                    </tbody>
                                  </table>          
                    
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
            var valoare_anterioara = $('#tara').val();
            $("#tara").empty().append('<option value="0">Selecteaza o tara</option>');                
            for (var key in tari) {
                if (tari.hasOwnProperty(key)) {
                    if (tari[key].id_tara.toString() === valoare_anterioara)
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