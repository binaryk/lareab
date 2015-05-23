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
                    <div class="form-group col-lg-12                    
                        @if ($errors->has('adresa')) has-error 
                        @elseif(Input::old('adresa')) has-success 
                        @endif">
                        <label>Adresa</label>
                        <input class="form-control" name="adresa" type="text"
                        @if(Input::old('adresa')) 
                            value="{{ Input::old('adresa') }}" 
                        @else 
                            value="{{ $imobil->adresa }}" 
                        @endif
                        @if ($errors->has('adresa')) 
                            title="{{ $errors->first('adresa') }}" 
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

                    <div class="form-group col-lg-2
                        @if ($errors->has('cod_postal')) has-error 
                        @elseif(Input::old('cod_postal')) has-success 
                        @endif">
                        <label>Cod postal</label>
                        <input class="form-control" name="cod_postal" type="text" id="cod_postal"
                        @if(Input::old('cod_postal')) 
                            value="{{ Input::old('cod_postal') }}" 
                        @else 
                            value="{{ $imobil->cod_postal }}" 
                        @endif 
                        @if ($errors->has('cod_postal')) 
                            title="{{ $errors->first('cod_postal') }}" 
                        @endif>
                    </div>                                                                 
                                                                
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('lot')) has-error 
                        @elseif(Input::old('lot')) has-success 
                        @endif">
                        <label>Lot</label>
                        <input class="form-control" name="lot" type="text" id="lot"
                        @if(Input::old('lot')) 
                            value="{{ Input::old('lot') }}" 
                        @else 
                            value="{{ $imobil->lot }}" 
                        @endif 
                        @if ($errors->has('lot')) 
                            title="{{ $errors->first('lot') }}" 
                        @endif>
                    </div>                                                                 
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('numar_lot')) has-error 
                        @elseif(Input::old('numar_lot')) has-success 
                        @endif">
                        <label>Numar lot</label>
                        <input class="form-control" name="numar_lot" type="text" id="numar_lot"
                        @if(Input::old('numar_lot')) 
                            value="{{ Input::old('numar_lot') }}" 
                        @else 
                            value="{{ $imobil->numar_lot }}" 
                        @endif 
                        @if ($errors->has('numar_lot')) 
                            title="{{ $errors->first('numar_lot') }}" 
                        @endif>
                    </div>                                                                 
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('numar_apartamente')) has-error 
                        @elseif(Input::old('numar_apartamente')) has-success 
                        @endif">
                        <label>Numar apartamente</label>
                        <input class="form-control" name="numar_apartamente" type="text" id="numar_apartamente"
                        @if(Input::old('numar_apartamente')) 
                            value="{{ Input::old('numar_apartamente') }}" 
                        @else 
                            value="{{ $imobil->numar_apartamente }}" 
                        @endif 
                        @if ($errors->has('numar_apartamente')) 
                            title="{{ $errors->first('numar_apartamente') }}" 
                        @endif>
                    </div>                                                                 
                    <div class="form-group col-lg-12                   
                        @if ($errors->has('observatii')) has-error 
                        @elseif(Input::old('observatii')) has-success 
                        @endif">
                        <label>Observatii</label>
                        <input class="form-control" name="observatii" type="text" id="observatii"
                        @if(Input::old('observatii')) 
                            value="{{ Input::old('observatii') }}" 
                        @else 
                            value="{{ $imobil->observatii }}" 
                        @endif 
                        @if ($errors->has('observatii')) 
                            title="{{ $errors->first('observatii') }}" 
                        @endif>
                    </div>                                                                 
                
                    <div class="form-group col-lg-12">
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
            tari = JSON.parse(tari);
            var tara_selectionata = $("#tara").val();
            var sel = "";
            $("#tara").empty().append('<option value="0">Selecteaza o tara</option>');                
            for (var key in tari) {
                if (tari.hasOwnProperty(key)) { 
                    if (tari[key].IdTara.toString() == tara_selectionata) sel = "selected"
                    else sel = "";
                    $("#tara").append('<option value="' + 
                        tari[key].IdTara +'" '+ sel +'>' + 
                        tari[key].Denumire + '</option>');                
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
                    if (regiuni[key].IdRegiune.toString() == regiune_selectionata) sel = "selected"
                    else sel = "";
                    $("#regiune").append('<option value="' + 
                        regiuni[key].IdRegiune+'" '+ sel +'>' + 
                        regiuni[key].Denumire + '</option>');                
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
                    if (judete[key].IdJudet.toString() == judet_selectionata) sel = "selected"
                    else sel = "";                               
                    $("#judet").append('<option value="' + 
                        judete[key].IdJudet+'" '+ sel +'>' + 
                        judete[key].Denumire + '</option>');                
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
                    if (localitati[key].IdLocalitate.toString() == localitate_selectionata) sel = "selected"
                    else sel = "";                                                   
                    $("#localitate").append('<option value="' + 
                        localitati[key].IdLocalitate+'" '+ sel +'>' + 
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