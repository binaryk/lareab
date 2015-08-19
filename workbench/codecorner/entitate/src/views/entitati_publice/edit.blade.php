@extends('layouts.master')

@section('title')
    <p>Modifica date  
        @if(isset($entitate->denumire)) {{ $entitate->denumire }} @endif
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
                                                   
                    <div class="col-md-12">
                        {{ Form::textField('Denumire', 'denumire', $entitate->denumire) }}                    
                    </div> 
                                                                  
                    <div class="col-md-3">
                        {{ Form::textField('CIF', 'cif', $entitate->cif) }}                    
                    </div>                                                                
                                                                
                    <div class="form-group col-lg-3
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
                    <div class="form-group col-lg-3
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
                    <div class="form-group judet col-lg-3
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
                                                                       
                    <div class="col-md-12 center top24"> 
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" />
                        <a href="{{ URL::route('entitati_publice_list') }}">
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