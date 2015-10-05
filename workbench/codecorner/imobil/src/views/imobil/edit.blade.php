@extends('layouts.master')

@section('title')
    <p>Modifica date imobil</p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif                  
                    <div class="col-md-8">
                        {{ Form::textField('Adresa', 'adresa', $imobil->adresa) }}                    
                    </div> 
                    <div class="col-md-2">
                        {{ Form::textField('Numar apartamente', 'numar_apartamente', $imobil->numar_apartamente) }}                    
                    </div>                     
                    <div class="col-md-2">
                        {{ Form::textField('Suprafata utila masurata', 'suprafata_utila_masurata', $imobil->suprafata_utila_masurata) }}                    
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
                            <option   
                            @if(Input::old('tara')) 
                                value="{{ Input::old('tara') }}"                                   
                            @else 
                                value="{{ $imobil->id_tara }}" 
                            @endif>{{ $imobil->id_tara }}
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
                                value="{{ $imobil->id_regiune }}" 
                            @endif>{{ $imobil->id_regiune }}
                            </option>                                    
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
                            <option   
                            @if(Input::old('judet')) 
                                value="{{ Input::old('judet') }}"                                   
                            @else 
                                value="{{ $imobil->id_judet }}" 
                            @endif>{{ $imobil->id_judet }}
                            </option>                                    
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
                            <option   
                            @if(Input::old('localitate')) 
                                value="{{ Input::old('localitate') }}"                                   
                            @else 
                                value="{{ $imobil->id_localitate }}" 
                            @endif>{{ $imobil->id_localitate }}
                            </option>                                              
                        </select>
                    </div>                                                              

                    <div class="col-md-2">
                        {{ Form::textField('Cod postal', 'cod_postal', $imobil->cod_postal) }}                    
                    </div> 
                    <div class="col-md-12">
                        {{ Form::textareaField('Observatii', 'observatii', $imobil->observatii) }}                    
                    </div>                                                                
                
                    <div class="col-md-12 center top24"> 
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" />
                        <a href="{{ URL::route('imobile_list') }}">
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
            tari = JSON.parse(tari);
            var tara_selectionata = $("#tara").val();
            var sel = "";
            $("#tara").empty().append('<option value="0">Selecteaza o tara</option>');                
            for (var key in tari) {
                if (tari.hasOwnProperty(key)) { 
                    if (tari[key].id_tara.toString() == tara_selectionata) sel = "selected"
                    else sel = "";
                    $("#tara").append('<option value="' + 
                        tari[key].id_tara +'" '+ sel +'>' + 
                        tari[key].denumire + '</option>');                
                }            
            }
            $("#tara").trigger("change");          
        })
          
        $('#tara').change(function(){
            var functie = 'getRegiuni_tara_' + $(this).val().toString();
            console.log(functie);
            var fn = window[functie];
            var regiuni = null;
            if (typeof fn === "function") 
                regiuni = fn();            
                       
            regiuni = JSON.parse(regiuni);
            var regiune_selectionata = $("#regiune").val();
            var sel = "";
            $("#regiune").empty().append('<option value="0">Selecteaza o regiune</option>');                
            for (var key in regiuni) {
                if (regiuni.hasOwnProperty(key)) {    
                    if (regiuni[key].id_regiune.toString() == regiune_selectionata) sel = "selected"
                    else sel = "";
                    $("#regiune").append('<option value="' + 
                        regiuni[key].id_regiune+'" '+ sel +'>' + 
                        regiuni[key].denumire + '</option>');                
                }            
            }
            $("#regiune").trigger("change"); 
        });   

        $('#regiune').change(function(){
            var functie = 'getJudete_regiune_' + $(this).val().toString();
            console.log(functie);
            var fn = window[functie];
            var judete = null;
            if (typeof fn === "function") 
                judete = fn();            
   
            judete = JSON.parse(judete);
            var judet_selectionata = $("#judet").val();
            var sel = "";            
            $("#judet").empty().append('<option value="0">Selecteaza un judet</option>');                
            for (var key in judete) {
                if (judete.hasOwnProperty(key)) { 
                    if (judete[key].id_judet.toString() == judet_selectionata) sel = "selected"
                    else sel = "";                               
                    $("#judet").append('<option value="' + 
                        judete[key].id_judet+'" '+ sel +'>' + 
                        judete[key].denumire + '</option>');                
                }            
            }
            $("#judet").trigger("change");
        });   

        $('#judet').change(function(){
            var functie = 'getLocalitati_judet_' + $(this).val().toString();
            console.log(functie);
            var fn = window[functie];
            var localitati = null;
            if (typeof fn === "function") 
                localitati = fn();            

            localitati = JSON.parse(localitati);
            var localitate_selectionata = $("#localitate").val();
            var sel = "";            
            $("#localitate").empty().append('<option value="0">Selecteaza o localitate</option>');                
            for (var key in localitati) {
                if (localitati.hasOwnProperty(key)) {           
                    if (localitati[key].id_localitate.toString() == localitate_selectionata) sel = "selected"
                    else sel = "";                                                   
                    $("#localitate").append('<option value="' + 
                        localitati[key].id_localitate+'" '+ sel +'>' + 
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